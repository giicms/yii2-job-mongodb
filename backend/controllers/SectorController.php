<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\Category;
use common\models\Sectors;
use common\models\Skills;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Collection;
use yii\mongodb\Query;
use backend\controllers\BackendController;


class SectorController extends BackendController {


    public function actionIndex() {
        if (!empty($_GET['id']))
            $id = $_GET['id'];
        else
            $id = NULL;
        $query = Category::find();
        $model = Category::find()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider, 'id' => $id, 'query' => $model
        ]);
    }

    public function actionCreate($id) {
        $model = new Sectors();
        if ($model->load(Yii::$app->request->post())) {
            $model->category_id = $id;
            $model->publish = Sectors::STATUS_ACTIVE;
            $model->slug = Yii::$app->convert->string($model->name);
            $skills = [];
            if (!empty($_POST['skills'])) {
                foreach ($_POST['skills'] as $value) {
                    $skills[] = $value;
                }
            }
            $model->skills = $skills;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Bạn đã thêm lĩnh vực thành công.');
                $model->refresh();
            }
        }
        $category = Category::findOne($id);
        $skills = Skills::find()->all();
        return $this->render('create', ['model' => $model, 'category' => $category, 'skills' => $skills]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $skills = Skills::find()->all();
        if ($model->load(Yii::$app->request->post())) {
            $skills = [];
            if (!empty($_POST['skills'])) {
                foreach ($_POST['skills'] as $value) {
                    $skills[] = $value;
                }
            }
            $model->skills = $skills;
            $model->slug = Yii::$app->convert->string($model->name);
            if ($model->save()) {
                $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', ['model' => $model, 'skills' => $skills]);
    }

    public function actionView($id) {
        $model = $this->findModel($id);
        return $this->render('view', ['model' => $model]);
    }

    public function actionDelete($id) {
        $model = $this->findModel($id);
        if (!empty($model)) {
            if ($model->delete()) {
                $this->redirect(['jobcategory/index']);
            }
        }
    }

    public function actionStatus() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($_POST['id']);
        if (!empty($model)) {
            if ($model->publish == Sectors::STATUS_ACTIVE)
                $model->publish = Sectors::STATUS_NOACTIVE;
            elseif ($model->publish == Sectors::STATUS_NOACTIVE)
                $model->publish = Sectors::STATUS_ACTIVE;
            else
                $model->publish = Sectors::STATUS_ACTIVE;
            if ($model->save()) {
                return ['messages' => $model->publish];
            }
        }
    }

    protected function findModel($id) {
        if (($model = Sectors::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
