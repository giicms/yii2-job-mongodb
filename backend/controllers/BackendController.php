<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Collection;

class BackendController extends Controller
{

    public function init()
    {
        if (\Yii::$app->user->isGuest)
            $this->redirect('/site/login');
    }

//    public function behaviors() {
//        $behaviors['access'] = [
//            'class' => AccessControl::className(),
//            'rules' => [
//                [
//                    'allow' => true,
//                    'roles' => ['@'],
//                    'matchCallback' => function ($rule, $action) {
//                $action = Yii::$app->controller->action->id;
//                $controller = Yii::$app->controller->id;
//                $route = "/$controller/$action";
//                $route1 = "/$controller/*";
//                $post = Yii::$app->request->post();
//                if (\Yii::$app->user->can($route)) {
//                    return true;
//                } else {
//                    throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
//                }
//            }
//                ],
//            ],
//        ];
//        $behaviors['verbs'] = [
//            'class' => VerbFilter::className(),
//            'actions' => [
//                'delete' => ['post'],
//            ],
//        ];
//        return $behaviors;
//    }
//    public function actions() {
//        return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
//        ];
//    }
    protected function request($key)
    {
        if (Yii::$app->session->hasFlash($key))
            return $this->redirect(['index', 'page' => Yii::$app->session->getFlash($key)]);
        else
            return $this->redirect(['index']);
    }

    protected function canUser()
    {
        $action = Yii::$app->controller->action->id;
        $controller = Yii::$app->controller->id;
        $route = "/$controller/$action";
        if (!\Yii::$app->user->can($route))
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
    }

}
