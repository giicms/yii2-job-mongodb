<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\PersonalStorage;
use common\models\Bid;
use common\models\Job;
use common\models\Assignment;
use common\models\UserBid;
use yii\data\Pagination;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\mongodb\ActiveRecord;
use yii\mongodb\ActiveQueryInterface;
use yii\mongodb\Query;

class MembermanageController extends FrontendController {

    public function actionIndex() {
        if (\Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect(Yii::$app->params['site_url'] . 'cong-viec-cua-toi'));
        $bid = Bid::find()->where(['actor' => (string) \Yii::$app->user->identity->id, 'status' => 0])->all();
        $assign = Assignment::find()->where(['actor' => (string) Yii::$app->user->identity->id, 'status_member' => Assignment::STATUS_GIVE])->andWhere(['between','status_boss', Assignment::STATUS_GIVE, Assignment::STATUS_COMMITMENT])->all();
        $making = Assignment::find()->where(['actor' => (string) Yii::$app->user->identity->id])->andWhere(['between','status_member', Assignment::STATUS_COMMITMENT, Assignment::STATUS_REQUEST])->andWhere(['between','status_boss', Assignment::STATUS_COMMITMENT, Assignment::STATUS_PAYMENT])->all();
        $completed = Assignment::find()->where(['actor' => (string) Yii::$app->user->identity->id])->andWhere(['between','status_member',Assignment::STATUS_COMPLETE,Assignment::STATUS_REVIEW])->all();
        $give = Assignment::find()->where(['actor' => (string) Yii::$app->user->identity->id])->andWhere(['between', 'status_boss', Assignment::STATUS_GIVE, Assignment::STATUS_REVIEW])->all();

        //cong viec dang book
        $arrbid = [];
        $arrgive = [];
        foreach ($bid as $key => $value) {
            $arrbid[] = (string) $value->job_id;
        }
        foreach ($give as $key => $value) {
            $arrgive[] = (string) $value->job_id;
        }
        $result = array_diff($arrbid, $arrgive);
        $jobbid = Bid::find()->where(['actor' => (string) \Yii::$app->user->identity->id, 'status' => 0])->andWhere(['IN', 'job_id', $result])->all();

        return $this->render('index', ['bid' => $jobbid, 'assign' => $assign, 'making' => $making, 'complete' => $completed]);
    }

    public function actionSavejob() {
        $jobsave = PersonalStorage::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->all();
        return $this->render('savejob', ['model' => $jobsave]);
    }

    public function actionBoss() {
        $query = UserBid::find()->where(['actor_id' => \Yii::$app->user->id]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['page']]);
        $model = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        return $this->render('boss', ['model' => $model, 'pages' => $pages]);
    }

}

?>
