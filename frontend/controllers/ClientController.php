<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\mongodb\Query;
use yii\data\Pagination;
use common\models\Messages;
use common\models\Conversation;
use common\models\Notification;

class ClientController extends FrontendController {

    public function actionNotify() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $notify = Notification::find()->where(['actor' => (string) Yii::$app->user->identity->id, 'active' => 1])->one();
        if (!empty($notify)) {
            $data = [];
            if ($notify->type == 'job') {
                $url = Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $notify->job->slug . '/' . (string) $notify->job->_id);
            } else {
                $url = Yii::$app->urlManager->createAbsoluteUrl('user/' . $notify->user->slug . '?notify=' . (string) $notify->_id);
            }
            $notify->set = 2;
            $notify->active = 2;
            $notify->save();
            return ['url' => $url, 'avatar' => Yii::$app->params['url_file'] . '/thumbnails/150-' . $notify->user->avatar, 'content' => $notify->content, 'created_at' => Yii::$app->convert->time($notify->created_at)];
        }
    }

    public function actionMessages() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Conversation::find()->where(['actor' => (string) Yii::$app->user->identity->id, 'active' => 1])->all();
        $data = [];
        if (!empty($model)) {
            foreach ($model as $value) {
                $data[] = ['url' => Yii::$app->urlManager->createAbsoluteUrl('tin-nhan/' . $value->profile->slug), 'name' => $value->profile->name, 'avatar' => Yii::$app->params['url_file'] . 'thumbnails/60-' . $value->profile->avatar, 'content' => $value->content, 'created_at' => Yii::$app->convert->time($value->created_at)];
            }
            return $data;
        }
    }

    public function actionServer() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $active = Notification::find()->where(['actor' => (string) Yii::$app->user->identity->id, 'active' => 1])->all();
        $set = Notification::find()->where(['actor' => (string) Yii::$app->user->identity->id, 'set' => 1])->all();
        $data_notify = [];
        $data_messages = [];
        if (!empty($set)) {
            foreach ($set as $value) {
                $value->set = 2;
                $value->save();
                $data_notify[] = ['content' => $value->content];
            }
        }
        $messages = Conversation::find()->where(['actor' => (string) Yii::$app->user->identity->id, 'active' => 1])->all();
        return ['notify' => $active, 'set' => $data_notify, 'messages' => $messages];
    }

}
