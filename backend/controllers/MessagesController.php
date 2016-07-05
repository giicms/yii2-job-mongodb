<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\Messages;
use common\models\Conversation;
use backend\controllers\BackendController;
/**
 * MessagesController implements the CRUD actions for User model.
 */
class MessagesController extends BackendController {


    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $this->canUser();
        $query = Messages::find();
        if (!empty($_GET['name'])) {
            $array = [];
            $user = User::find()->where(['LIKE', 'name', $_GET['name']])->orWhere(['LIKE', 'slug', $_GET['name']])->orWhere(['LIKE', 'slugname', $_GET['name']])->all();
            foreach ($user as $value) {
                $array[] = (string) $value->id;
            }
            $query->where(['IN', 'owner', $array]);
        } elseif (!empty($_GET['from'])) {
            $from = (int) \Yii::$app->convert->date($_GET['from']);
            $to = (int) \Yii::$app->convert->date($_GET['to']);
            $query->where(['between', 'created_at', $from, $to]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        return $this->render('index', [
                    'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id) {
        $this->canUser();
        $model = $this->findModel($id);
        $query = Conversation::find()->where(['message_id' => $id]);
        if (!empty($_GET['key'])) {
            $query->where(['LIKE', 'content', $_GET['key']]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        return $this->render('view', [
                    'dataProvider' => $dataProvider,
                    'model' => $model
        ]);
    }

    /**
     * Block an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionBlock() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['ids'])) {
            if ($_POST['act'] == "open")
                $status = Messages::PUBLISH_ACTIVE;
            else
                $status = Messages::PUBLISH_BLOCK;
            foreach ($_POST['ids'] as $value) {
                $model = $this->findModel($value);
                $model->publish = $status;
                $model->save();
                
            }
            return ['ok'];
        } else {
            $model = $this->findModel($_POST['id']);
            if (!empty($model)) {
                if ($model->publish == Messages::PUBLISH_ACTIVE) {
                    $model->publish = Messages::PUBLISH_BLOCK;
                } elseif ($model->publish == Messages::PUBLISH_BLOCK) {
                    $model->publish = Messages::PUBLISH_ACTIVE;
                }
                if ($model->save()) {
                    return ['messages' => 'ok'];
                }
            }
        }
    }
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Messages::findOne($id)) !== null or ( $model = Conversation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

}
