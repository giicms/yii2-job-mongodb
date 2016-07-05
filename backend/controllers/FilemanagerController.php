<?php

namespace backend\controllers;

use Yii;
use common\models\AuthItem;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;
/**
 * RbacController implements the CRUD actions for AuthItem model.
 */
class FilemanagerController extends BackendController {

    public function actionIndex() {
        $this->canUser();
        return $this->render('view');
    }

}
