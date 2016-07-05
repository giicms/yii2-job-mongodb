<?php

namespace backend\controllers;

use Yii;
use common\models\Job;
use common\models\Category;
use common\models\Sectors;
use common\models\City;
use common\models\District;
use common\models\Assignment;
use common\models\Bid;
use common\models\Skills;
use common\models\Messages;
use common\models\Conversation;
use common\models\AssignmentStep;
use common\models\Statistical;
use common\models\PaymentHistory;
use common\models\User;
use common\models\Notification;
use common\models\JobCreate;
use common\models\SectorOptions;
use common\models\BudgetPrice;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;
use common\models\BudgetPacket;

/**
 * JobController implements the CRUD actions for job model.
 */
class JobController extends BackendController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all job models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->canUser();
        if (\Yii::$app->user->identity->level == 1)
            $query = Job::find()->orderBy(['created_at' => SORT_DESC]);
        else
            $query = Job::find()->where(['IN', 'category_id', \Yii::$app->user->identity->category])->orderBy(['created_at' => SORT_DESC]);
        $category = Category::find()->all();
        $sector = $district = [];
        if (!empty($_GET['category']))
            $sector = Sectors::find()->where(['category_id' => $_GET['category']])->all();
        $city = City::find()->all();
        if (!empty($_GET['city']))
            $district = District::find()->where(['city_id' => $_GET['city']])->all();

        $query->andWhere(['between', 'status', 0, 5]);
        if (!empty($_GET['name']))
        {
            $query->andWhere([
                'or',
                ['like', 'name', $_GET['name']],
                ['like', 'slugname', $_GET['name']]
            ]);
        }
        elseif (!empty($_GET['publish']))
        {
            //tình trạng đã khóa
            if ($_GET['publish'] == 'block')
            {
                $query->andWhere(['block' => 2]);
            }
            elseif (
            //tình trạng công việc đã được duyệt
                    $_GET['publish'] == job::PUBLISH_ACTIVE)
            {
                $assignment = Assignment::find()->all();
                $listjob = array();
                foreach ($assignment as $key => $val)
                {
                    $listjob[] = $val->job_id;
                }
                $query->andWhere(['block' => 1, 'publish' => job::PUBLISH_ACTIVE])->andWhere(['not in', '_id', $listjob]);
            }
            elseif (
            // tình trạng đã giao việc
                    $_GET['publish'] == 'invite')
            {
                $assignment = Assignment::find()->where(['status_member' => Assignment::STATUS_GIVE])->all();
                $listjob = array();
                foreach ($assignment as $key => $val)
                {
                    $listjob[] = $val->job_id;
                }
                $query->andWhere(['block' => 1, 'publish' => job::PUBLISH_ACTIVE])->andWhere(['in', '_id', $listjob]);
            }
            elseif (
            //tình trạng chờ xác nhận đặt cọc
                    $_GET['publish'] == 'deposit')
            {
                $assignment = Assignment::find()->where(['status_boss' => Assignment::STATUS_DEPOSIT])->all();
                $listjob = array();
                foreach ($assignment as $key => $val)
                {
                    $listjob[] = $val->job_id;
                }
                $query->andWhere(['block' => 1, 'publish' => job::PUBLISH_ACTIVE])->andWhere(['in', '_id', $listjob]);
            }
            elseif (
            //tình trạng đang làm việc
                    $_GET['publish'] == 'doing')
            {
                $assignment = Assignment::find()->where(['status_boss' => Assignment::STATUS_COMMITMENT])->all();
                $listjob = array();
                foreach ($assignment as $key => $val)
                {
                    $listjob[] = $val->job_id;
                }
                $query->andWhere(['block' => 1, 'publish' => job::PUBLISH_ACTIVE])->andWhere(['in', '_id', $listjob]);
            }
            elseif (
            //tình trạng đang chờ xác nhận thanh toán
                    $_GET['publish'] == 'payment')
            {
                $assignment = Assignment::find()->where(['status_boss' => Assignment::STATUS_PAYMENT])->all();
                $listjob = array();
                foreach ($assignment as $key => $val)
                {
                    $listjob[] = $val->job_id;
                }
                $query->andWhere(['block' => 1, 'publish' => job::PUBLISH_ACTIVE])->andWhere(['in', '_id', $listjob]);
            }
            elseif (
            //tình trạng công việc hoàn thành
                    $_GET['publish'] == 'finish')
            {
                $assignment = Assignment::find()->where(['status_boss' => Assignment::STATUS_COMPLETE])->all();
                $listjob = array();
                foreach ($assignment as $key => $val)
                {
                    $listjob[] = $val->job_id;
                }
                $query->andWhere(['block' => 1, 'publish' => job::PUBLISH_ACTIVE])->andWhere(['in', '_id', $listjob]);
            }
            else
            {
                $query->andWhere(['block' => 1, 'publish' => (int) $_GET['publish']]);
            }
        }
        elseif (!empty($_GET['category']))
        {
            $query->andWhere(['category_id' => $_GET['category']]);
        }
        elseif (!empty($_GET['sector']))
        {
            $query->andWhere(['sector_id' => $_GET['sector']]);
        }
        elseif (!empty($_GET['city']))
        {
            $query->andWhere(['city_id' => $_GET['city']]);
        }
        elseif (!empty($_GET['district']))
        {
            $query->andWhere(['district_id' => $_GET['district']]);
        }
        elseif (!empty($_GET['datefrom']) && !empty($_GET['dateto']))
        {
            if ($_GET['datefrom'] == $_GET['datefrom'])
            {
                $to = strtotime($_GET['datefrom']);
                $from = strtotime($_GET['datefrom']) + 86400;
                $query->andWhere(['between', 'created_at', $to, $from]);
            }
            else
            {
                $query->andWhere(['between', 'created_at', strtotime($_GET['datefrom']), strtotime($_GET['dateto'])]);
            }
        }
        elseif (!empty($_GET['protype']))
        {
            $query->andWhere(['project_type' => $_GET['protype']]);
        }
        Yii::$app->session->setFlash('job', !empty($_GET['page']) ? $_GET['page'] : NULL);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
                // 'pagination' => [
                //     'pageSize' => 5,
                // ],
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider, 'category' => $category, 'sector' => $sector, 'city' => $city, 'district' => $district,
        ]);
    }

    /**
     * Displays a single job model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->canUser();
        $model = Job::findOne($id);
        $book = $model->bid;
        $assignment = $model->assignment;
        if (!empty($assignment))
        {
            $bid = $assignment->bid;
            $message = Messages::find()
                    ->where(['owner' => (string) $assignment->actor, 'actor' => (string) $assignment->owner])
                    ->orWhere(['actor' => (string) $assignment->actor, 'owner' => (string) $assignment->owner])
                    ->one();
            if (!empty($message))
            {
                $conversation = Conversation::find()->where(['message_id' => (string) $message->_id])->orderBy(['created_at' => SORT_ASC])->limit(20)->all();
            }
            else
            {
                $conversation = '';
            }
            return $this->render('view', [
                        'model' => $model, 'assignment' => $assignment, 'bid' => $bid, 'book' => $book, 'conversation' => $conversation,
            ]);
        }
        return $this->render('view', [
                    'model' => $model, 'book' => $book
        ]);
    }

    /**
     * Updates an existing job model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->canUser();
        $job = Job::findOne($id);
        $item = [];
        if (!empty($job->options))
        {
            foreach ($job->options as $key => $value)
            {
                $item[] = $key;
            }
        }
        $options = SectorOptions::find()->where(['IN', '_id', $item])->all();
        $config = [];
        if (!empty($options))
        {
            foreach ($options as $value)
            {
                $config[$value->id] = ['id' => $value->id, 'name' => $value->name];
            }
        }
        $model = new JobCreate($config);
        $model->id = $id;
        $model->attributes = $job->attributes;
        $data = [];
        if ($model->work_location == 2)
        {
            $district = District::find()->where(['city_id' => $model->city_id])->all();
            if ($district)
            {
                foreach ($district as $value)
                {
                    $data[(string) $value['_id']] = $value['name'];
                }
            }
        }
        if ($model->load(Yii::$app->request->post()))
        {
            $option = [];
            if (!empty($options))
            {
                foreach ($options as $value)
                {
                    $string = str_replace('Khác', '', implode(',', $_POST['JobCreate'][$value->id]));
                    if (!empty($_POST[$value->id]))
                        $option[$value->id] = ['name' => $value->name, 'option' => trim($string, ','), 'other' => $_POST[$value->id]];
                    else
                        $option[$value->id] = ['name' => $value->name, 'option' => trim($string, ',')];
                }
            }
            $job->options = $option;
            $job->name = $model->name;
            $job->slug = \Yii::$app->convert->string($model->name);
            $job->slugname = \Yii::$app->convert->unsigned($model->name);
            $job->deadline = \Yii::$app->convert->date($model->deadline);
            $job->description = $model->description;
            $job->level = $model->level;
            $job->work_location = $model->work_location;
            if ($model->work_location == 2)
            {
                $job->address = $model->address;
                $job->district_id = $model->district_id;
                $job->city_id = $model->city_id;
            }
            $job->num_bid = $model->num_bid;
            if (!empty($model->file))
                $job->file = [$model->file];
            if ($job->save())
            {
                return $this->redirect(['view', 'id' => $job->id]);
            }
        }

        return $this->render('update', ['model' => $model, 'district' => $data, 'options' => $options, 'budget' => $this->findBudget($job->sector_id)]);
    }

    protected function findBudget($id)
    {
        $model = BudgetPacket::find()->where(['IN', 'sectors', $id])->one();
        $data = [];
        if (!empty($model))
        {
            foreach ($model->options as $option)
            {
                $data[$option['min'] . '-' . $option['max']] = number_format($option['min'], 0, '', '.') . ' - ' . number_format($option['max'], 0, '', '.');
            }
        }
        return $data;
    }

    /**
     * Deletes an existing job model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->canUser();
        $this->findModel($id)->delete();
        $this->request('job');
    }

    /**
     * Finds the job model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return job the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Job::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionBlockjob()
    {
        if (!empty($_POST['ids']))
        {
            foreach ($_POST['ids'] as $key => $value)
            {
                $model = $this->findModel($value);
                $model->block = job::JOB_BLOCK;
                $model->save();
            }
            return 'ok';
        }
    }

    public function actionUnblockjob()
    {
        if (!empty($_POST['ids']))
        {
            foreach ($_POST['ids'] as $key => $value)
            {
                $model = $this->findModel($value);
                $model->block = job::JOB_UNBLOCK;
                $model->save();
            }
            return 'ok';
        }
    }

    public function actionBlock($id)
    {
        $model = $this->findModel($id);
        $model->block = job::JOB_BLOCK;
        $model->save();
        return $this->redirect(['view', 'id' => (string) $model->_id]);
    }

    public function actionUnblock($id)
    {
        $model = $this->findModel($id);
        $model->block = job::JOB_UNBLOCK;
        $model->save();
        return $this->redirect(['view', 'id' => (string) $model->_id]);
    }

    public function actionPublish()
    {
        $id = $_POST['id'];
        $value = $_POST['publish'];
        $model = $this->findModel($id);
        $model->publish = intval($value);
        if ($model->save())
        {
            //save in to statistical
            $statistical = Statistical::find()->where(['objects' => (string) $model->_id])->one();
            if (!empty($statistical))
            {
                $statistical->publish = intval($value);
                $statistical->save();
                if ($statistical->save())
                {
                    return 'ok';
                }
            }
            else
            {
                $statisticalnew = new Statistical();
                $statisticalnew->type = 'job';
                $statisticalnew->objects = (string) $model->_id;
                $statisticalnew->status = Job::PROJECT_PUBLISH;
                $statisticalnew->publish = intval($value);
                $statisticalnew->created_at = time();
                if ($statisticalnew->save())
                {
                    return 'ok';
                }
            }
        }
    }

    // xác nhận đặt cọc
    public function actionDeposit()
    {
        $id = $_POST['id'];
        $value = $_POST['deposit'];
        $job = $this->findModel($id);
        $job->status = Job::PROJECT_DEPOSIT;
        $job->save();
        $model = $this->findModel($id)->assignment;
        $model->status_boss = Assignment::STATUS_DEPOSIT;
        if ($model->save())
        {
            //saving payment_history
            //check isset assignment_id at deposit status in payment_history
            $payment = PaymentHistory::find()->where(['assignment_id' => (string) $model->_id, 'resion' => PaymentHistory::RES_DEPOSIT])->one();
            if (!empty($payment))
            {
                //update into payment_history
                $payment->value = $value;
                $payment->updated_at = time();
                $payment->save();
            }
            else
            {
                //add new into payment_history
                $payment_his = new PaymentHistory();
                $payment_his->user = (string) $model->owner;
                $payment_his->assignment_id = (string) $model->_id;
                $payment_his->value = $value;
                $payment_his->resion = PaymentHistory::RES_DEPOSIT;
                $payment_his->created_at = time();
                $payment_his->updated_at = time();
                $payment_his->save();
            }
            //saving assigment step
            $step = new AssignmentStep();
            $step->assignment_id = (string) $model->_id;
            $step->status_owner = Assignment::STATUS_GIVE;
            $step->status_actor = Assignment::STATUS_DEPOSIT;
            $step->created_at = time();
            if ($step->save())
            {
                return 'ok';
            }
        }
    }

    // hủy đặt cọc
    public function actionUndeposit($id)
    {
        $model = $this->findModel($id)->assignment;
        $model->status_boss = Assignment::STATUS_GIVE;
        $job = $this->findModel($id);
        $job->status = Job::PROJECT_PENDING;
        $job->save();
        if ($model->save())
        {
            //check isset assignment_id at deposit status in payment_history
            $payment = PaymentHistory::find()->where(['assignment_id' => (string) $model->_id, 'resion' => PaymentHistory::RES_DEPOSIT])->one();
            if (!empty($payment))
            {
                $payment->delete();
            }
            //saving assigment step
            $step = new AssignmentStep();
            $step->assignment_id = (string) $model->_id;
            $step->status_owner = Assignment::STATUS_GIVE;
            $step->status_actor = Assignment::STATUS_GIVE;
            $step->created_at = time();
            $step->save();
        }
        return $this->redirect(['view', 'id' => (string) $id]);
    }

    // xác nhận thanh toán
    public function actionPayment()
    {
        $id = $_POST['id'];
        $value = $_POST['payment'];
        $model = $this->findModel($id)->assignment;
        $model->status_boss = Assignment::STATUS_PAYMENT;
        $job = $this->findModel($id);
        $job->status = Job::PROJECT_COMPLETED;
        $job->save();
        if ($model->save())
        {
            //saving payment_history
            //check isset assignment_id at deposit status in payment_history
            $payment = PaymentHistory::find()->where(['assignment_id' => (string) $model->_id, 'resion' => PaymentHistory::RES_PAYMENT])->one();
            if (!empty($payment))
            {
                //update into payment_history
                $payment->value = $value;
                $payment->updated_at = time();
                $payment->save();
            }
            else
            {
                //add new into payment_history
                $payment_his = new PaymentHistory();
                $payment_his->user = (string) $model->owner;
                $payment_his->assignment_id = (string) $model->_id;
                $payment_his->value = $value;
                $payment_his->resion = PaymentHistory::RES_PAYMENT;
                $payment_his->created_at = time();
                $payment_his->updated_at = time();
                $payment_his->save();
            }
            //saving assigment step
            $step = new AssignmentStep();
            $step->assignment_id = (string) $model->_id;
            $step->status_owner = Assignment::STATUS_REQUEST;
            $step->status_actor = Assignment::STATUS_PAYMENT;
            $step->created_at = time();
            if ($step->save())
            {
                return 'ok';
            }
        }
    }

    // hủy thanh toán
    public function actionUnpayment($id)
    {
        $model = $this->findModel($id)->assignment;
        $model->status_boss = Assignment::STATUS_REQUEST;
        $job = $this->findModel($id);
        $job->status = Job::PROJECT_DEPOSIT;
        $job->save();
        if ($model->save())
        {
            //check isset assignment_id at deposit status in payment_history
            $payment = PaymentHistory::find()->where(['assignment_id' => (string) $model->_id, 'resion' => PaymentHistory::RES_PAYMENT])->one();
            if (!empty($payment))
            {
                $payment->delete();
            }
            //saving assigment step
            $step = new AssignmentStep();
            $step->assignment_id = (string) $model->_id;
            $step->status_owner = Assignment::STATUS_REQUEST;
            $step->status_actor = Assignment::STATUS_REQUEST;
            $step->created_at = time();
            $step->save();
        }
        return $this->redirect(['view', 'id' => (string) $id]);
    }

    // kết thuc cong viec
    /* public function actionComplete($id) {
      $model = $this->findModel($id)->assignment;
      $model->status_boss = Assignment::STATUS_COMPLETE;
      $model->status_member = Assignment::STATUS_COMPLETE;
      if ($model->save()) {
      //saving assigment step
      $step = new AssignmentStep();
      $step->assignment_id = (string) $model->_id;
      $step->status_owner = Assignment::STATUS_COMPLETE;
      $step->status_actor = Assignment::STATUS_COMPLETE;
      $step->created_at = time();
      $step->save();
      }
      return $this->redirect(['view', 'id' => (string) $id]);
      } */
    public function actionComplete($id)
    {
        $model = $this->findModel($id)->assignment;
        $model->status_boss = Assignment::STATUS_COMPLETE;
        $model->status_member = Assignment::STATUS_COMPLETE;
        $model->completed_at = time();
        $job = $this->findModel($id);
        $job->status = Job::PROJECT_OVER;
        $job->save();
        if ($model->save())
        {
            //saving assigment step
            $step = new AssignmentStep();
            $step->assignment_id = (string) $model->_id;
            $step->status_owner = Assignment::STATUS_COMPLETE;
            $step->status_actor = Assignment::STATUS_COMPLETE;
            $step->created_at = time();
            $step->save();

            //send mail for boss
            $actor = User::findOne($model->actor); //Nhan vien
            $owner = User::findOne($model->owner); //Boss
            if (!empty($model))
            {
                //notifycation
                $notify = new Notification();
                $notify->owner = (string) $owner->_id;
                $notify->actor = (string) $actor->_id;
                $notify->type = 'job';
                $notify->type_id = $job->_id;
                $notify->content = $notify->getMessages(8) . ' "' . Yii::$app->convert->excerpt($job->name, 50) . '"" ' . $notify->getMessages(1) . ' ' . $notify->getMessages(15);
                $notify->created_at = time();
                $notify->save();
                $notify2 = new Notification();
                $notify2->owner = (string) $actor->_id;
                $notify2->actor = (string) $owner->_id;
                $notify2->type = 'job';
                $notify2->type_id = $job->_id;
                $notify2->content = $notify->getMessages(8) . ' "' . Yii::$app->convert->excerpt($job->name, 50) . '"" ' . $notify->getMessages(1) . ' ' . $notify->getMessages(15);
                $notify2->created_at = time();
                $notify2->save();
                // gui mail review cho boss
                Yii::$app->mailer->compose()
                        ->setTo($owner->email)
                        ->setFrom([Yii::$app->params['adminEmail'] => 'Giao nhận việc'])
                        ->setSubject('Công việc của bạn đã được hoàn thành Giaonhanviec.com')
                        ->setHtmlBody('<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                                    <meta name="viewport" content="width=device-width">
                                    <title>ZURBemails</title>
                                    <!--<link rel="stylesheet" type="text/css" href="./ZURBemails_files/email.css">-->
                                </head>
                                <body bgcolor="#FFFFFF" style="-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width: 100%!important;height: 100%;font-family: HelveticaNeue-Light, Helvetica Neue Light, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif; line-height: 1.1; margin:0 0 15px; color:#000;">
                                    <table class="head-wrap" bgcolor="#00adef" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td class="header container" style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important;">
                                                    <div class="content" style="max-width:600px;margin:0 auto;">
                                                        <table style="width: 100%;">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding:10px 0"><img src="http://files.giaonhanviec.com/gnv/logo-gnv-250.png" style="max-width: 100%;"></td>
                                                                    <td style="" align="right"><h6 style="margin: 0!important;color:#fff">Ngày ' . date('d', time()) . ' tháng ' . date('m', time()) . ' năm ' . date('Y', time()) . '</h6></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <table class="body-wrap" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td class="container" bgcolor="#FFFFFF" style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important;">
                                                    <div class="content" style="max-width:600px;margin:0 auto;display:block;">
                                                        <table style="width: 100%;">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <h3 style="padding-top:10px;font-weight:500;font-size:27px;color:#238e23">Xin chào, ' . $owner->name . '</h3>
                                                                        <p class="lead" style="font-size:14px;line-height:1.6">Công việc "<span style="color:#00adef">' . $job->name . '</span>" trên hệ thống Giaonhanviec của bạn đã kết thúc!</p>
                                                                        
                                                                        <p><img src="' . Yii::$app->setting->value('site_url') . '/images/banner_emai.png" style="max-width: 100%; min-width: 100%;"></p>
                                                                        
                                                                        <h3>Dành cho khách hàng</h3>
                                                                        <p style="font-size:14px;line-height:1.6">Để điều chỉnh những thiếu xót, hạn chế trong quá trình làm việc và nâng cao chất lượng công việc, Xin hãy dành ít thời gian để đánh giá nhân viên đã thực hiện công việc của bạn.</p>
                                                                        <a href="http://' . Yii::$app->setting->value('site_url') . '/danh-gia?ty=bo&id=' . $model->_id . '&ac=' . $owner->_id . '" class="btn" style="text-decoration:none;color: #FFF;background-color: #1fcf93;padding:10px 16px;font-weight:bold;margin-right:10px;text-align:center;cursor:pointer;display: inline-block;border-bottom:2px solid #1ab07d;font-weight:400;font-size:18px;">Đánh giá nhân viên →</a>
                                                                        <br>
                                                                        <p class="callout" style="padding:15px;background-color:#ECF8FF;margin-bottom: 15px;font-size:14px;line-height:1.6">
                                                                            <i>Đây là email tự động, vui lòng không trả lời email này.</i>
                                                                        </p>
                                                                        <br>
                                                                        
                                                                        <table class="social" width="100%" style="background-color: #ebebeb;">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table align="left" class="column" style="width: 100%;width: 300px;float:left;">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td style="padding: 15px;">
                                                                                                        <h5 class="">Kết nối với giaonhanviec.com:</h5>
                                                                                                        <p class="">
                                                                                                            <a href="#" class="soc-btn fb" style="padding: 3px 7px;font-size:12px;margin-bottom:10px;text-decoration:none;color: #FFF;font-weight:bold;display:block;text-align:center;background-color: #3B5998!important;">Facebook</a>
                                                                                                            <a href="#" class="soc-btn tw" style="padding: 3px 7px;font-size:12px;margin-bottom:10px;text-decoration:none;color: #FFF;font-weight:bold;display:block;text-align:center;background-color: #1daced!important;">Twitter</a>
                                                                                                            <a href="#" class="soc-btn gp" style="padding: 3px 7px;font-size:12px;margin-bottom:10px;text-decoration:none;color: #FFF;font-weight:bold;display:block;text-align:center;background-color: #DB4A39!important;">Google+</a>
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                            
                                                                                        <table align="left" class="column" style="width: 280px;min-width: 279px;float:left;">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td style="padding: 15px;">
                                                                                                        <h5 class="">Bạn cần trợ giúp? Liên hệ với chúng tôi:</h5>
                                                                                                        <p style="font-size:14px;line-height:1.6">
                                                                                                            Phone: <strong>408.341.0600</strong><br>
                                                                                                            Email: <strong><a href="emailto:giaonhanviec@gmail.com" style="color:#1fcf93">giaonhanviec@gmail.com</a></strong>
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                        <span class="clear"></span>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                        <table class="footer-wrap" style="width: 100%;  clear:both!important;">
                                            <tbody>
                                                <tr>
                                                    <td class="container" style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important;">
                                                        <div class="content" style="padding:15px;max-width:600px;margin:0 auto;display:block;">
                                                            <table style="width: 100%;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center">
                                                                            <p style="border-top: 1px solid rgb(215,215,215); padding-top:15px;font-size:10px;font-weight: bold;">
                                                                                <a href="#">Terms</a> |
                                                                                <a href="#">Privacy</a> |
                                                                                <a href="#"><unsubscribe>Unsubscribe</unsubscribe></a>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </body>')
                        ->send();
                // gui mail danh gia cho nhan vien
                Yii::$app->mailer->compose()
                        ->setTo($actor->email)
                        ->setFrom([Yii::$app->params['adminEmail'] => 'Giao nhận việc'])
                        ->setSubject('Công việc của bạn đã được hoàn thành Giaonhanviec.com')
                        ->setHtmlBody('<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                                    <meta name="viewport" content="width=device-width">
                                    <title>ZURBemails</title>
                                    <!--<link rel="stylesheet" type="text/css" href="./ZURBemails_files/email.css">-->
                                </head>
                                <body bgcolor="#FFFFFF" style="-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width: 100%!important;height: 100%;font-family: HelveticaNeue-Light, Helvetica Neue Light, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif; line-height: 1.1; margin:0 0 15px; color:#000;">
                                    <table class="head-wrap" bgcolor="#00adef" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td class="header container" style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important;">
                                                    <div class="content" style="max-width:600px;margin:0 auto;">
                                                        <table style="width: 100%;">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding:10px 0"><img src="http://files.giaonhanviec.com/gnv/logo-gnv-250.png" style="max-width: 100%;"></td>
                                                                    <td style="" align="right"><h6 style="margin: 0!important;color:#fff">Ngày ' . date('d', time()) . ' tháng ' . date('m', time()) . ' năm ' . date('Y', time()) . '</h6></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <table class="body-wrap" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td class="container" bgcolor="#FFFFFF" style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important;">
                                                    <div class="content" style="max-width:600px;margin:0 auto;display:block;">
                                                        <table style="width: 100%;">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <h3 style="padding-top:10px;font-weight:500;font-size:27px;color:#238e23">Xin chào, ' . $actor->name . '</h3>
                                                                        <p class="lead" style="font-size:14px;line-height:1.6">Công việc "<span style="color:#00adef">' . $job->name . '</span>" trên hệ thống Giaonhanviec của bạn đã kết thúc!</p>
                                                                        
                                                                        <p><img src="' . Yii::$app->setting->value('site_url') . '/images/banner_emai.png" style="max-width: 100%; min-width: 100%;"></p>
                                                                        
                                                                        <h3>Dành cho nhân viên</h3>
                                                                        <p style="font-size:14px;line-height:1.6">Để điều chỉnh những thiếu xót, hạn chế trong quá trình làm việc và nâng cao chất lượng công việc, Xin hãy dành ít thời gian để đánh giá khách hàng đã làm việc với bạn.</p>
                                                                        <a href="http://' . Yii::$app->setting->value('site_url') . '/danh-gia?ty=me&id=' . $model->_id . '&ac=' . $actor->_id . '" class="btn" style="text-decoration:none;color: #FFF;background-color: #1fcf93;padding:10px 16px;font-weight:bold;margin-right:10px;text-align:center;cursor:pointer;display: inline-block;border-bottom:2px solid #1ab07d;font-weight:400;font-size:18px;">Đánh giá khách hàng →</a>
                                                                        <br>
                                                                        <p class="callout" style="padding:15px;background-color:#ECF8FF;margin-bottom: 15px;font-size:14px;line-height:1.6">
                                                                            <i>Đây là email tự động, vui lòng không trả lời email này.</i>
                                                                        </p>
                                                                        <br>
                                                                        
                                                                        <table class="social" width="100%" style="background-color: #ebebeb;">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table align="left" class="column" style="width: 100%;width: 300px;float:left;">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td style="padding: 15px;">
                                                                                                        <h5 class="">Kết nối với giaonhanviec.com:</h5>
                                                                                                        <p class="">
                                                                                                            <a href="#" class="soc-btn fb" style="padding: 3px 7px;font-size:12px;margin-bottom:10px;text-decoration:none;color: #FFF;font-weight:bold;display:block;text-align:center;background-color: #3B5998!important;">Facebook</a>
                                                                                                            <a href="#" class="soc-btn tw" style="padding: 3px 7px;font-size:12px;margin-bottom:10px;text-decoration:none;color: #FFF;font-weight:bold;display:block;text-align:center;background-color: #1daced!important;">Twitter</a>
                                                                                                            <a href="#" class="soc-btn gp" style="padding: 3px 7px;font-size:12px;margin-bottom:10px;text-decoration:none;color: #FFF;font-weight:bold;display:block;text-align:center;background-color: #DB4A39!important;">Google+</a>
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                            
                                                                                        <table align="left" class="column" style="width: 280px;min-width: 279px;float:left;">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td style="padding: 15px;">
                                                                                                        <h5 class="">Bạn cần trợ giúp? Liên hệ với chúng tôi:</h5>
                                                                                                        <p style="font-size:14px;line-height:1.6">
                                                                                                            Phone: <strong>408.341.0600</strong><br>
                                                                                                            Email: <strong><a href="emailto:giaonhanviec@gmail.com" style="color:#1fcf93">giaonhanviec@gmail.com</a></strong>
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                        <span class="clear"></span>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                        <table class="footer-wrap" style="width: 100%;  clear:both!important;">
                                            <tbody>
                                                <tr>
                                                    <td class="container" style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important;">
                                                        <div class="content" style="padding:15px;max-width:600px;margin:0 auto;display:block;">
                                                            <table style="width: 100%;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center">
                                                                            <p style="border-top: 1px solid rgb(215,215,215); padding-top:15px;font-size:10px;font-weight: bold;">
                                                                                <a href="#">Terms</a> |
                                                                                <a href="#">Privacy</a> |
                                                                                <a href="#"><unsubscribe>Unsubscribe</unsubscribe></a>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </body>')
                        ->send();
            }
        }
        return $this->redirect(['view', 'id' => (string) $id]);
    }

    public function actionSkill()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Sectors::findOne($_POST['id']);
        $data = [];
        if (!empty($model->skills))
        {
            foreach ($model->skills as $key => $value)
            {
                $data[] = ['id' => $value, 'name' => Skills::findOne($value)->name];
            }
        }
        return $data;
    }

    public function actionSector()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Sectors::find()->where(['category_id' => $_POST['id']])->all();
        if (!empty($model))
        {
            foreach ($model as $value)
            {
                $data[] = ['id' => (string) $value['_id'], 'name' => $value['name']];
            }
            return $data;
        }
    }

    public function actionFeatured()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Job::findOne($_POST['Job']['id']);
        if (!empty($model))
        {
            $model->featured = (int) $_POST['Job']['featured'];
            if ($model->save())
                return [1];
        }
    }

    public function actionExport()
    {
        $time = date('d/m/Y', time());
        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
        header("Content-Disposition: attachment; filename=dscv_" . time() . ".csv");
        header("Pragma: no-cache");
        header("Expires: 0");

        $output = fopen('php://output', 'w');

        fputcsv($output, ['Bảng công việc tháng 12', '']);
        fputcsv($output, ['Tên', 'Mô tả công viêc']);
        $model = Job::find()->all();
        $array = [];
        foreach ($model as $key => $value)
        {
            $array['Tên'] = $value->name;
            fputcsv($output, $array);
        }
    }

}
