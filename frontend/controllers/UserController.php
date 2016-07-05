<?php

namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\mongodb\ActiveRecord;
use yii\mongodb\ActiveQueryInterface;
use yii\mongodb\Query;
use common\models\User;
use common\models\Job;
use common\models\Review;
use common\models\Assignment;
use common\models\ChangePassword;
use common\models\FogotPassword;
use common\models\EditPassword;
use common\models\JobInvited;
use common\models\Bid;
use common\models\PersonalStorage;
use common\models\Conversation;
use common\models\Test;
use common\models\Education;
use common\models\WorkProcess;
use common\models\WorkDone;
use common\models\Messages;
use common\models\UserBid;
use common\models\Notification;
use common\models\PaymentHistory;

class UserController extends FrontendController
{

    public function behaviors()
    {
        return [
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));

        if (!empty($_GET['slug']))
            $model = User::find()->where(['slug' => $_GET['slug']])->one();
        else
            $model = User::findOne(Yii::$app->user->identity->id);
        if (!empty($_GET['notify']))
        {
            $notify = Notification::findOne($_GET['notify']);
            $notify->status = 2;
            $notify->save();
        }
        if (!empty($model))
        {
            $comment = User::getComment((string) $model->_id);
            $invited = new JobInvited();
            if ($model->role == User::ROLE_BOSS)
            {
                $userbid = UserBid::find()->where(['actor_id' => (string) \Yii::$app->user->id, 'owner_id' => (string) $model->id, 'status' => UserBid::STATUS_NOACCEPT])->one();
                $job = Job::find()->where(['owner' => (string) $model->_id, 'status' => Job::PROJECT_OVER])->orderBy(['created_at' => SORT_DESC])->limit(3)->all();
                return $this->render('boss', ['model' => $model, 'job' => $job, 'comment' => $comment, 'userbid' => $userbid]);
            }
            else
            {
                $job = Job::find()->where(['owner' => (string) Yii::$app->user->id])->andWhere(['between', 'status_boss', Assignment::STATUS_COMPLETE, Assignment::STATUS_REVIEW])->all();
                $assignment = Assignment::find()->where(['actor' => (string) $model->id])->all();
                $test = Test::find()->where(['user_id' => (string) $model->id])->orderBy(['created_at' => SORT_ASC])->all();
                $workprocess = WorkProcess::find()->where(['user_id' => (string) $model->id])->all();
                $workdone = WorkDone::find()->where(['user_id' => (string) $model->id])->all();
                $edu = Education::find()->where(['user_id' => (string) $model->id])->all();
                return $this->render('member', ['model' => $model, 'job' => $job, 'invited' => $invited, 'userbid' => new UserBid(), 'assignment' => $assignment, 'test' => $test, 'workprocess' => $workprocess, 'edu' => $edu, 'workdone' => $workdone]);
            }
        }
        else
        {
            throw new NotFoundHttpException('User này không tồn tại trong hệ thống.');
        }
    }

    public function actionChangepassword()
    {
        if (\Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
        $model = new ChangePassword();
        $user = User::findOne(Yii::$app->user->identity->id);
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                $user->setPassword($model->password_new);
                if ($user->save())
                {
                    Yii::$app->user->logout();
                    $this->redirect('/dang-nhap');
                }
            }
        }
        return $this->render('changepassword', ['model' => $model, 'user' => $user]);
    }

    public function actionFogotpassword()
    {
        $model = new FogotPassword();
        if ($model->load(Yii::$app->request->post()))
        {
            $user = new User();
            $authKey = $user->getAuthkeyUser($model->email);
            if ($model->validate())
            {
                Yii::$app->mailer->compose()
                        ->setTo($model->email)
                        ->setFrom([Yii::$app->params['adminEmail'] => 'Giao nhận việc'])
                        ->setSubject('Đặt lại mật khẩu của bạn trên Giaonhanviec.com')
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
                                                                            <h3 style="padding-top:10px;font-weight:500;font-size:27px;color:#238e23">Xin chào,</h3>
                                                                            <p class="lead" style="font-size:14px;line-height:1.6">Giaonhanviec đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Nếu bạn không yêu cầu đặt lại mật khẩu, xin hãy bỏ qua email này.</p>
                                                                            
                                                                            <a class="btn" href="' . Yii::$app->setting->value('site_url') . '/cai-dat-mat-khau?email=' . $model->email . '&auth_key=' . $authKey . '" style="text-decoration:none;color: #FFF;background-color: #1fcf93;padding:10px 16px;font-weight:bold;margin-right:10px;text-align:center;cursor:pointer;display: inline-block;border-bottom:2px solid #1ab07d;font-weight:400;font-size:18px;">Đặt lại mật khẩu →</a>
                                                                            <br>
                                                                            <p class="callout" style="padding:15px;background-color:#ECF8FF;margin-bottom: 15px;font-size:14px">
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
                                                                                                            <p style="font-size:14px">
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
                                                                                    <a href="http://zurb.com/playground/projects/responsive-email-templates/hero.html#">Terms</a> |
                                                                                    <a href="http://zurb.com/playground/projects/responsive-email-templates/hero.html#">Privacy</a> |
                                                                                    <a href="http://zurb.com/playground/projects/responsive-email-templates/hero.html#"><unsubscribe>Unsubscribe</unsubscribe></a>
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
                return $this->redirect(['site/login']);
            }
        }
        return $this->render('fogotpassword', ['model' => $model]);
    }

    public function actionResetpassword()
    {
        $user = new User();
        $model = new EditPassword();


        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                $user = User::find()->where([ 'email' => $_GET['email']])->one();
                $user->setPassword($model->password);
                if ($user->save())
                {
                    $this->redirect(['site/login']);
                }
            }
        }
        $authKey = $user->getAuthkeyUser($_GET['email']);
        $member = User::find()->where([ 'email' => $_GET['email']])->exists();
        if (!$member)
        {
            $user->email = $_GET['email'];
            $user->generateAuthKey();
            if ($user->save())
            {
                return $this->render('resetpassword', ['user' => $user, 'model' => $model, 'add' => 1]);
            }
        }
        else
        {
            if ($authKey == $_GET['auth_key'])
            {
                $user = $user->getUserbyemail($_GET['email']);
                return $this->render('resetpassword', ['user' => $user, 'model' => $model, 'add' => 2]);
            }
            else
            {
                throw new \yii\web\NotFoundHttpException('Truy cập không hợp lệ.');
            }
        }
    }

    public function actionReview()
    {
        $model = new Review();
        $assignment = Assignment::findOne($_GET['id']);
        if (!empty($_GET['ty']))
        {
            if ($_GET['ty'] == 'me')
            {
                $assig = Assignment::find()->where(['_id' => $_GET['id'], 'actor' => $_GET['ac'], 'status_member' => Assignment::STATUS_COMPLETE])->exists();
            }
            if ($_GET['ty'] == 'bo')
            {
                $assig = Assignment::find()->where(['_id' => $_GET['id'], 'owner' => $_GET['ac'], 'status_boss' => Assignment::STATUS_COMPLETE])->exists();
            }
            $bestmember = User::find()->where(['role' => User::ROLE_MEMBER])->orderBy(['rating' => SORT_DESC])->limit('10')->all();

            if ($assig)
            {
                $owner = Assignment::getOwner($_GET['id'], $_GET['ac']);
                $user = User::findOne($owner);
                $comment = User::getComment($owner);
                if ($model->load(Yii::$app->request->post()))
                {
                    if ($model->validate())
                    {
                        $model->assignment = $_GET['id'];
                        $model->actor = $_GET['ac'];
                        $model->rating = (int) $model->rating;
                        $model->created_at = time();
                        if ($model->save())
                        {
                            $user->rating = (int) $user->getPoint($owner);
                            $review = Review::find()->where(['actor' => $model->actor])->count();
                            $job = Assignment::find()->where(['actor' => $model->actor])->andWhere(['between', 'status_member', Assignment::STATUS_COMPLETE, Assignment::STATUS_REVIEW])->all();
                            $levels = \common\models\Level::find()->all();
                            $tamp = $levels[1]->id;
                            foreach ($levels as $level)
                            {
                                if (($user->rating >= $level->rating) && ($review >= $level->review) && ($job >= $level->count_job))
                                    $tamp = $level->id;
                                else
                                    $tamp = $tamp;
                            }
                            $user->level = $tamp;
                            if ($user->save())
                            {
                                if ($tamp != $user->level)
                                {
                                    $notify = new Notification();
                                    $notify->owner = Yii::$app->user->id;
                                    $notify->actor = $model->actor;
                                    $notify->type = 'user';
                                    $notify->type_id = $model->actor;
                                    $notify->content = $notify->getMessages(28);
                                    $notify->created_at = time();
                                    $notify->save();
                                }
                            }
                            if ($_GET['ty'] == 'me')
                            {
                                $assignment->status_member = Assignment::STATUS_REVIEW;
                                $assignment->save();
                            }
                            if ($_GET['ty'] == 'bo')
                            {
                                $assignment->status_boss = Assignment::STATUS_REVIEW;
                                $assignment->save();
                            }
                            $this->redirect(['site/thankyou']);
                        }
                    }
                }
                return $this->render('review', ['model' => $model, 'assignment' => $assignment, 'user' => $user, 'bestmember' => $bestmember, 'comment' => $comment]);
            }
            else
            {
                throw new \yii\web\NotFoundHttpException('Truy cập không hợp lệ.');
            }
        }
        else
        {
            throw new \yii\web\NotFoundHttpException('Truy cập không hợp lệ.');
        }
    }

    public function actionInfo()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
        if (\Yii::$app->user->identity->role == User::ROLE_BOSS)
        {
            //thong ke thanh toan
            $deposit = Job::find()->where(['owner' => (string) Yii::$app->user->identity->id, 'publish' => Job::PUBLISH_ACTIVE, 'block' => Job::JOB_UNBLOCK, 'status' => Job::PROJECT_PENDING])->all();
            $arrdep = [];
            $arrpay = [];
            foreach ($deposit as $value)
            {
                if ($value->category->deposit > 0)
                {
                    $arrdep[] = (string) $value->_id;
                }
            }
            $job_deposit = Job::find()->where(['IN', '_id', $arrdep])->all();
            $payment = Job::find()->where(['owner' => (string) Yii::$app->user->identity->id, 'publish' => Job::PUBLISH_ACTIVE, 'block' => Job::JOB_UNBLOCK, 'status' => Job::PROJECT_DEPOSIT])->all();
            $job_payment = Job::find()->where(['IN', '_id', $arrpay])->all();
            $payment_his = PaymentHistory::find()->where(['user' => (string) Yii::$app->user->identity->id])->all();

            $pending = Job::find()->where(['owner' => (string) \Yii::$app->user->identity->id, 'status' => Job::PROJECT_PUBLISH])->all();
            $making = Job::find()->where(['owner' => (string) \Yii::$app->user->id, 'status' => Job::PROJECT_DEPOSIT])->all();
            $completed = Job::find()->where(['owner' => (string) \Yii::$app->user->id, 'status' => Job::PROJECT_COMPLETED])->limit(4)->all();
            $user = User::findOne((string) \Yii::$app->user->identity->id);
            $listing = PersonalStorage::find()->where(['owner' => (string) \Yii::$app->user->id, 'status' => 1])->all();
            $conversation = Conversation::find()->where(['actor' => (string) \Yii::$app->user->id])->orderBy(['created_at' => SORT_ASC])->limit(20)->all();
            $messages = Messages::find()->where(['owner' => (string) Yii::$app->user->id])->orWhere(['actor' => (string) Yii::$app->user->id])->orderBy(['created_at' => SORT_DESC])->limit(5)->all();
            return $this->render('infoboss', ['pending' => $pending, 'making' => $making, 'completed' => $completed, 'user' => $user, 'listing' => $listing, 'conversation' => $conversation, 'messages' => $messages, 'deposit' => $job_deposit, 'payment' => $payment, 'payment_history' => $payment_his]);
        }
        else
        {
            $bid = Bid::find()->where(['actor' => (string) \Yii::$app->user->identity->id, 'status' => 0])->all();
            $assign = Assignment::find()->where(['actor' => (string) Yii::$app->user->identity->id, 'status_member' => Assignment::STATUS_GIVE])->andWhere(['between', 'status_boss', Assignment::STATUS_GIVE, Assignment::STATUS_DEPOSIT])->all();
            $making = Assignment::find()->where(['actor' => (string) Yii::$app->user->identity->id, 'status_member' => Assignment::STATUS_COMMITMENT])->andWhere(['between', 'status_boss', Assignment::STATUS_COMMITMENT, Assignment::STATUS_PAYMENT])->all();
            $completed = Assignment::find()->where(['actor' => (string) Yii::$app->user->identity->id])->andWhere(['between', 'status_boss', Assignment::STATUS_COMPLETE, Assignment::STATUS_REVIEW])->all();
            $give = Assignment::find()->where(['actor' => (string) Yii::$app->user->identity->id])->andWhere(['between', 'status_boss', Assignment::STATUS_GIVE, Assignment::STATUS_REVIEW])->all();

            $thismonth = [];
            foreach ($completed as $value)
            {
                $lastday = strtotime('last day of this month', time());
                $firstday = strtotime('first day of this month', time());
                if (($value->endday >= $firstday) && ($value->endday <= $lastday))
                {
                    $thismonth[] = (string) $value->_id;
                }
            }
            $job_thismonth = Assignment::find()->where(['IN', '_id', $thismonth])->all();
            //cong viec dang book
            $arrbid = [];
            $arrgive = [];
            foreach ($bid as $key => $value)
            {
                $arrbid[] = (string) $value->job_id;
            }
            foreach ($give as $key => $value)
            {
                $arrgive[] = (string) $value->job_id;
            }
            $result = array_diff($arrbid, $arrgive);

            $jobbid = Bid::find()->where(['actor' => (string) \Yii::$app->user->identity->id, 'status' => 0])->andWhere(['IN', 'job_id', $result])->all();
            $jobsave = PersonalStorage::find()->where(['user_id' => (string) \Yii::$app->user->id])->all();
            $user = User::findOne((string) \Yii::$app->user->identity->id);
            $test = Test::find()->where(['user_id' => (string) \Yii::$app->user->id])->orderBy(['created_at' => SORT_ASC])->all();
            $conversation = Conversation::find()->where(['actor' => (string) \Yii::$app->user->id])->orderBy(['created_at' => SORT_ASC])->limit(20)->all();
            $messages = Messages::find()->where(['owner' => (string) Yii::$app->user->id])->orWhere(['actor' => (string) Yii::$app->user->id])->orderBy(['created_at' => SORT_DESC])->limit(5)->all();
            return $this->render('infomember', ['jobbid' => $jobbid, 'making' => $making, 'completed' => $completed, 'job_thismonth' => $job_thismonth, 'jobsave' => $jobsave, 'user' => $user, 'conversation' => $conversation, 'messages' => $messages]);
        }
    }

}
