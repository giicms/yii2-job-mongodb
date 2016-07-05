<?php

namespace backend\controllers;

use Yii;
use common\models\City;
use common\models\Bank;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;

/**
 * CityController implements the CRUD actions for City model.
 */
class BankController extends BackendController {

    /**
     * Lists all City models.
     * @return mixed
     */
    public function actionIndex() {
        //$this->canUser();
        $dataProvider = new ActiveDataProvider([
            'query' => Bank::find(),
        ]);
        $model = new Bank();
        if ($model->load(Yii::$app->request->post())) {
            $model->name = $model->name;
            $model->code = $model->code;
            $model->slug = \Yii::$app->convert->string($model->name);
            $model->publish = Bank::PUBLISH_ACTIVE;
            $model->created_at = time();
            $model->updated_at = time();
            if($model->save()){
                return $this->redirect(['index']);
            }
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
        $model = new Bank();

        if ($model->load(Yii::$app->request->post())) {
            $model->name = $model->name;
            $model->code = $model->code;
            $model->slug = \Yii::$app->convert->string($model->name);
            $model->created_at = time();
            $model->updated_at = time();
            if($model->save()){
                return $this->redirect(['index']);
            }
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
        //$this->canUser();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->name = $model->name;
            $model->code = $model->code;
            $model->city = $model->city;
            $model->slug = \Yii::$app->convert->string($model->name);
            $model->publish = time();
            $model->updated_at = time();
            if($model->save()){
                return $this->redirect(['index']);
            }
        }   
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing City model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id) {
        //$this->canUser();
        $ids = explode(',', $id);
        foreach ($ids as $value) {
            $this->findModel($value)->delete();
        }
        $this->request('bank/index');
    }

    /**
     * Finds the City model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return City the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Bank::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public static function actionPublish(){
        $model = Bank::findOne($_POST['id']);
        if($_POST['state'] == 'true'){
            $model->publish = Bank::PUBLISH_ACTIVE;
        }else{
            $model->publish = Bank::PUBLISH_NONE;
        };
        if($model->save()){
            return 'ok';
        }
    }

    
}
