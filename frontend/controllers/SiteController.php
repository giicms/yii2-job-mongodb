<?php

namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\Bid;
use common\models\User;
use common\models\Category;
use common\models\Job;
use common\models\City;
use common\models\Assignment;
use common\models\Review;
use common\models\BlogCategory;
use common\models\Posts;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\mongodb\ActiveRecord;
use yii\mongodb\ActiveQueryInterface;
use yii\mongodb\Query;

/**
 * Site controller
 */
class SiteController extends Controller {

    public $successUrl = '/site/login';
    public $registerbossUrl = '/tao-tai-khoan-boss';
    public $registermemberUrl = '/tao-tai-khoan-nhan-vien';

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
                'successUrl' => $this->successUrl
            ],
            'registerboss' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successRegiterboss'],
                'successUrl' => $this->registerbossUrl
            ],
            'registermember' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successRegitermember'],
                'successUrl' => $this->registermemberUrl
            ],
        ];
    }

    // success callback login face-google
    public function successCallback($client) {
        $session = Yii::$app->session;
        $attributes = $client->getUserAttributes();
        $email = User::find()->where(['email' => $attributes['email']])->one();

        if ($email) {
            // email, fbid existed, login success    
            $fbid = User::find()->where(['fbid' => $attributes['id'], 'email' => $attributes['email']])->one();
            if ($fbid) {
                $active = User::find()->where(['fbid' => $attributes['id'], 'email' => $attributes['email'], 'status' => 1])->one();
                if ($active) {
                    Yii::$app->user->login($active);
                } else {
                    // email existed, redirect to login  
                    $session->set('active', 'true');
                    $session->set('email', $attributes['email']);
                    $session->set('fbid', $attributes['id']);
                    $this->successUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/login']);
                }
            } else {
                // email existed, redirect to login  
                $session->set('login', '');
                $session->set('email', $attributes['email']);
                $session->set('fbid', $attributes['id']);
                $this->successUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/login']);
            }
        } else {
            // email not exist, redirect to register    
            $session->set('login', 'false');
            $session->set('email', $attributes['email']);
            $session->set('fbid', $attributes['id']);
            $session->set('name', $attributes['name']);
            $this->successUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/login']);
        }
    }

    // success callback register boss with face-google
    public function successRegiterboss($client) {
        $session = Yii::$app->session;
        $attributes = $client->getUserAttributes();
        $email = User::find()->where(['email' => $attributes['email']])->one();
        if ($email) {
            // email, fbid existed, login success    
            $fbid = User::find()->where(['fbid' => $attributes['id'], 'email' => $attributes['email']])->one();
            if ($fbid) {

                $active = User::find()->where(['fbid' => $attributes['id'], 'email' => $attributes['email'], 'status' => 1])->one();
                if ($active) {
                    Yii::$app->user->login($active);
                } else {

                    // email existed, redirect to login
                    $session->set('register', '');
                    $session->set('active', 'true');
                    $session->set('email', $attributes['email']);
                    $session->set('fbid', $attributes['id']);
                    $this->successUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/login']);
                }
            } else {
                // email existed, redirect to login  
                $session->set('login', '');
                $session->set('email', $attributes['email']);
                $session->set('fbid', $attributes['id']);
                $this->successUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/login']);
            }
        } else {
            // email not exist, redirect to register    
            $session->set('register', 'true');
            $session->set('email', $attributes['email']);
            $session->set('fbid', $attributes['id']);
            $session->set('name', $attributes['name']);
            $this->successUrl = Yii::$app->urlManager->createAbsoluteUrl(['boss/register']);
        }
    }

    // success callback register member with face-google
    public function successRegitermember($client) {
        // "fbid":"941351355930662",
        $session = Yii::$app->session;
        $attributes = $client->getUserAttributes();
        //var_dump($attributes); exit;
        $email = User::find()->where(['email' => $attributes['email']])->one();
        if ($email) {
            // email, fbid existed, login success    
            $fbid = User::find()->where(['fbid' => $attributes['id'], 'email' => $attributes['email']])->one();
            if ($fbid) {

                $active = User::find()->where(['fbid' => $attributes['id'], 'email' => $attributes['email'], 'status' => 1])->one();
                if ($active) {
                    Yii::$app->user->login($active);
                } else {

                    // email existed, redirect to login
                    $session->set('register', '');
                    $session->set('active', 'true');
                    $session->set('email', $attributes['email']);
                    $session->set('fbid', $attributes['id']);
                    $this->successUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/login']);
                }
            } else {
                // email existed, redirect to login  
                $session->set('register', '');
                $session->set('email', $attributes['email']);
                $session->set('fbid', $attributes['id']);
                $this->successUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/login']);
            }
        } else {
            // email not exist, redirect to register    
            $session->set('register', 'true');
            $session->set('email', $attributes['email']);
            $session->set('fbid', $attributes['id']);
            $session->set('name', $attributes['name']);
            $this->successUrl = Yii::$app->urlManager->createAbsoluteUrl(['membership/register']);
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $city = City::find()->all();
        $jobCategory = Category::find()->all();

        $members = User::find()->where(['role' => User::ROLE_MEMBER, 'step' => 5])->orderBy(['rating' => SORT_DESC])->limit(4)->all();
        $totalmember = User::find()->where(['role' => User::ROLE_MEMBER, 'status' => User::STATUS_ACTIVE])->count();
        $totaljob = Job::find()->count();
        $jobprice = Job::find()->where(['publish' => Job::PUBLISH_ACTIVE])->andWhere(['between', 'status', Job::PROJECT_PENDING, Job::PROJECT_OVER])->all();
        $totalprice = 0;
        foreach ($jobprice as $price) {
            foreach ($price->bid as $val) {
                $totalprice += $val->price;
            }
        }
        $partner = Posts::find()->where(['alias' => 'gal', 'parent' => '56f4c722f0d125b22605c3f0', 'publish' => Posts::STATUS_ACTIVE])->orderBy(['updated_at' => SORT_DESC])->all();
        $customer = Posts::find()->where(['alias' => 'rev', 'publish' => Posts::STATUS_ACTIVE])->orderBy(['updated_at' => SORT_DESC])->all();
        $album = BlogCategory::find()->where(['alias' => 'gal', 'parent' => '56f26a29f0d125cf7205c3f0', 'publish' => BlogCategory::STATUS_ACTIVE])->orderBy(['updated_at' => SORT_DESC])->limit(1)->all();
        if (!empty($album[0]['_id']))
            $sildehome = Posts::find()->where(['alias' => 'gal', 'category_id' => (string) $album[0]['_id'], 'publish' => Posts::STATUS_ACTIVE])->orderBy(['updated_at' => SORT_DESC])->all();
        else
            $sildehome = [];
        $bid = new Bid();
        $asign = Assignment::find()->all();
        $jobs = Job::find()->where(['publish' => Job::PUBLISH_ACTIVE, 'status' => Job::PROJECT_PUBLISH])->orderBy(['created_at' => SORT_DESC])->all();
        $arrasign = [];
        $arrjobs = [];
        foreach ($asign as $key => $value) {
            $arrasign[] = (string) $value->job_id;
        }
        foreach ($jobs as $key => $value) {
            $arrjobs[] = (string) $value->_id;
        }
        $result = array_diff($arrjobs, $arrasign);
        $jobnew = Job::find()->where(['publish' => Job::PUBLISH_ACTIVE, 'status' => Job::PROJECT_PUBLISH])->andWhere(['IN', '_id', $result])->orderBy(['featured' => SORT_ASC, 'created_at' => SORT_DESC])->limit(3)->all();        //$jobs = Job::find()->where(['publish' => Job::PUBLISH_ACTIVE])->limit(4)->orderBy(['created_at' => SORT_DESC])->all();
        return $this->render('index', ['jobCategory' => $jobCategory, 'jobs' => $jobnew, 'city' => $city, 'bid' => $bid, 'sildehome' => $sildehome, 'customer' => $customer, 'partner' => $partner, 'members' => $members, 'totalmember' => $totalmember, 'totaljob' => $totaljob, 'totalprice' => $totalprice]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = User::findOne(Yii::$app->user->id);
            $user->lastvisit = time();
            $user->save();
            if (!empty($_GET['redirect'])) {
                $this->redirect(Yii::$app->convert->url($_GET['redirect']));
            } else
                return $this->goBack();
        }
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->getSession()->destroy();
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(\Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    public function actionCategory() {
        $model = new Category();

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
        }
        return $this->render('category', [
                    'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionThankyou() {
        return $this->render('thankyou');
    }

}
