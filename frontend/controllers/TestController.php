<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Test;
use common\models\TestQuestion;
use common\models\Category;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\mongodb\ActiveRecord;
use yii\mongodb\ActiveQueryInterface;
use yii\mongodb\Query;

class TestController extends FrontendController {

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

    public function actionIndex() {
        if (Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
        $model = new Test();
        $test = Test::find()->where(['user_id' => (string) Yii::$app->user->identity->id])->orderBy(['created_at' => SORT_ASC])->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = (string) Yii::$app->user->identity->id;
            $model->created_at = time();
            if ($model->save()) {
                $this->redirect(['test/info', 'id' => (string) $model->_id]);
            }
        }
        return $this->render('index', ['model' => $model, 'test' => $test]);
    }

    public function actionInfo($id) {
        if (Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
        $model = Test::findOne($id);
        return $this->render('infotest', ['model' => $model]);
    }

    public function actionStart($id) {
        if (Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
        $model = Test::findOne($id);

        $questions = [];
        if (!empty($_POST['question_id'])) {
            $point = 0;
            $answer = 0;
            foreach ($_POST['question_id'] as $k => $value) {
                if (!empty($_POST['question_' . $k])) {
                    $request = $_POST['question_' . $k];
                    $question = TestQuestion::findOne($value);
                    if ($request == $question->answers) {
                        $answer = 1;
                        $point = $point + 1;
                    } else {
                        $answer = 0;
                    }
                } else {
                    $request = NULL;
                }

                $questions[] = ['question_id' => $value, 'request' => $request, 'answer' => $answer];
            }

            $model->questions = $questions;
            $model->point = $point;
            $model->count_time = $_POST['time'];
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '   Bạn trả lời đúng được ' . $model->point . ' câu!.');
            }
        }

        $question = TestQuestion::find()->where(['IN', 'sector_id', $model->sector_id])->andWhere(['between', 'order', 0, rand($model->sector->test_number, 10000)])->orderBy(['order' => SORT_DESC])->limit($model->sector->test_number)->all();
        return $this->render('start', ['model' => $model, 'questions' => $question]);
    }

}
