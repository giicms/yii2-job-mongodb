<?php

namespace backend\controllers;

use Yii;
use common\models\Page;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;

/**
 * PageController implements the CRUD actions for Posts model.
 */
class PageController extends BackendController {

    /**
     * Lists all Posts models.
     * @return mixed
     */
    public function actionIndex() {
        $this->canUser();
        $dataProvider = new ActiveDataProvider([
            'query' => Page::find(),
        ]);
        Yii::$app->session->setFlash('page', !empty($_GET['page']) ? $_GET['page'] : NULL);
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Posts model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id) {
        $this->canUser();
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->canUser();
        $model = new Page();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->slug = Yii::$app->convert->string($model->name);
            $model->user_id = (string) Yii::$app->user->identity->id;
            if (!empty($_POST['thumbnail']))
                $model->thumbnail = $_POST['thumbnail'];
            if ($model->save())
                return $this->redirect(['view', 'id' => (string) $model->_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id) {
        $this->canUser();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->slug = Yii::$app->convert->string($model->name);
            $model->user_id = (string) Yii::$app->user->identity->id;
            if (!empty($_POST['thumbnail']))
                $model->thumbnail = $_POST['thumbnail'];
            if ($model->save())
                $this->request('page');
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionStatus() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($_POST['id']);
        if (!empty($model)) {
            if ($model->publish == Page::STATUS_ACTIVE)
                $model->publish = Page::STATUS_NOACTIVE;
            else
                $model->publish = Page::STATUS_ACTIVE;
            if ($model->save()) {
                return ['messages' => $model->publish];
            }
        }
    }

    /**
     * Deletes an existing Posts model.
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
        Yii::$app->session->setFlash('page', !empty($_GET['page']) ? $_GET['page'] : NULL);
    }

    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

}
