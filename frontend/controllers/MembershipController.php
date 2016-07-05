<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\mongodb\ActiveRecord;
use yii\mongodb\ActiveQueryInterface;
use yii\mongodb\Query;
use yii\data\Pagination;
use common\models\User;
use common\models\City;
use common\models\Bid;
use common\models\PersonalStorage;
use frontend\models\Membership;
use frontend\models\Profile;
use frontend\models\MembershipInfo;
use common\models\Language;
use common\models\UserLang;
use common\models\Category;
use common\models\Level;
use common\models\WorkProcess;
use common\models\Education;
use common\models\WorkDone;
use common\models\Sectors;
use common\models\Job;
use common\models\JobInvited;
use common\models\Conversation;
use common\models\Bank;
use common\models\Bankbranch;
use common\models\Bankaccount;
use common\models\UserBid;

class MembershipController extends FrontendController
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $category = Category::find()->all();
        $sector = Sectors::find()->all();
        $level = Level::find()->all();
        $city = City::find()->all();
        if (\Yii::$app->user->isGuest)
        {
            $query = User::find()->where(['role' => User::ROLE_MEMBER, 'step' => 5]);
            $job = [];
        }
        else
        {
            $userbook = UserBid::find()->where(['owner_id' => (string) \Yii::$app->user->id])->all();
            $ids = [];
            if (!empty($userbook))
            {
                foreach ($userbook as $value)
                {
                    $ids[] = $value->actor_id;
                }
            }
            $query = User::find()->where(['role' => User::ROLE_MEMBER, 'step' => 5])->andWhere(['NOT IN', '_id', $ids]);
            $job = Job::find()->where(['owner' => (string) \Yii::$app->user->id, 'publish' => Job::PUBLISH_ACTIVE])->all();
        }
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['page']]);
        $model = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        $invited = new JobInvited();
        $userbid = new UserBid();
        return $this->render('index', ['category' => $category, 'sector' => $sector, 'level' => $level, 'city' => $city, 'model' => $model, 'job' => $job, 'invited' => $invited, 'userbid' => $userbid, 'pages' => $pages]);
    }

    public function actionRegister()
    {
        $model = new Membership();
        $level = Level::find()->where(['order' => '1'])->one();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                $user = new User();
                $user->name = $model->name;
                $user->slug = $user->getUsername($model->name)['slug'];
                $user->serial = $user->getUsername($model->name)['serial'];
                $user->slugname = str_replace("-", " ", Yii::$app->convert->string($model->name));
                $user->phone = $model->phone;
                $user->email = $model->email;
                $user->fbid = $model->fbid;
                $user->level = $level->id;
                $user->questions = $model->questions;
                $user->email_active = $model->email_active;
                $user->created_at = $user->updated_at = time();
                $user->step = User::STEP_REG;
                $user->setPassword($model->password);
                $user->generateAuthKey();
                $user->role = User::ROLE_MEMBER;
                if ($user->save())
                {
                    $url = Yii::$app->setting->value('site_url') . '/membership/account?email=' . $user->email . '&auth_key=' . $user->authkey;
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
                                                                                    <h3 style="padding-top:10px;font-weight:500;font-size:27px;color:#238e23">Xin chào, ' . $user->name . '</h3>
                                                                                    <p class="lead" style="font-size:14px">Chúc mừng bạn đăng ký thành công tài khoản trên Giaonhanviec.</p>
                                                                                    
                                                                                    <p><img src="http://layout.giaonhanviec.com/images/banner_emai.png" style="max-width: 100%; min-width: 100%;"></p>
                                                                                    
                                                                                    <p style="font-size:14px">Để bắt đầu hoạt động trên hệ thống Giaonhanviec, Vui lòng bấm vào link này để kích hoạt tài khoản nhân viên của bạn.</p>
                                                                                    
                                                                                    <a class="btn" href="' . $url . '" style="text-decoration:none;color: #FFF;background-color: #1fcf93;padding:10px 16px;font-weight:bold;margin-right:10px;text-align:center;cursor:pointer;display: inline-block;border-bottom:2px solid #1ab07d;font-weight:400;font-size:18px;">Kích hoạt tài khoản →</a>
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

    public function actionActive($id)
    {

        $model = User::findOne($id);
        if (!empty($model))
        {
            return $this->render('active', [
                        'model' => $model
            ]);
        }
        else
        {
            throw new \yii\web\NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    public function actionAccount()
    {
        if (!empty($_GET['email']))
        {
            $user = User::find()->where(['email' => $_GET['email'], 'status' => User::STATUS_NOACTIVE, 'auth_key' => $_GET['auth_key']])->one();
            if (!empty($user))
            {
                $user->status = User::STATUS_ACTIVE;
                if ($user->save())
                {
                    if (Yii::$app->getUser()->login($user))
                    {
                        return $this->redirect(['authentication',
                                    'id' => (string) $user['_id']
                        ]);
                    }
                }
            }
            else
            {
                throw new \yii\web\NotFoundHttpException('Tài khoản này không tồn tại trong hệ thống.');
            }
        }
        else
        {
            throw new \yii\web\NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    public function actionAuthentication($id)
    {
        $user = User::findOne($id);
        if (!empty($user) && $user->status == User::STATUS_ACTIVE)
        {
            return $this->render('auth', ['model' => $user]);
        }
    }

    public function actionSuccess()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
        if (Yii::$app->user->identity->step == User::STEP_REG)
            $this->redirect(['jobcategories']);
        $model = User::findOne((string) \Yii::$app->user->identity->id);
        return $this->render('success', [
                    'model' => $model
        ]);
        if (Yii::$app->user->identity->step == User::STEP_CATE)
            $this->redirect(['about']);
        if (Yii::$app->user->identity->step == User::STEP_ABOUT)
            $this->redirect(['experience']);
        if (Yii::$app->user->identity->step == User::STEP_EXPRESS)
            $this->redirect(['complete']);
    }

    public function actionJobcategories()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
        if (Yii::$app->user->identity->step == User::STEP_CATE)
            $this->redirect(['about']);
        if (Yii::$app->user->identity->step == User::STEP_ABOUT)
            $this->redirect(['experience']);
        if (Yii::$app->user->identity->step == User::STEP_EXPRESS)
            $this->redirect(['complete']);
        $model = User::findOne((string) \Yii::$app->user->identity->id);
        $jobCategory = Category::find()->all();
        if ($model->load(Yii::$app->request->post()))
        {
            if (empty($_POST['User']['sector']))
            {
                Yii::$app->session->setFlash('error', 'Bạn hãy chọn ngành nghề và lĩnh vực phù hợp với bạn!');
            }
            else
            {
                $model->category = $_POST['User']['category'];
                $model->sector = $_POST['User']['sector'];
                $model->step = User::STEP_CATE;
                if ($model->save())
                {
                    $this->redirect(['about']);
                }
            }
        }

        return $this->render('category', [
                    'model' => $model,
                    'jobCategory' => $jobCategory
        ]);
    }

    //chọn kỹ năng cá nhân
    // public function actionSkills() {
    //     if (Yii::$app->user->isGuest)
    //         $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
    //     if (Yii::$app->user->identity->step == 2)
    //         $this->redirect(['about']);
    //     $model = User::findOne((string) \Yii::$app->user->identity->id);
    //     $sectors = Sectors::find()->where(['category_id' => $model->category])->all();
    //     if (!empty($_POST['skills'])) {
    //         $model->skills = $_POST['skills'];
    //         $model->step = 1;
    //         if ($model->save())
    //             $this->redirect(['about']);
    //     }
    //     return $this->render('skill', [
    //                 'model' => $model,
    //                 'sectors' => $sectors
    //     ]);
    // }
    // public function actionChangeskills() {
    //     if (Yii::$app->user->isGuest)
    //         $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
    //     $model = User::findOne((string) \Yii::$app->user->identity->id);
    //     $sectors = Sectors::find()->where(['category_id' => $model->category])->all();
    //     if (!empty($_POST['skills'])) {
    //         $model->skills = $_POST['skills'];
    //         if ($model->save())
    //             $this->redirect(['profile']);
    //     }
    //     return $this->render('changeskill', [
    //                 'model' => $model,
    //                 'sectors' => $sectors
    //     ]);
    // }

    public function actionAbout()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
        if (Yii::$app->user->identity->step == User::STEP_REG)
            $this->redirect(['jobcategories']);
        if (Yii::$app->user->identity->step == User::STEP_ABOUT)
            $this->redirect(['experience']);
        if (Yii::$app->user->identity->step == User::STEP_EXPRESS)
            $this->redirect(['complete']);
        $model = new Profile();
        $user = User::findOne((string) Yii::$app->user->identity->id);
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                $birthday = strtotime(str_replace('/', '-', $model->birthday));
                $user = User::findOne((string) Yii::$app->user->identity->id);
                $user->role = 'member';
                $model->birthday = \Yii::$app->convert->date($model->birthday);
                $user->cmnd = $model->cmnd;
                $user->address = $model->address;
                $user->district = $model->district;
                $user->city = $model->city;
                $user->birthday = $birthday;
                $user->avatar = $model->avatar;
                $user->description = $model->description;
                $user->step = User::STEP_ABOUT;

                if (!empty($_POST['skills']))
                {
                    $user->skills = $_POST['skills'];
                }
                else
                {
                    $user->skills = '';
                }
                if ($_POST['count_lang'] > 0)
                {
                    for ($i = 0; $i <= ((int) $_POST['count_lang'] + 1); $i++)
                    {
                        $user_lang = new UserLang();
                        $user_lang->user_id = (string) Yii::$app->user->identity->id;
                        $user_lang->language_id = $_POST['Profile']['language'][$i];
                        $user_lang->level_id = $_POST['Profile']['language_level'][$i];
                        $user_lang->save();
                    }
                }
                if ($user->save())
                {
                    return $this->redirect(['experience']);
                }
            }
        }
        return $this->render('about', [
                    'model' => $model, 'user' => $user
        ]);
    }

    // Kinh nghiem va ban than
    public function actionExperience()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
        if (Yii::$app->user->identity->step == User::STEP_REG)
            $this->redirect(['jobcategories']);
        if (Yii::$app->user->identity->step == User::STEP_CATE)
            $this->redirect(['about']);
        if (Yii::$app->user->identity->step == User::STEP_EXPRESS)
            $this->redirect(['complete']);
        $city = City::find()->all();
        $bankaccount = Bankaccount::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->one();
        $work = WorkProcess::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->all();
        $education = Education::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->all();
        $workdone = WorkDone::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->all();
        $user = User::findOne((string) \Yii::$app->user->identity->id);
        if (!empty($_POST['_csrf']))
        {
            $user->step = User::STEP_EXPRESS;
            if ($user->save())
            {
                $this->redirect(['complete']);
            }
        }
        return $this->render('experience', ['bankaccount' => $bankaccount, 'newbankaccount' => new Bankaccount(), 'work' => $work, 'education' => $education, 'workdone' => $workdone, 'newworkdone' => new WorkDone(), 'user' => $user, 'city' => $city]);
    }

    // Goi duyet ho so
    public function actionComplete()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
        $user = User::findOne((string) \Yii::$app->user->identity->id);
        if (!empty($_POST['_csrf']))
        {
            $user->step = User::STEP_COMPLE;
            $user->save();
            if ($user->step = User::STEP_COMPLE)
                Yii::$app->session->setFlash('success', 'Bạn gởi duyệt hồ sơ thành công. Chúng tôi sẽ kiểm duyệt hồ sơ của bạn trong thời gian sớm nhất.');
            elseif ($user->step = User::STEP_SUCCESS)
                Yii::$app->session->setFlash('success', 'Hồ sơ của bạn đã duyệt thành công.');
        }
        return $this->render('complete', ['user' => $user]);
    }

    // Ho so ca nhan
    public function actionProfile()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
        $model = User::findOne((string) \Yii::$app->user->identity->id);
        $city = City::find()->all();
        $user = User::findOne((string) \Yii::$app->user->identity->id);
        $bankaccount = Bankaccount::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->one();
        $work = WorkProcess::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->all();
        $education = Education::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->all();
        $workdone = WorkDone::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->all();
        $newworkdone = new WorkDone();
        return $this->render('profile', ['model' => $model, 'work' => $work, 'education' => $education, 'workdone' => $workdone, 'newworkdone' => $newworkdone, 'user' => $user, 'city' => $city, 'bankaccount' => $bankaccount, 'newbankaccount' => new Bankaccount()]);
    }

    public function actionChangeinfo()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
        $user = User::findOne((string) \Yii::$app->user->identity->id);
        $model = new MembershipInfo();
        if ($model->load(Yii::$app->request->post()))
        {
            $user->name = $model->name;
            $user->avatar = $model->avatar;
            $user->slug = $user->getUsername($model->name)['slug'];
            $user->serial = $user->getUsername($model->name)['serial'];
            $user->slugname = str_replace("-", " ", Yii::$app->convert->string($model->name));
            $user->email = $model->email;
            $user->fbid = $model->fbid;
            $user->phone = $model->phone;

            $user->birthday = strtotime(date_format(new \DateTime($model->birthday), 'Y-m-d 00:00:00'));
            $user->cmnd = $model->cmnd;
            $user->address = $model->address;
            $user->city = $model->city;
            $user->district = $model->district;
            $user->description = $model->description;
            $user->bankaccount = $model->bankaccount;
            if ($user->save())
                $this->redirect(['profile']);
        }
        return $this->render('changeinfo', ['model' => $model, 'user' => $user]);
    }

    public function actionBankaccount()
    {
        $this->layout = 'ajax';
        $bankaccount = Bankaccount::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->all();
        return $this->render('bankaccount', ['bankaccount' => $bankaccount]);
    }

    public function actionSelectbank()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = $_POST['id'];
        $banks = [];
        $data = [];
        $models = Bank::find()->all();
        foreach ($models as $bank)
        {
            if (in_array($id, $bank->city))
            {
                $banks[] = $bank->_id;
            }
        }
        $model = Bank::find()->where(['in', '_id', $banks])->all();
        if ($model)
        {
            foreach ($model as $value)
            {
                $data[] = ['id' => (string) $value->_id, 'name' => $value->name, 'code' => $value->code];
            }
        }
        return $data;
    }

    public function actionSelectbranch()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $bank = $_POST['bank'];
        $bank_local = $_POST['bank_local'];
        $data = [];
        $model = Bankbranch::find()->where(['bank' => (string) $bank, 'bank_local' => (string) $bank_local])->all();
        if ($model)
        {
            foreach ($model as $value)
            {
                $data[] = ['id' => (string) $value->_id, 'name' => $value->name];
            }
        }
        return $data;
    }

    public function actionWorkprocess()
    {
        $this->layout = 'ajax';
        $work = WorkProcess::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->all();
        return $this->render('workprocess', ['work' => $work]);
    }

    public function actionWorkdone()
    {
        $this->layout = 'ajax';
        $workdone = WorkDone::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->all();
        return $this->render('workdone', ['workdone' => $workdone]);
    }

    public function actionEducation()
    {
        $this->layout = 'ajax';
        $education = Education::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->all();
        return $this->render('education', ['education' => $education]);
    }

    public function getSkillname($id)
    {
        $model = Skills::findOne($id);
        return $model->name;
    }

    public function actionUser($id)
    {
        $model = User::findOne($id);
        if (!\Yii::$app->user->isGuest)
        {
            $job = Job::find()->where(['owner' => (string) \Yii::$app->user->identity->id])->all();
        }
        else
        {
            $job = '';
        }
        $invited = new JobInvited();
        return $this->render('user', ['model' => $model, 'job' => $job, 'invited' => $invited]);
    }

    public function actionPersonalinfo()
    {
        $jobbid = Bid::find()->where(['actor' => (string) \Yii::$app->user->identity->id, 'status' => 0])->all();
        $making = Bid::find()->where(['actor' => (string) \Yii::$app->user->identity->id, 'status' => 2])->all();
        $jobsave = PersonalStorage::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->all();
        $user = User::findOne((string) \Yii::$app->user->identity->id);
        $conversation = Conversation::find()->where(['actor' => (string) \Yii::$app->user->identity->id])->orderBy(['created_at' => SORT_ASC])->limit(20)->all();
        return $this->render('personalinfo', ['jobbid' => $jobbid, 'making' => $making, 'jobsave' => $jobsave, 'user' => $user, 'conversation' => $conversation]);
    }

    // search member
    public function actionSearch()
    {
        $category = Category::find()->all();
        $sector = Sectors::find()->all();
        $level = Level::find()->all();
        $city = City::find()->all();
        $query = User::find()->where([
                    'or',
                    ['like', 'name', $_GET['k']],
                    ['like', 'slugname', $_GET['k']]
                ])->andWhere(['role' => User::ROLE_MEMBER]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['page']]);
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();
        if (!\Yii::$app->user->isGuest)
        {
            $job = Job::find()->where(['owner' => (string) \Yii::$app->user->identity->id])->all();
        }
        else
        {
            $job = '';
        }
        $userbid = new UserBid();
        $invited = new JobInvited();
        return $this->render('index', ['category' => $category, 'sector' => $sector, 'level' => $level, 'city' => $city, 'model' => $model, 'job' => $job, 'invited' => $invited, 'userbid' => $userbid, 'pages' => $pages]);
    }

    // fillter member
    public function actionFillter()
    {
        $category = Category::find()->all();
        $sector = Sectors::find()->all();
        $level = Level::find()->all();
        $city = City::find()->all();
        $query = User::find();
        if (!empty($_GET['t']) or ! empty($_GET['s']) or ! empty($_GET['l']) or ! empty($_GET['c']) or ! empty($_GET['d']))
        {
            $query->where(['role' => User::ROLE_MEMBER]);
            if (!empty($_GET['t']))
            {
                $query->andWhere(['category' => $_GET['t']]);
            }
            if (!empty($_GET['s']))
            {
                $query->andWhere(['in', 'sector', explode(",", $_GET['s'])]);
            }
            if (!empty($_GET['l']))
            {
                $query->andWhere(['in', 'level', explode(",", $_GET['l'])]);
            }
            if (!empty($_GET['c']))
            {
                $query->andWhere(['in', 'city', explode(",", $_GET['c'])]);
            }
            if (!empty($_GET['d']))
            {
                $query->andWhere(['district' => $_GET['d']]);
            }
        }

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['page']]);
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();
        if (!\Yii::$app->user->isGuest)
        {
            $job = Job::find()->where(['owner' => (string) \Yii::$app->user->identity->id])->all();
        }
        else
        {
            $job = '';
        }
        $invited = new JobInvited();
        $userbid = new UserBid();
        return $this->render('index', ['category' => $category, 'sector' => $sector, 'level' => $level, 'city' => $city, 'model' => $model, 'job' => $job, 'invited' => $invited, 'userbid' => $userbid, 'pages' => $pages]);
    }

}
