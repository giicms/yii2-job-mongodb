<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\BudgetPacket;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Collection;
use backend\controllers\BackendController;
use common\models\Bankbranch;
use common\models\Bank;
class BankbranchController extends BackendController {

    /**
     * Lists all Skills models.
     * @return mixed
     */
    public function actionIndex() {
        $num = 0;
        $get = [];
        $dataProvider = new ActiveDataProvider([
            'query' => Bankbranch::find(),
        ]);
        $model = new Bankbranch();
        if ($model->load(Yii::$app->request->post())) {
            $model->bank_local = $model->bank_local;
            $model->bank = $model->bank;
            $model->name = $model->name;
            $model->publish = Bankbranch::PUBLISH_ACTIVE;
            $model->created_at = time();
            $model->updated_at = time();
            if($model->save()){
                return $this->redirect(['index']);
            }
        }
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                    'num' => $num,
                    'get' => $get
        ]);
    }

    public function actionSelect(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = $_POST['id'];
        $banks =[];
        $data = [];
        $models = Bank::find()->all();
        foreach ($models as $bank) {
            if (in_array($id, $bank->city)) {
                $banks[] = $bank->_id;
            }
        }
        $model = Bank::find()->where(['in', '_id', $banks])->all();
        if ($model) {
            foreach ($model as $value) {
                $data[] = ['id'=>(string)$value->_id, 'name'=>$value->name, 'code'=>$value->code];
            }
        }
        return $data;
    }


    /**
     * Updates an existing Skills model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id) {
        //$this->canUser();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->bank_local = $model->bank_local;
            $model->bank = $model->bank;
            $model->name = $model->name;
            $model->updated_at = time();
            if($model->save()){
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
                    'model' => $model
        ]);
    }


    /**
     * Deletes an existing Skills model.
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
        return $this->redirect(['index']);
    }


    public static function actionPublish(){
        $model = Bankbranch::findOne($_POST['id']);
        if($_POST['state'] == 'true'){
            $model->publish = Bankbranch::PUBLISH_ACTIVE;
        }else{
            $model->publish = Bankbranch::PUBLISH_NONE;
        };
        if($model->save()){
            return 'ok';
        }
    }

    /**
     * Finds the Skills model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Skills the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Bankbranch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

}
