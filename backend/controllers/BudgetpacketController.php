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
use common\models\BudgetPrice;
use common\models\Sectors;

class BudgetpacketController extends BackendController
{

    /**
     * Lists all Skills models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->canUser();
        $num = 0;
        $get = [];
        $dataProvider = new ActiveDataProvider([
            'query' => BudgetPacket::find(),
        ]);
        $model = new BudgetPacket();
        $model->options = [];
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                $options = [];
                foreach ($model->options as $val)
                {
                    $item = explode('-', $val);
                    $options[] = ['min' => (int) $item[0], 'max' => (int) $item[1]];
                }
                $model->options = $options;
                $model->publish = BudgetPacket::PUBLISH_ACTIVE;
                $model->save();
            }
        }
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new Skills model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->canUser();
        $model = new BudgetPacket();

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['index']);
        }
        else
        {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Skills model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->canUser();
        $model = $this->findModel($id);
        $data = [];
        foreach ($model->options as $option)
        {
            $data[$option['min'] . '-' . $option['max']] = $option['min'] . '-' . $option['max'];
        }
        $model->options = $data;
        $sectors = [];
        foreach ($model->sectors as $sector)
        {
            $sectors[] = $sector;
        }
        $model->sectors = $sectors;
        if ($model->load(Yii::$app->request->post()))
        {
            $options = [];
            foreach ($model->options as $val)
            {
                $item = explode('-', $val);
                $options[] = ['min' => (int) $item[0], 'max' => (int) $item[1]];
            }
            $model->options = $options;
            if ($model->validate())
            {
                if ($model->save())
                {
                    return $this->redirect(['index']);
                }
            }
        }
        return $this->render('update', [
                    'model' => $model
        ]);
    }

    public function actionStatus()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($_POST['id']);
        if (!empty($model))
        {
            if ($model->publish == BudgetPacket::PUBLISH_ACTIVE)
                $model->publish = BudgetPacket::PUBLISH_NOACTIVE;
            else
                $model->publish = BudgetPacket::PUBLISH_ACTIVE;
            if ($model->save())
            {
                return ['messages' => $model->publish];
            }
        }
    }

    /**
     * Deletes an existing Skills model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->canUser();
        $ids = explode(',', $id);
        foreach ($ids as $value)
        {
            $this->findModel($value)->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Skills model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Skills the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BudgetPacket::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

}
