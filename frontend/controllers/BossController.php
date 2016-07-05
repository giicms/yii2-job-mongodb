<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\Boss;
use frontend\models\BossInfo;
use common\models\City;
use common\models\District;
use common\models\PersonalStorage;
use common\models\Job;
use common\models\Conversation;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\mongodb\ActiveRecord;
use yii\mongodb\ActiveQueryInterface;
use yii\mongodb\Query;

class BossController extends Controller {

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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionRegister() {
        $model = new Boss();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $user = new User();
                $user->name = $model->name;
                $user->slug = $user->getUsername($model->name)['slug'];
                $user->serial = $user->getUsername($model->name)['serial'];
                $user->slugname = str_replace("-", " ", Yii::$app->convert->string($model->name));
                $user->phone = $model->phone;
                $user->email = $model->email;
                $user->questions = $model->questions;
                $user->email_active = $model->email_active;
                $user->created_at = $user->updated_at = time();
                $user->role = User::ROLE_BOSS;
                $user->step = User::STEP_REG;
                $user->status = User::STATUS_NOACTIVE;
                $user->setPassword($model->password);
                $user->generateAuthKey();

                if ($user->save()) {
                    Yii::$app->mailer->compose()
                            ->setTo($user->email)
                            ->setFrom([Yii::$app->params['adminEmail'] => 'Giao nhận việc'])
                            ->setSubject('Xác nhận tài khoản')
                            ->setHtmlBody('<head>
                                                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
                                                                                <td style="" align="right"><h6 style="margin: 0!important;color:#fff">giaonhanviec.com</h6></td>
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
                                                                                    <h3 style="padding-top:10px;font-weight:500;font-size:27px;color:#238e23">Xin chào, '.$user->name.'</h3>
                                                                                    <p class="lead" style="font-size:14px">Chúc mừng bạn đăng ký thành công tài khoản trên Giaonhanviec.</p>
                                                                                    
                                                                                    <p><img src="http://layout.giaonhanviec.com/images/banner_emai.png" style="max-width: 100%; min-width: 100%;"></p>
                                                                                    
                                                                                    <p style="font-size:14px">Để bắt đầu hoạt động trên hệ thống Giaonhanviec, Vui lòng bấm vào link này để kích hoạt tài khoản Khách hàng của bạn.</p>
                                                                                    
                                                                                    <a class="btn" href="'.Yii::$app->setting->value('site_url').'/boss/account?email=' . $user->email . '&auth_key=' . $user->auth_key.'" style="text-decoration:none;color: #FFF;background-color: #1fcf93;padding:10px 16px;font-weight:bold;margin-right:10px;text-align:center;cursor:pointer;display: inline-block;border-bottom:2px solid #1ab07d;font-weight:400;font-size:18px;">Kích hoạt tài khoản →</a>
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
                                                </body>')->send();
                    return $this->redirect(['active', 'id' => (string) $user->_id]);
                }
            }
        }

        return $this->render('register', [
                    'model' => $model
        ]);
    }

    public function actionActive($id) {

        $model = User::findOne($id);
        if (!empty($model)) {
            return $this->render('active', [
                        'model' => $model
            ]);
        } else {
            throw new \yii\web\NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    public function actionAccount() {
        if (!empty($_GET['email'])) {
            $user = User::find()->where(['email' => $_GET['email'], 'status' => User::STATUS_NOACTIVE, 'auth_key' => $_GET['auth_key']])->one();
            if (!empty($user)) {
                $user->status = User::STATUS_ACTIVE;
                if ($user->save())
                    if (Yii::$app->getUser()->login($user)) {
                        return $this->redirect(['authentication',
                                    'id' => (string) $user['_id']
                        ]);
                    }
            } else {
                throw new \yii\web\NotFoundHttpException('Tài khoản này không tồn tại trong hệ thống.');
            }
        } else {
            throw new \yii\web\NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    public function actionAuthentication($id) {
        $user = User::findOne($id);
        if (!empty($user) && $user->status == User::STATUS_ACTIVE) {
            return $this->render('auth', ['model' => $user]);
        } else {
            throw new \yii\web\NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    public function actionProfile() {
        $model = User::findOne((string) Yii::$app->user->identity->id);
        return $this->render('profile', ['model' => $model]);
    }

    public function actionChangeinfo() {
        $model = new BossInfo();
        $user = User::findOne((string) Yii::$app->user->identity->id);
        $district = District::find()->where(['city_id' => $user->city])->all();
        if ($model->load(Yii::$app->request->post())) {
            $user->name = $model->name;
            $user->avatar = $model->avatar;
            $user->slug = $user->getUsername($model->name)['slug'];
            $user->serial = $user->getUsername($model->name)['serial'];
            $user->slugname = str_replace("-", " ", Yii::$app->convert->string($model->name));
            $user->email = $model->email;
            $user->phone = $model->phone;
            $user->boss_type = $model->boss_type;
            if ($model->boss_type == 2) {
                $user->company_name = $model->company_name;
                $user->company_code = $model->company_code;
            }
            $user->address = $model->address;
            $user->city = $model->city;
            $user->district = $model->district;
            $user->step = User::STEP_COMPLE;
            if ($user->save())
                $this->redirect(['profile']);
        }
        $data = [];
        if ($district) {
            foreach ($district as $value) {
                $data[(string) $value['_id']] = $value['name'];
            }
        }
        $model->city = $user->city;
        $model->district = $user->district;
        return $this->render('changeinfo', ['model' => $model, 'user' => $user, 'district' => $data]);
    }

    public function actionUser($id) {
        $user = User::findOne($id);
        $job = Job::find()->where(['owner' => $id])->orderBy(['created_at' => SORT_DESC])->limit(3)->all();
        return $this->render('view', ['user' => $user, 'job' => $job]);
    }

    public function actionPersonalinfo() {
        $pending = Job::find()->where(['owner' => (string) \Yii::$app->user->identity->id, 'status' => Job::PROJECT_PENDING])->all();
        $making = Job::find()->where(['owner' => (string) \Yii::$app->user->identity->id, 'status' => Job::PROJECT_MAKING])->all();
        $completed = Job::find()->where(['owner' => (string) \Yii::$app->user->identity->id, 'status' => Job::PROJECT_COMPLETED])->all();
        $user = User::findOne((string) \Yii::$app->user->identity->id);
        $listing = PersonalStorage::find()->where(['owner' => (string) \Yii::$app->user->identity->id, 'status' => 1]);
        $conversation = Conversation::find()->where(['actor' => (string) \Yii::$app->user->identity->id])->orderBy(['created_at' => SORT_ASC])->limit(20)->all();
        return $this->render('personalinfo', ['pending' => $pending, 'making' => $making, 'complete' => $completed, 'user' => $user, 'listing' => $listing, 'conversation' => $conversation]);
    }

    public function actionSaveus() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = User::findOne(Yii::$app->user->id);
        $data = !empty($_POST['BossInfo']) ? $_POST['BossInfo'] : $_POST['Profile'];
        if (!empty($data)) {
            $model->name = $data['name'];
            $model->email = $data['email'];
            $model->phone = $data['phone'];
            $model->boss_type = $data['boss_type'];
            $model->address = $data['address'];
            $model->city = $data['city'];
            $model->district = $data['district'];
            if ($data['company_name'] != 0) {
                $model->company_name = $data['company_name'];
            }
            if ($data['company_code'] != 0) {
                $model->company_code = $data['company_code'];
            }
            $model->save();
        }
    }

}
