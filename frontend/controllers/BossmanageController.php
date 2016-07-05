<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Job;
use common\models\JobInvited;
use common\models\PersonalStorage;
use yii\data\Pagination;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\mongodb\ActiveRecord;
use yii\mongodb\ActiveQueryInterface;
use yii\mongodb\Query;
use common\models\UserBid;

class BossmanageController extends FrontendController {

    public function actionJobmanage() {
        if (\Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect(Yii::$app->params['site_url'] . 'cong-viec-cua-toi'));
        $jobnew = Job::find()->where(['owner' => (string) \Yii::$app->user->identity->id, 'status' => Job::PROJECT_PUBLISH])->orderBy(['updated_at'=>SORT_DESC])->all();
        $pending = Job::find()->where(['owner' => (string) \Yii::$app->user->identity->id, 'status' => Job::PROJECT_PENDING])->orderBy(['updated_at'=>SORT_DESC])->all();
        $making = Job::find()->where(['owner' => (string) \Yii::$app->user->identity->id, 'status' => Job::PROJECT_DEPOSIT])->orderBy(['updated_at'=>SORT_DESC])->all();
        $completed = Job::find()->where(['owner' => (string) \Yii::$app->user->identity->id, 'status' => Job::PROJECT_OVER])->orderBy(['updated_at'=>SORT_DESC])->all();
        return $this->render('jobmanage', ['jobnew' => $jobnew, 'pending' => $pending, 'making' => $making, 'complete' => $completed]);
    }

    public function actionMember() {
        $query = PersonalStorage::find()->where(['owner' => (string) \Yii::$app->user->identity->id, 'status' => 1]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['page']]);
        $model = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        $job = Job::find()->where(['owner' => (string) \Yii::$app->user->identity->id])->all();
        $invited = new JobInvited();
        return $this->render('member', ['model' => $model, 'job' => $job, 'invited' => $invited, 'pages' => $pages]);
    }

    public function actionBookuser() {
        $query = UserBid::find()->where(['owner_id' => (string) \Yii::$app->user->id]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['page']]);
        $model = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        $invited = new JobInvited();
        return $this->render('bookuser', ['model' => $model, 'pages' => $pages]);
    }

}

?>
