<?php

namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use common\models\User;
use common\models\Messages;
use common\models\Conversation;
use common\models\Notification;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\mongodb\ActiveRecord;
use yii\mongodb\ActiveQueryInterface;
use yii\mongodb\Query;
use yii\web\Response;

class MessagesController extends FrontendController
{

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
        $messages = Messages::find()
                ->where(['owner' => (string) Yii::$app->user->identity->id])
                ->orWhere(['actor' => (string) Yii::$app->user->identity->id])
                ->all();
        if (!empty($messages))
        {
            if ($messages[0]->owner == (string) Yii::$app->user->identity->id)
                $user = $messages[0]->useractor;
            else
                $user = $messages[0]->userowner;
            return $this->redirect('/tin-nhan/' . $user->slug);
        } else
        {
            return $this->render('index');
        }
    }

    public function actionUser()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
        if (!empty($_GET['notify']))
        {
            $find = Conversation::findOne($_GET['notify']);
            $find->status = 2;
            $find->save();
        }
        $actor = User::find()->where(['slug' => $_GET['slug']])->one();
        $messages = Messages::find()
                ->where(['owner' => (string) Yii::$app->user->id])
                ->orWhere(['actor' => (string) Yii::$app->user->id])
                ->orderBy(['created_at' => SORT_DESC])
                ->all();

        $conversation = [];
        $userm = [];
        if (!empty($actor))
        {
            $messages_user = Messages::find()->where(['owner' => (string) $actor->_id, 'actor' => (string) \Yii::$app->user->id])->orWhere(['actor' => (string) $actor->_id, 'owner' => (string) \Yii::$app->user->identity->id])->one();

            if (!empty($messages_user))
            {
                $conversation = Conversation::find()->where(['message_id' => (string) $messages_user->_id])->orderBy(['created_at' => SORT_ASC])->limit(20)->all();
                $set = Conversation::find()->where(['message_id' => (string) $messages_user->_id, 'set' => 1])->all();
                if (!empty($set))
                {
                    foreach ($set as $value)
                    {
                        $value->set = 2;
                        $value->save();
                    }
                }
            }
            else
            {
                $model = new Messages();
                $model->owner = (string) Yii::$app->user->id;
                $model->actor = (string) $actor->_id;
                $model->publish = Messages::PUBLISH_ACTIVE;
                if ($model->save())
                    return $this->redirect('/tin-nhan/' . $model->useractor->slug);
                $conversation = Conversation::find()->where(['message_id' => (string) $model->_id])->orderBy(['created_at' => SORT_ASC])->limit(20)->all();
            }

            $userm = Messages::find()->where(['owner' => (string) $actor->_id, 'actor' => (string) \Yii::$app->user->identity->id])->orWhere(['actor' => (string) $actor->_id, 'owner' => (string) \Yii::$app->user->identity->id])->one();
        }
        return $this->render('index', ['messages' => $messages, 'messages_user' => $userm, 'actor' => $actor, 'conversation' => $conversation]);
    }

    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['content']))
        {
            $message = Messages::findOne($_POST['message_id']);
            $time = time();
            if (!empty($message))
            {
                $message->status = 1;
                $message->save();
                $conver = new Conversation();
                $conver->actor = $_POST['user_id'];
                $conver->owner = (string) Yii::$app->user->identity->id;
                $conver->message_id = (string) $message->_id;
                $conver->content = $_POST['content'];
                $conver->status = 1;
                $conver->active = 1;
                $conver->set = 1;
                $conver->publish = Conversation::PUBLISH_ACTIVE;
                $model = Conversation::find()->where(['message_id' => $message->id, 'actor' => $_POST['user_id']])->one();
                if (($_POST['conversation_owner'] != (string) Yii::$app->user->id) or empty($model))
                {
                    $conver->date = $time;
                }
                $conver->created_at = $time;
                $max = Conversation::find()->where(['message_id' => $message->id])->max('order');

                if (($_POST['conversation_date'] == date('d', time())) && ($_POST['conversation_owner'] == (string) \Yii::$app->user->id))
                {
                    $conver->order = $max;
                }
                else
                {
                    $conver->order = $max + 1;
                }
                if ($conver->save())
                {
                    return ['message_id' => $conver->message_id, 'content' => $conver->content, 'user_slug' => (string) $conver->owners->_id, 'user_name' => $conver->owners->name, 'user_avatar' => Yii::$app->setting->value('url_file') . '/thumbnails/150-' . $conver->owners->avatar, 'user_time' => date('h:i A', $conver->created_at), 'date' => date('d', $conver->created_at), 'order' => $conver->order, 'empty' => empty($model) ? 0 : 1];
                }
            }
        }
    }

    public function actionConversation($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Conversation::find()->where(['message_id' => $id, 'active' => 1, 'actor' => (string) Yii::$app->user->identity->id])->one();
        if ($model)
        {
            $model->set = 2;
            $model->active = 2;
            $model->save();
            return ['url' => Yii::$app->urlManager->createAbsoluteUrl('tin-nhan/' . $model->owners->slug . '?id=' . (string) $model->_id), 'content' => $model->content, 'user_slug' => (string) $model->owners->_id, 'user_name' => $model->owners->name, 'user_avatar' => Yii::$app->setting->value('url_file') . '/thumbnails/150-' . $model->owners->avatar, 'user_time' => date('h:s d/m/Y', $model->created_at), 'active' => 2, 'date' => date('d', $model->created_at), 'order' => $model->order];
        }
    }

    public function actionList()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $limit = 20;
        if (!empty($_GET['actor']))
            $actor = $_GET['actor'];
        else
            $actor = (string) Yii::$app->user->identity->id;
        $offset = $limit * ($_GET['page'] - 1);
        $query = Conversation::find()->where(['actor' => $actor]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['page']]);
        $model = $query->offset($offset)
                ->limit($limit)
                ->all();
        if (!empty($model))
        {
            $data = [];
            foreach ($model as $value)
            {
                $data[] = ['url' => Yii::$app->urlManager->createAbsoluteUrl('tin-nhan/' . $value->profile->slug), 'avatar' => Yii::$app->setting->value('url_file') . 'thumbnails/150-' . $value->profile->avatar, 'content' => $value->content, 'created_at' => Yii::$app->convert->time($value->created_at)];
            }
            return ['data' => $data, 'page' => $_GET['page'] + 1];
        }
    }

    public function actionActive()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Conversation::find()->where(['actor' => (string) Yii::$app->user->identity->id, 'active' => 1])->all();

        if (!empty($model))
        {
            $data = [];
            foreach ($model as $value)
            {
                $value->active = 2;
                $value->save();
                $data[] = ['url' => Yii::$app->urlManager->createAbsoluteUrl('tin-nhan/' . $value->owners->slug), 'user_name' => $value->owners->name, 'avatar' => Yii::$app->setting->value('url_file') . 'thumbnails/150-' . $value->owners->avatar, 'content' => $value->content, 'created_at' => Yii::$app->convert->time($value->created_at)];
            }
            return $data;
        }
    }

}

?>