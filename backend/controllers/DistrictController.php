<?php

namespace backend\controllers;

use Yii;
use common\models\District;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;
/**
 * DistrictController implements the CRUD actions for District model.
 */
class DistrictController extends BackendController {

    /**
     * Lists all District models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => District::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single District model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id) {
        $dataProvider = new ActiveDataProvider([
            'query' => District::find()->where(['city_id' => $id]),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'id' => $id
        ]);
    }

    /**
     * Creates a new District model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id) {
        $model = new District();

        if ($model->load(Yii::$app->request->post())) {
            $model->city_id = $id;
            if ($model->save())
                Yii::$app->session->setFlash('success', 'Bạn đã thêm mẫu tin thành công.');
        }
        return $this->render('create', [
                    'model' => $model,
                    'id' => $id
        ]);
    }

    /**
     * Updates an existing District model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->city_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing District model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['view', 'id' => $model->city_id]);
    }

    /**
     * Finds the District model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return District the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = District::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
