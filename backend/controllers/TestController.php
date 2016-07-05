<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use common\models\TestQuestion;
use common\models\Test;
use common\models\Category;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Collection;
use yii\mongodb\Query;
use backend\controllers\BackendController;

class TestController extends BackendController {

    public function actionIndex() {
        $this->canUser();
        $category = Category::find()->all();
        $query = TestQuestion::find();
        if (!empty($_GET['category'])) {
            $query->andWhere(['IN', 'category', $_GET['category']]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        Yii::$app->session->setFlash('test', !empty($_GET['page']) ? $_GET['page'] : NULL);
        return $this->render('index', ['dataProvider' => $dataProvider, 'category' => $category]);
    }

    public function actionCreate() {
        $this->canUser();
        $model = new TestQuestion();
        if ($model->load(Yii::$app->request->post())) {
            $question = TestQuestion::find()->max('order');
            $model->order = (int)$question + 1;
            $model->created_at = time();
            if ($model->save())
                $this->request('test');
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id) {
        $this->canUser();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save())
                $this->request('test');
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionTest() {
        $model = TestQuestion::find()->all();
        $questions = [];
        $test = new Test();

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
            var_dump($_POST['time']);
            exit;
            $test->questions = $questions;
            $test->point = $point;
            $test->created_at = time();
            $test->save();
        }


        return $this->render('test', ['model' => $model]);
//        $questions = [];
//        if (!empty($model)) {
//            foreach ($model as $value) {
//                $questions[] = ['id' => (string) $value->_id];
//            }
//        }
//        $test = new Test();
//        $test->user_id = '1234';
//        $test->questions = $questions;
//        $test->created_at = time();
//        $test->save();
    }

    public function actionQuiz($id) {
        $model = Test::findOne($id);
        $ids = [];
        if ($model->load(Yii::$app->request->post())) {
            foreach ($model->questions as $value) {
                if (!empty($_POST['Test_' . $value['id']])) {
                    $question = TestQuestion::findOne($value['id']);
                    if ($question->answers == $_POST['Test_' . (string) $question->_id]) {
                        $answer = 1;
                        $point = $model->point + 1;
                    } else {
                        $answer = 0;
                        $point = $model->point;
                    }
                }
                $ids[] = ['id' => (string) $value['id'], 'request' => $_POST['Test_' . $value['id']], 'answer' => $answer];
            }
            $model->questions = $ids;
            $model->point = $point;
            var_dump($model->save());
            exit;
            $model->save();
        }
        return $this->render('quiz', ['model' => $model]);
    }

    public function actionDelete($id) {
        $this->canUser();
        $ids = explode(',', $id);
        foreach ($ids as $value) {
            $this->findModel($value)->delete();
        }
        $this->request('test');
    }

    /**
     * Finds the Account model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Account the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TestQuestion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

}
