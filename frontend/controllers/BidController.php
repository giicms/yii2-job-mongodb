<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Bid;
use frontend\models\BidCreate;
use common\models\Notification;
use common\models\Job;
use common\models\JobInvited;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\mongodb\ActiveRecord;
use yii\mongodb\ActiveQueryInterface;
use yii\mongodb\Query;

class BidController extends FrontendController
{

    public function actionDeny()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Bid::findOne($_POST['id']);
        if (!empty($model))
        {
            $job = Job::findOne($model->job_id);
            if ($model->delete())
            {
                $notify = new Notification();
                $notify->owner = (string) Yii::$app->user->identity->id;
                $notify->actor = (string) $model->actor;
                $notify->type = 'job';
                $notify->type_id = (string) $model->job_id;
                $notify->content = Yii::$app->user->identity->name . ' ' . $notify->getMessages(21) . ' "' . Yii::$app->convert->excerpt($job->name, 50) . '" ' . $notify->getMessages(1);
                $notify->created_at = time();
                $notify->save();
                return 'ok';
            }
        }
    }

    public function actionIndex()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->user->isGuest)
        {
            return $this->renderAjax('login', ['login' => new \common\models\LoginForm()]);
        }
        switch (Yii::$app->user->identity->step)
        {
            case 0:
                $redirect = 'membership/success';
                break;
            case User::STEP_REG:
                $redirect = 'membership/jobcategories';
                break;
            case User::STEP_CATE:
                $redirect = 'membership/about';
                break;
            case User::STEP_ABOUT:
                $redirect = 'membership/experience';
                break;
            case User::STEP_EXPRESS:
                $redirect = 'membership/complete';
                break;
        }
        if (!empty($redirect))
        {
            Yii::$app->session->setFlash('success', '   Bạn chưa hoàn thành hồ sơ hoặc hồ sơ của bạn chưa được duyệt!.');
            return $this->redirect([$redirect]);
        }
        $first_day = (int) \Yii::$app->convert->date(date('d/m/Y', strtotime(date('Y-m-01', strtotime("now")))));
        $last_day = (int) \Yii::$app->convert->date(date('t/m/Y'));
        $count_bid = Bid::find()->where(['between', 'created_at', $first_day, $last_day])->andWhere(['actor' => (string) Yii::$app->user->id])->count();
        if ($count_bid == Yii::$app->user->identity->findlevel->count_bid)
        {
            return $this->renderAjax('error', ['message' => 'Tháng này bạn đã hết lượt book']);
        }

        if (!empty($_POST['id']))
        {
            $job = Job::findOne($_POST['id']);
            $bid = new BidCreate($job->budget_type);
            if (in_array(\Yii::$app->user->identity->level, $job->level) AND in_array($job->sector_id, \Yii::$app->user->identity->sector))
                return $this->renderAjax('bid', ['bid' => $bid, 'job' => $job, 'status' => 1]);
            else
                return $this->renderAjax('error', ['message' => 'Cấp độ nhân viên hoặc lĩnh vực của bạn không đủ điều kiện để nhận công việc này']);
        }
    }

    public function actionCreate()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->post())
        {
            $data = Yii::$app->request->post('BidCreate');
            if (!empty($data['id']))
                $model = Bid::findOne($data['id']);
            else
                $model = new Bid();
            $model->job_id = $data['job_id'];
            $model->period = $data['period'];
            $model->price = (int) preg_replace('/[^0-9]/', '', $data['price']);
            $model->content = $data['content'];
            $model->actor = Yii::$app->user->id;
            $model->status = 0;
            $model->created_at = time();
            $model->publish = 1;
            if ($model->save())
            {
                $job = Job::findOne($model->job_id);
                $jobinvited = JobInvited::find()->where(['job_id' => $job->id, 'actor' => \Yii::$app->user->id])->one();
                if (!empty($jobinvited))
                {
                    $jobinvited->status = JobInvited::STATUS_ACCEPT;
                    $jobinvited->save();
                }
                $notify = new Notification();
                $notify->owner = Yii::$app->user->id;
                $notify->actor = $job->owner;
                $notify->type = 'job';
                $notify->type_id = $job->id;
                $notify->content = Yii::$app->user->identity->name . ' ' . $notify->getMessages(0) . ' "' . Yii::$app->convert->excerpt($job->name, 50) . '" ' . $notify->getMessages(1);
                $notify->created_at = time();
                $notify->save();

                return ['id' => (string) $model->_id, 'job_slug' => $job->slug, 'job_id' => $job->id];
            }
        }
    }

    public function actionUpdate()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_GET['id']))
        {
            $model = Bid::findOne($_GET['id']);
            $job = Job::findOne($model->job_id);
            $bid = new BidCreate($job->budget_type);
            $bid->attributes = $model->attributes;
            $bid->price = number_format($model->price, 0, '', '.');
            $bid->_price = $model->price;
            $bid->id = $_GET['id'];
            return $this->renderAjax('bid', ['bid' => $bid, 'job' => $job]);
        }
    }

}
