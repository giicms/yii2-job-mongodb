<?php

namespace backend\controllers;

use Yii;
use common\models\City;
use common\models\District;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;

/**
 * CityController implements the CRUD actions for City model.
 */
class CityController extends BackendController {

    /**
     * Lists all City models.
     * @return mixed
     */
    public function actionIndex() {
        $this->canUser();
        $dataProvider = new ActiveDataProvider([
            'query' => City::find(),
        ]);
        $model = new City();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            for ($i = 0; $i <= $_POST['num']; $i++) {
                if (!empty($_POST['district'][$i])) {
                    $district = new District();
                    $district->city_id = (string) $model->id;
                    $district->name = $_POST['district'][$i];
                    $district->save();
                }
            }
            return $this->redirect(['index']);
        }
        Yii::$app->session->setFlash('city', !empty($_GET['page']) ? $_GET['page'] : NULL);
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'model' => $model
        ]);
    }

    /**
     * Creates a new City model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->canUser();
        $model = new City();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing City model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id) {
        $this->canUser();
        $model = $this->findModel($id);
        $district = District::find()->where(['city_id' => $id])->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            for ($i = 0; $i <= $_POST['num']; $i++) {
                if (!empty($_POST['district'][$i])) {
                    if (!empty($_POST['district_id'][$i]))
                        $new = District::findOne($_POST['district_id'][$i]);
                    else
                        $new = new District();
                    $new->city_id = (string) $model->id;
                    $new->name = $_POST['district'][$i];
                    $new->save();
                }
            }
            $this->request('city');
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'district' => $district
            ]);
        }
    }

    /**
     * Deletes an existing City model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->canUser();
        $ids = explode(',', $id);
        foreach ($ids as $value) {
            $this->findModel($value)->delete();
        }
        $this->request('city');
    }

    /**
     * Finds the City model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return City the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = City::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
