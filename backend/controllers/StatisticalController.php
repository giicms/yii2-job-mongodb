<?php

namespace backend\controllers;

use Yii;
use common\models\Job;
use common\models\Category;
use common\models\Sectors;
use common\models\City;
use common\models\User;
use common\models\District;
use common\models\Assignment;
use common\models\Bid;
use common\models\Skills;
use common\models\Messages;
use common\models\Statistical;
use common\models\Conversation;
use common\models\AssignmentStep;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JobController implements the CRUD actions for job model.
 */
class StatisticalController extends BackendController {

    public function actionJob() {
        $this->canUser();
        // fillter job
        $dataProvider = '';
        if (!empty($_GET['txt_jobtype'])) {
            $from = strtotime(str_replace('/', '-', $_GET['txt_from']));
            $to = strtotime(str_replace('/', '-', $_GET['txt_to']));

            if ($_GET['txt_jobtype'] == Job::PROJECT_PUBLISH) {
                $query = job::find()->where(['publish' => Job::PUBLISH_ACTIVE, 'block' => Job::JOB_UNBLOCK])->andWhere(['between', 'created_at', (int) $from, (int) $to])->orderBy('created_at');
            } elseif ($_GET['txt_jobtype'] == Job::PROJECT_PENDING) {
                $query = job::find()->where(['block' => Job::JOB_UNBLOCK])->andWhere(['between', 'status', Job::PROJECT_PENDING, Job::PROJECT_OVER])->andWhere(['between', 'created_at', (int) $from, (int) $to])->orderBy('created_at');
            } elseif ($_GET['txt_jobtype'] == Job::PROJECT_MAKING) {
                $query = job::find()->where(['block' => Job::JOB_UNBLOCK])->andWhere(['between', 'status', Job::PROJECT_PENDING, Job::PROJECT_OVER])->andWhere(['between', 'created_at', (int) $from, (int) $to])->orderBy('created_at');
            } elseif ($_GET['txt_jobtype'] == Job::PROJECT_OVER) {
                $query = job::find()->where(['status' => Job::PROJECT_OVER, 'block' => Job::JOB_UNBLOCK])->andWhere(['between', 'created_at', (int) $from, (int) $to])->orderBy('created_at');
            }
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 30,
                ],
            ]);
        }
        // show chart
        if (!empty($_GET['datefrom']) && !empty($_GET['dateto'])) {
            $datefrom = strtotime($_GET['datefrom']);
            $dateto = strtotime($_GET['dateto']) + 86399;
        } else {
            $dateto = time();
            $datefrom = time() - (86400 * 15);
        }
        for ($i = $datefrom; $i <= $dateto; $i+=86400) {
            $jobview = statistical::find()->where(['type' => 'job', 'publish' => Job::PUBLISH_ACTIVE])->andWhere(['between', 'created_at', (int) $i, (int) $i + 86399])->all();
            $jobinvite = statistical::find()->where(['type' => 'job', 'status' => Job::PROJECT_PENDING])->andWhere(['between', 'created_at', (int) $i, (int) $i + 86399])->all();
            $jobfalse = statistical::find()->where(['type' => 'job', 'status' => Job::PROJECT_DEPOSIT])->andWhere(['between', 'created_at', (int) $i, (int) $i + 86399])->all();
            $jobcomplete = statistical::find()->where(['type' => 'job', 'status' => Job::PROJECT_OVER])->andWhere(['between', 'created_at', (int) $i, (int) $i + 86399])->all();
            $myarr[$i]['jobview'] = count($jobview);
            $myarr[$i]['jobinvite'] = count($jobinvite);
            $myarr[$i]['jobfalse'] = count($jobfalse);
            $myarr[$i]['jobcomplete'] = count($jobcomplete);
        }
        return $this->render('job', [
                    'datefrom' => $datefrom, 'dateto' => $dateto, 'model' => $myarr, 'dataProvider' => $dataProvider
        ]);
    }

    public function actionBoss() {
        $this->canUser();
        // fillter job
        $dataProvider = '';
        if (!empty($_GET['txt_bosstype'])) {
            $from = strtotime(str_replace('/', '-', $_GET['txt_from']));
            $to = strtotime(str_replace('/', '-', $_GET['txt_to']));

            if ($_GET['txt_bosstype'] == 1) {
                $query = user::find()->where(['role' => User::ROLE_BOSS, 'status' => User::STATUS_ACTIVE])->andWhere(['between', 'created_at', (int) $from, (int) $to])->orderBy('created_at');
            } else {
                $query = user::find()->where(['role' => User::ROLE_BOSS, 'status' => User::STATUS_BLOCK])->andWhere(['between', 'created_at', (int) $from, (int) $to])->orderBy('created_at');
            }
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 30,
                ],
            ]);
        }

        // show chart
        if (!empty($_GET['datefrom']) && !empty($_GET['dateto'])) {
            $datefrom = strtotime($_GET['datefrom']);
            $dateto = strtotime($_GET['dateto']) + 86399;
        } else {
            $dateto = time();
            $datefrom = time() - (86400 * 15);
        }
        for ($i = $datefrom; $i <= $dateto; $i+=86400) {
            $model = statistical::find()->where(['type' => 'user', 'role' => 'boss', 'status' => 1])->andWhere(['between', 'created_at', (int) $i, (int) $i + 86399])->all();
            $myarr[$i]['user'] = count($model);
        }
        // var_dump(date('d-m-Y',1448676838)); exit;
        return $this->render('boss', [
                    'datefrom' => $datefrom, 'dateto' => $dateto, 'model' => $myarr, 'dataProvider' => $dataProvider
        ]);
        //return $this->render('index', ['datefrom'=>$datefrom, 'dateto'=>$dateto, 'model'=>$myarr, 'myjob'=>$myjob]);
    }

    public function actionMember() {
        $this->canUser();
        // fillter job
        $dataProvider = '';
        if (!empty($_GET['txt_membertype'])) {
            $from = strtotime(str_replace('/', '-', $_GET['txt_from']));
            $to = strtotime(str_replace('/', '-', $_GET['txt_to']));

            if ($_GET['txt_membertype'] == 1) {
                $query = user::find()->where(['role' => User::ROLE_MEMBER, 'status' => User::STATUS_ACTIVE])->andWhere(['between', 'created_at', (int) $from, (int) $to])->orderBy('created_at');
            } else {
                $query = user::find()->where(['role' => User::ROLE_MEMBER, 'status' => User::STATUS_BLOCK])->andWhere(['between', 'created_at', (int) $from, (int) $to])->orderBy('created_at');
            }
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 30,
                ],
            ]);
        }

        // show chart
        if (!empty($_GET['datefrom']) && !empty($_GET['dateto'])) {
            $datefrom = strtotime($_GET['datefrom']);
            $dateto = strtotime($_GET['dateto']) + 86399;
        } else {
            $dateto = time();
            $datefrom = time() - (86400 * 15);
        }
        for ($i = $datefrom; $i <= $dateto; $i+=86400) {
            $model = statistical::find()->where(['type' => 'user', 'role' => 'boss', 'status' => 1])->andWhere(['between', 'created_at', (int) $i, (int) $i + 86399])->all();
            $myarr[$i]['user'] = count($model);
        }
        // var_dump(date('d-m-Y',1448676838)); exit;
        return $this->render('member', [
                    'datefrom' => $datefrom, 'dateto' => $dateto, 'model' => $myarr, 'dataProvider' => $dataProvider
        ]);
        //return $this->render('index', ['datefrom'=>$datefrom, 'dateto'=>$dateto, 'model'=>$myarr, 'myjob'=>$myjob]);
    }

}
