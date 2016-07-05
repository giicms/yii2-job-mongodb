<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Assignment;
use common\models\Job;
use common\models\Bid;
use common\models\AssignmentStep;
use common\models\Messages;
use common\models\JobInvited;
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
use yii\web\NotFoundHttpException;
use common\models\Statistical;

class AssignmentController extends FrontendController {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    // Boss chon nhan vien
    public function actionCommitted($id) {
        $bid = Bid::findOne($id);
        if (!empty($bid)) {
            $job = Job::findOne($bid->job_id);
            $users = User::find()->where(['IN', 'sector', $job->sector_id])->all();
            $model = Assignment::find()->where(['bid_id' => $id])->one();
            $message = Messages::find()
                ->where([
                    'job_id' => (string) $bid->job_id,
                    'status' => Job::PROJECT_PUBLISH,
                ])
                ->all();
            $count = Conversation::find()->where(['job_id' => (string) $bid->job_id])->count();
            if (!empty($model)) {
                throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
            } else {
                $model = Job::findOne($bid->job_id);
                $model->status = Job::PROJECT_PENDING;
                $model->save();
                $assignment = new Assignment();
                $assignment->job_id = $bid->job_id;
                $assignment->bid_id = (string) $bid->_id;
                $assignment->owner = $job->owner;
                $assignment->actor = $bid->actor;
                $assignment->status_member = Assignment::STATUS_GIVE;
                if($model->category->deposit == 0){
                    $assignment->status_boss = Assignment::STATUS_DEPOSIT;
                }else{
                    $assignment->status_boss = Assignment::STATUS_GIVE;
                }
                
                $assignment->created_at = time();
                if ($assignment->save()) {
                    $notify = new Notification();
                    $notify->owner = (string) Yii::$app->user->identity->id;
                    $notify->actor = (string) $bid->actor;
                    $notify->type = 'job';
                    $notify->type_id = (string) $bid->job_id;
                    $notify->content = Yii::$app->user->identity->name . ' ' . $notify->getMessages(18) . ' "' . Yii::$app->convert->excerpt($job->name, 50);
                    $notify->created_at = time();
                    $notify->save();
                    $step = new AssignmentStep();
                    $step->assignment_id = (string) $assignment->_id;
                    $step->status_owner = Assignment::STATUS_GIVE;
                    $step->status_actor = Assignment::STATUS_GIVE;
                    $step->created_at = time();
                    if ($step->save())
                        //kiem tra cong viec co phai dat coc hay khong
                        $deposit = $job->category->deposit;
                        if(!empty($deposit) || $deposit > 0){
                            return $this->redirect(['cong-viec/' . $job->slug . '/' . $bid->job_id]);
                        }else{
                            return $this->redirect(['bosscommitment', 'id' => (string) $assignment->_id]);
                        }
                        
                }
            }
        }else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }


    // Boss dat tien dat coc
    public function actionPayment($id) {
        $model = Assignment::findOne($id);
        $bid = Bid::findOne($model->bid_id);
        if (!empty($model)) {
            $job = Job::findOne($model->job_id);
            if ($model->load(Yii::$app->request->post())) {
                $model->status_boss = Assignment::STATUS_DEPOSIT;
                if ($model->save()) {
                    $step = new AssignmentStep();
                    $step->assignment_id = (string) $model->_id;
                    $step->status_owner = Assignment::STATUS_DEPOSIT;
                    $step->status_actor = Assignment::STATUS_COMMITMENT;
                    $step->created_at = time();
                    $step->save();
                }
                if ($model->status_boss == Assignment::STATUS_DEPOSIT)
                    Yii::$app->session->setFlash('success', '   Bạn chờ admin xác nhận thanh toán!.');
            }
            // da dat coc
            elseif ($model->status_boss == Assignment::STATUS_DEPOSIT)
                return $this->redirect(['bosscommitment', 'id' => (string) $model->_id]);
            // da cam ket lam viec
            elseif ($model->status_boss == Assignment::STATUS_COMMITMENT)
                Yii::$app->session->setFlash('success', 'Bạn đã thanh toán thành công, Hãy chờ nhân viên bắt đầu làm việc.');
            return $this->render('payment', ['model' => $model, 'job' => $job, 'bid' => $bid]);
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    // Boss cam ket lam viec
    public function actionBosscommitment($id) {
        $model = Assignment::findOne($id);
        $bid = Bid::findOne($model->bid_id);
        if (!empty($bid)) {
            $job = Job::findOne($bid->job_id);
            if ($model->load(Yii::$app->request->post())) {
                $status_actor = AssignmentStep::find()->where(['assignment_id' => (string)$model->_id])->max('status_actor');
                $model->status_boss = Assignment::STATUS_COMMITMENT;
                if ($model->save()) {
                    $notify = new Notification();
                    $notify->owner = (string) Yii::$app->user->identity->id;
                    $notify->actor = $bid->actor;
                    $notify->type = 'job';
                    $notify->type_id = $bid->job_id;
                    $notify->content = Yii::$app->user->identity->name . ' ' . $notify->getMessages(5) . ' "' . Yii::$app->convert->excerpt($job->name, 50) . '" ';
                    $notify->created_at = time();
                    $notify->save();
                    //saving assigment step
                    $step = new AssignmentStep();
                    $step->assignment_id = $id;
                    $step->status_owner = Assignment::STATUS_COMMITMENT;
                    $step->status_actor = $status_actor;
                    $step->created_at = time();
                    if($step->save()){
                        return $this->redirect(['work', 'id' => (string) $model->_id]);
                    }
                }
            }
            if (($model->status_member == Assignment::STATUS_COMMITMENT)&&($model->status_boss == Assignment::STATUS_COMMITMENT)){
                return $this->redirect(['payment', 'id' => (string) $model->_id]);
            }   
            return $this->render('bosscommitment', ['job' => $job, 'bid' => $bid, 'model' => $model]);
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    // Nhan vien dong y lam viec
    public function actionMemberconfirm($id) {
        $model = Assignment::findOne($id);
        if (!empty($model)) {
                return $this->redirect(['membercommitment', 'id' => (string) $model->_id]);
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }


    // nhan vien cam ket lam viec
    public function actionMembercommitment($id) {
        $model = Assignment::findOne($id);
        if (!empty($model)) {
            $bid = Bid::findOne($model->bid_id);
            $job = Job::findOne($model->job_id);
            $countjob = Job::find()->where(['owner' => $job->owner])->count();
            $countassignment = Assignment::find()->where(['owner' => $job->owner])->count();
            $created_at = AssignmentStep::find()->where(['assignment_id' => (string) $model->_id, 'status_owner' => Assignment::STATUS_COMMITMENT])->max('created_at');
            $status_owner = AssignmentStep::find()->where(['assignment_id' => (string) $model->_id])->max('status_owner');
            if ($model->load(Yii::$app->request->post())) {
                $model->status_member = Assignment::STATUS_COMMITMENT;
                if ($model->save()) {
                    $notify = new Notification();
                    $notify->owner = (string) Yii::$app->user->identity->id;
                    $notify->actor = $job->owner;
                    $notify->type = 'job';
                    $notify->type_id = (string) $job->_id;
                    $notify->content = Yii::$app->user->identity->name . ' ' . $notify->getMessages(5) . ' "' . Yii::$app->convert->excerpt($job->name, 50) . '" ' . $notify->getMessages(1);
                    $notify->created_at = time();
                    $notify->save();
                    //saving assigment step
                    $step = new AssignmentStep();
                    $step->assignment_id = $id;
                    $step->status_owner = $status_owner;
                    $step->status_actor = Assignment::STATUS_COMMITMENT;
                    $step->created_at = time();
                    $step->save();
                    return $this->redirect(['memberstartwork', 'id' => (string) $model->_id]);
                    
                }
            }
            // boss chưa cam ket
            elseif ($model->status_boss < Assignment::STATUS_COMMITMENT){
                return $this->redirect(['job/detail', 'id' => (string) $assignment->job_id]);
            }
            // da cam ket lam viec
            elseif ($model->status_boss == Assignment::STATUS_REQUEST){
                Yii::$app->session->setFlash('success', 'Bạn đã thanh toán thành công, Hãy chờ nhân viên bắt đầu làm việc.');
            }
            return $this->render('membercommitment', ['model' => $model, 'job' => $job, 'created_at' => $created_at, 'bid' => $bid, 'countjob' => $countjob, 'countassignment' => $countassignment]);
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }


    //Boss tien hanh lam viec
    public function actionWork($id) {
        $model = Assignment::findOne($id);
        $bid = Bid::findOne($model->bid_id);

        if (!empty($model)) {
            //kiem tra admin da kich hoat thanh toan chua
            if ($model->status_boss == Assignment::STATUS_GIVE) {
                return $this->redirect(['payment', 'id' => (string) $model->_id]);
            }
            if ($model->status_boss == Assignment::STATUS_DEPOSIT) {
                return $this->redirect(['bosscommitment', 'id' => (string) $model->_id]);
            }
            if ($model->status_boss == Assignment::STATUS_REQUEST){
                return $this->redirect(['browsejob', 'id' => $id]);
            }
            if (($model->status_boss == Assignment::STATUS_COMPLETE)||($model->status_boss == Assignment::STATUS_REVIEW)) {
                return $this->redirect(['browsejob', 'id' => (string) $model->_id]);
            }
            $job = Job::findOne($model->job_id);
            $message = Messages::find()
                    ->where(['user_1' => (string) Yii::$app->user->identity->id])
                    ->orWhere(['user_2' => (string) Yii::$app->user->identity->id])
                    ->andWhere([
                        'job_id' => (string) $job->_id,
                    ])
                    ->one();
            if (!empty($message))
                $conversation = Conversation::find()->where(['message_id' => (string) $message->_id])->all();
            else
                $conversation = [];
            if ($model->load(Yii::$app->request->post())) {
                $notify = new Notification();
                $notify->owner = (string) Yii::$app->user->identity->id;
                $notify->actor = $bid->actor;
                $notify->type = 'job';
                $notify->type_id = (string) $job->_id;
                $notify->created_at = time();
                if (isset($_POST['no'])) {
                    //update status Assigment
                    $model->status_boss = Assignment::STATUS_COMMITMENT;
                    $model->status_member = Assignment::STATUS_COMMITMENT;
                    if ($model->save()) {
                        //creat new assigmentstep
                        $step = new AssignmentStep();
                        $step->assignment_id = (string) $model->_id;
                        $step->status_owner = Assignment::STATUS_COMMITMENT;
                        $step->status_actor = Assignment::STATUS_COMMITMENT;
                        $step->created_at = time();
                        $step->save();

                        $notify->content = Yii::$app->user->identity->name . ' ' . $notify->getMessages(12) . ' "' . Yii::$app->convert->excerpt($job->name, 50) . '" ';
                        $notify->save();
                    }
                } else {
                    $model->status_boss = Assignment::STATUS_REQUEST;
                    if ($model->save()) {
                        //creat new assigmentstep
                        $step = new AssignmentStep();
                        $step->assignment_id = (string) $model->_id;
                        $step->status_owner = Assignment::STATUS_REQUEST;
                        $step->status_actor = Assignment::STATUS_REQUEST;
                        $step->created_at = time();
                        $step->save();
                    }
                    $notify->content = Yii::$app->user->identity->name . ' ' . $notify->getMessages(11) . ' "' . Yii::$app->convert->excerpt($job->name, 50) . '" ';
                    $notify->save();
                    return $this->redirect(['browsejob', 'id' => (string) $model->_id]);
                }
            }
            $created_at = AssignmentStep::find()->where(['assignment_id' => (string) $model->_id, 'status_owner' => Assignment::STATUS_COMMITMENT])->min('created_at');
            return $this->render('work', ['model' => $model, 'job' => $job, 'created_at' => $created_at, 'bid' => $bid, 'conversation' => $conversation, 'message' => $message]);
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    
    // member bat dau lam viec -> tien trinh lam viec
    public function actionMemberstartwork($id) {
        $model = Assignment::findOne($id);
        if (!empty($model)) {
            $model->status_boss = Assignment::STATUS_COMMITMENT;
            $model->status_member = Assignment::STATUS_COMMITMENT;
            if ($model->save()) {
                //saving status job to PROJECT_MAKING
                $job = Job::findOne($model->job_id);
                $job->status = Job::PROJECT_DEPOSIT;
                $job->save();
                //creat new assigmentstep
                $step = new AssignmentStep();
                $step->assignment_id = (string) $model->_id;
                $step->status_owner = Assignment::STATUS_COMMITMENT;
                $step->status_actor = Assignment::STATUS_COMMITMENT;
                $step->created_at = time();
                $step->save();
                //save in to statistical
                $statistical = new Statistical();    
                $statistical->type = 'job';
                $statistical->objects   = (string)$model->job_id;
                $statistical->publish = Job::PUBLISH_ACTIVE;
                $statistical->status = Job::PROJECT_DEPOSIT;
                $statistical->created_at = time();
                $statistical->save();
                return $this->redirect(['memberprogress', 'id' => (string) $model->_id]);
            }
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    // Tien do lam viec cua nhan vien
    public function actionMemberprogress($id) {
        $model = Assignment::findOne($id);
        if (!empty($model)) {
            // boss chưa cam ket
            if ($model->status_member < Assignment::STATUS_COMMITMENT){
                return $this->redirect(['job/detail', 'id' => (string) $model->job_id]);
            }
            $bid = Bid::findOne($model->bid_id);
            $job = Job::findOne($model->job_id);
            if ($model->load(Yii::$app->request->post())) {
                $model->status_member = Assignment::STATUS_REQUEST;
                if ($model->save()) {
                    $step = new AssignmentStep();
                    $step->assignment_id = (string) $model->_id;
                    $step->status_owner = Assignment::STATUS_REQUEST;
                    $step->status_actor = Assignment::STATUS_COMMITMENT;
                    $step->created_at = time();
                    $step->save();

                    $notify = new Notification();
                    $notify->owner = (string) Yii::$app->user->identity->id;
                    $notify->actor = $job->owner;
                    $notify->type = 'job';
                    $notify->type_id = (string) $job->_id;
                    $notify->content = Yii::$app->user->identity->name . ' ' . $notify->getMessages(10) . ' "' . Yii::$app->convert->excerpt($job->name, 50) . '" ' . $notify->getMessages(1);
                    $notify->created_at = time();
                    $notify->save();
                    if ($model->status_boss < Assignment::STATUS_PAYMENT)
                        Yii::$app->session->setFlash('success', '   Chờ boss xác nhận hoàn thành công việc!.');
                }
            }
            
            $countjob = Job::find()->where(['owner' => $job->owner])->count();
            $countassignment = Assignment::find()->where(['owner' => $job->owner])->count();
            $created_at = AssignmentStep::find()->where(['assignment_id' => (string) $model->_id, 'status_actor' => Assignment::STATUS_COMMITMENT, 'status_owner' => Assignment::STATUS_COMMITMENT])->min('created_at');
            return $this->render('memberprogress', ['model' => $model, 'job' => $job, 'bid' => $bid, 'countjob' => $countjob, 'countassignment' => $countassignment, 'created_at' => $created_at]);
        }else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    

    // Boss duyệt công việc
    public function actionBrowsejob($id) {
        $model = Assignment::findOne($id);
        if (!empty($model)) {
            if ($model->status_boss == Assignment::STATUS_COMMITMENT)
                return $this->redirect(['work', 'id' => $id]);
            elseif ($model->status_boss == Assignment::STATUS_PAYMENT)
                return $this->redirect(['browsejob', 'id' => $id]);
            $bid = Bid::findOne($model->bid_id);
            $job = Job::findOne($model->job_id);
            $countjob = Job::find()->where(['owner' => $job->owner])->count();
            $countassignment = Assignment::find()->where(['owner' => $job->owner])->count();
            $created_at = AssignmentStep::find()->where(['assignment_id' => (string) $model->_id, 'status_actor' => Assignment::STATUS_COMMITMENT])->max('created_at');
            return $this->render('browsejob', ['job' => $job, 'bid' => $bid, 'model' => $model, 'countjob' => $countjob, 'countassignment' => $countassignment, 'created_at' => $created_at]);
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    // ket thuc du an
    public function actionComplete($id) {
        $model = Assignment::findOne($id);
        if (!empty($model)) {
            if ($model->status_boss < Assignment::STATUS_COMPLETE) {
                return $this->redirect(['memberprogress', 'id' => (string) $model->_id]);
            }
            $bid = Bid::findOne($model->bid_id);
            $job = Job::findOne($model->job_id);
            $countjob = Job::find()->where(['owner' => $job->owner])->count();
            $countassignment = Assignment::find()->where(['owner' => $job->owner])->count();
            $created_at = AssignmentStep::find()->where(['assignment_id' => (string) $model->_id, 'status_owner' => Assignment::STATUS_COMMITMENT])->min('created_at');
            return $this->render('complete', ['job' => $job, 'bid' => $bid, 'model' => $model, 'countjob' => $countjob, 'countassignment' => $countassignment, 'created_at' => $created_at]);
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    //check step 
    public function actionCheckstep($id){
        $model = Assignment::findOne($id);
        if(!empty($model)){
            var_dump('expression'); exit;
        }else{
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

}
