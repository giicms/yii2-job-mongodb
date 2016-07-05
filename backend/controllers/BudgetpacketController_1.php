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
        if ($model->load(Yii::$app->request->post()))
        {
            $arr = [];
            foreach ($model->sectors as $value)
            {
                $sector = Sectors::findOne($value);
                $arr[$value] = ['name' => $sector->name];
            }
            $model->sectors = $arr;
            $model->publish = BudgetPacket::PUBLISH_ACTIVE;
            $num = $_POST['num'];
            for ($i = 0; $i <= $_POST['num']; $i++)
            {
                if ((!empty($_POST['min'][$i])) or ( !empty($_POST['max'][$i])) or ( !empty($_POST['order'][$i])))
                {
                    $get[$i] = ['min' => $_POST['min'][$i], 'max' => $_POST['max'][$i], 'order' => $_POST['order'][$i]];
                }
            }
            if ($model->validate())
            {
                $required = '';
                $order_error = [];
                for ($i = 0; $i <= $_POST['num']; $i++)
                {
                    if (($_POST['min'][$i] == "") or ( $_POST['max'][$i] == "") or ( $_POST['order'][$i] == ""))
                    {
                        $required .=$_POST['min'][$i] . ' ' . $_POST['max'][$i] . ' ';
                    }
                }
                foreach (array_count_values($_POST['order']) as $value)
                {
                    if ($value > 1)
                    {
                        $order_error = $value;
                    }
                }
                if (!empty($required) or ! empty($order_error))
                {
                    return $this->render('index', [
                                'dataProvider' => $dataProvider,
                                'model' => $model,
                                'num' => $num,
                                'get' => $get,
                                'order_error' => $order_error,
                                'error' => 'Các gói không được rỗng'
                    ]);
                }
                else
                {
                    $options = [];
                    for ($i = 0; $i <= $_POST['num']; $i++)
                    {
                        $options[] = ['min' => $_POST['min'][$i], 'max' => $_POST['max'][$i], 'order' => $_POST['order'][$i]];
//                            $packet = new BudgetPrice();
//                            $packet->bg_id = $model->id;
//                            $packet->sector_id = $model->sector_id;
//                            $packet->name = number_format($_POST['min'][$i], 0, '', '.') . ' - ' . number_format($_POST['max'][$i], 0, '', '.');
//                            $packet->min = (int) $_POST['min'][$i];
//                            $packet->max = (int) $_POST['max'][$i];
//                            $packet->order = (int) $_POST['order'][$i];
//                            $packet->publish = BudgetPrice::PUBLISH_ACTIVE;
//                            $packet->save();
                    }
                    $model->options = $options;
                    if ($model->save())
                    {
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                    'num' => $num,
                    'get' => $get
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
        $num = count($model->budgetPrice) - 1;
        $get = [];
        if ($model->load(Yii::$app->request->post()))
        {
            $model->publish = BudgetPacket::PUBLISH_ACTIVE;
            $num = $_POST['num'];
            for ($i = 0; $i <= $_POST['num']; $i++)
            {
                if ((!empty($_POST['min'][$i])) or ( !empty($_POST['max'][$i])) or ( !empty($_POST['order'][$i])))
                {
                    $get[$i] = ['min' => $_POST['min'][$i], 'max' => $_POST['max'][$i], 'order' => $_POST['order'][$i]];
                }
            }

            if ($model->validate())
            {
                $required = '';
                $order_error = [];
                for ($i = 0; $i <= $_POST['num']; $i++)
                {
                    if (($_POST['min'][$i] == "") or ( $_POST['max'][$i] == "") or ( $_POST['order'][$i] == ""))
                    {
                        $required .=$_POST['min'][$i] . ' ' . $_POST['max'][$i] . ' ';
                    }
                }
                foreach (array_count_values($_POST['order']) as $value)
                {
                    if ($value > 1)
                    {
                        $order_error = $value;
                    }
                }
                if (!empty($required) or ! empty($order_error))
                {
                    return $this->render('update', [
                                'model' => $model,
                                'num' => $num,
                                'get' => $get,
                                'order_error' => $order_error,
                                'error' => 'Các gói không được rỗng'
                    ]);
                }
                else
                {
                    if ($model->save())
                    {
                        $budgetprice = BudgetPrice::find()->where(['bg_id' => $model->id])->all();
                        foreach ($budgetprice as $key => $value)
                        {
                            if (empty($_POST['budgetprice_id'][$key]))
                            {
                                BudgetPrice::findOne($value->id)->delete();
                            }
                        }
                        for ($i = 0; $i <= $_POST['num']; $i++)
                        {
                            if (!empty($_POST['budgetprice_id'][$i]))
                            {
                                $packet = BudgetPrice::findOne($_POST['budgetprice_id'][$i]);
                                $packet->publish = (int) !empty($_POST['publish'][$i]) ? BudgetPrice::PUBLISH_ACTIVE : BudgetPrice::PUBLISH_NOACTIVE;
                            }
                            else
                            {
                                $packet = new BudgetPrice();
                                $packet->bg_id = $id;

                                $packet->publish = (int) BudgetPrice::PUBLISH_ACTIVE;
                            }
                            $packet->sector_id = $model->sector_id;
                            $packet->name = number_format($_POST['min'][$i], 0, '', '.') . ' - ' . number_format($_POST['max'][$i], 0, '', '.');
                            $packet->min = (int) $_POST['min'][$i];
                            $packet->max = (int) $_POST['max'][$i];
                            $packet->order = (int) $_POST['order'][$i];

                            $packet->save();
                        }
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        return $this->render('update', [
                    'model' => $model,
                    'num' => $num
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
