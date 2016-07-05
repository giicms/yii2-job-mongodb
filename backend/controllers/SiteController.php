<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\LoginForm;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use common\models\User;
use common\models\Account;
use common\models\Assignment;
use common\models\Onlinedaily;
use backend\models\ForgetPassword;
use backend\models\ChangePassword;
use common\models\Job;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'forgetpassword', 'changepassword'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
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
        ];
    }

    public function actionIndex() {
        $user = User::find()->where(['step' => 4])->limit(10)->all();
        $assign = Assignment::find()->where(['status_boss' => Assignment::STATUS_DEPOSIT])->limit(10)->all();
        $jobs = Job::find()->where(['publish' => Job::PROJECT_PUBLISH])->all();
        $member = User::find()->where(['role' => User::ROLE_MEMBER])->andWhere(['NOT IN', 'step', [User::STEP_COMPLE, User::STEP_SUCCESS]])->all();
        $boss = User::find()->where(['role' => User::ROLE_BOSS])->andWhere(['NOT IN', 'step', [User::STEP_COMPLE, User::STEP_SUCCESS]])->all();
        $deposit = Assignment::find()->where(['status_boss' => Assignment::STATUS_GIVE])->all();
        $payment = Assignment::find()->where(['status_boss' => Assignment::STATUS_COMMITMENT])->all();
        // show chart
        if (!empty($_GET['datefrom']) && !empty($_GET['dateto'])) {
            $datefrom = strtotime($_GET['datefrom']);
            $dateto = strtotime($_GET['dateto']) + 86399;
            $onlinedaily = Onlinedaily::find()->where(['between', 'created_at', $datefrom, $dateto])->orderBy(['created_at' => SORT_DESC])->limit(30)->all();
        } else {
            $dateto = time();
            $datefrom = time() - (86400 * 15);
            $onlinedaily = Onlinedaily::find()->where(['between', 'created_at', $datefrom, $dateto])->orderBy(['created_at' => SORT_DESC])->limit(30)->all();
        }
        return $this->render('index', ['user' => $user, 'onlinedaily' => $onlinedaily, 'jobs' => $jobs, 'member' => $member, 'boss' => $boss, 'deposit' => $deposit, 'payment' => $payment]);
    }

    public function actionLogin() {
        $this->layout = 'login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionForgetpassword() {
        $this->layout = 'login';
        $model = new ForgetPassword();
        if ($model->load(Yii::$app->request->post())) {
            $account = Account::find()->where(['email' => $model->email])->one();
        }
        return $this->render('forgetpassword', ['model' => $model]);
    }

    public function actionChangepassword() {
        $this->layout = 'login';
        $model = new ChangePassword();
        $account = Account::find()->where(['email' => $_GET['email'], 'auth_key' => $_GET['key']])->one();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $account->setPassword($model->password);
                $account->generateAuthKey();
                if ($account->save())
                    Yii::$app->session->setFlash('success', 'Bạn đã thay đổi mật khẩu thành công.');
            }
        }
        return $this->render('changepassword', ['model' => $model]);
    }

}
