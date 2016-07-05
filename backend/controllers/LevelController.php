<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;
use common\models\Level;

/**
 * LevelController implements the CRUD actions for City model.
 */
class LevelController extends BackendController
{

    /**
     * Lists all City models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->canUser();
        $dataProvider = new ActiveDataProvider([
            'query' => Level::find(),
        ]);
        $model = new Level();
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
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
    public function actionCreate()
    {
        $this->canUser();
        $model = new City();
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
     * Updates an existing City model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->canUser();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
                $this->request('level');
        }
        else
        {
            return $this->render('update', [
                        'model' => $model
            ]);
        }
    }

    /**
     * Deletes an existing City model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->canUser();
        $this->findModel($id)->delete();
        $this->request('level');
    }

    /**
     * Finds the City model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return City the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Level::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
