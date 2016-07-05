<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Collection;
use common\models\BudgetPacket;
use common\models\BudgetPrice;
use common\models\District;
use common\models\Sectors;
use common\models\UserBid;

class AjaxController extends Controller
{

    public function actionPermission($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $auth = Yii::$app->authManager;
        $data = [];
        $permission = $auth->getPermission($id);
        if (!empty($permission))
        {
            foreach ($auth->getChildren($id) as $name => $child)
            {

                if ($child->parent == 'null' or ( empty($child->parent)))
                {
                    $array = explode('/', $name);
                }
                else
                {

                    $array = explode('/', $child->parent);
                }
                if (!empty($_GET['user']) && $auth->getAssignment($name, $_GET['user']))
                    $selected = 1;
                else
                    $selected = 2;

                $data[] = ['name' => $name, 'description' => !empty($child->description) ? $child->description : $name, 'checked' => $selected, 'parent' => $child->parent, 'class' => $array[1]];
            }
        }
        return $data;
    }

    public function actionUserbookstatus()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = UserBid::findOne($_POST['id']);
        $model->status = $_POST['status'];
        $model->save();
    }

    public function actionBudgetprice()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = BudgetPacket::find()->where(['sector_id' => $_POST['id']])->one();
        $data = [];
        if (!empty($model))
        {
            $price = BudgetPrice::find()->where(['bg_id' => $model->id, 'publish' => BudgetPrice::PUBLISH_ACTIVE])->all();
            if (!empty($price))
            {
                foreach ($price as $key => $value)
                {
                    $data[] = ['id' => $value->id, 'name' => 'Từ ' . number_format($value->min, 0, '', '.') . ' đến ' . number_format($value->max, 0, '', '.')];
                }
            }
        }
        return $data;
    }

    public function actionSelectdistrict()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = District::find()->where(['city_id' => $_POST['id_city']])->all();
        $data = [];
        if (!empty($model))
        {
            foreach ($model as $value)
            {
                $data[] = ['id' => (string) $value->_id, 'name' => $value->name];
            }
        }
        return $data;
    }

    public function actionSector()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Sectors::find()->where(['category_id' => $_POST['id']])->all();
        $data = [];
        if (!empty($model))
        {
            foreach ($model as $value)
            {
                $data[] = ['id' => (string) $value->_id, 'name' => $value->name];
            }
        }
        return $data;
    }

    public function actionQrcode()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $ga = new \backend\components\GoogleAuthenticator();
        $secret = $ga->createSecret();
        $src = $ga->getQRCodeGoogleUrl($_POST['username'], $secret);
        return ['secret' => $secret, 'src' => $src];
    }

}
