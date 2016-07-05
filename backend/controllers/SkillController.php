<?php

namespace backend\controllers;

use Yii;
use common\models\Skills;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;

/**
 * SkillController implements the CRUD actions for Skills model.
 */
class SkillController extends BackendController {

    /**
     * Lists all Skills models.
     * @return mixed
     */
    public function actionIndex() {
        if (!\Yii::$app->user->can('/skill/index'))
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        if (!empty($_GET['page']))
            $page = $_GET['page'];
        else
            $page = 1;
        Yii::$app->session->set('skill_page', $page);
        $dataProvider = new ActiveDataProvider([
            'query' => Skills::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Skills model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id) {
        if (!\Yii::$app->user->can('/skill/view'))
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Skills model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        if (!\Yii::$app->user->can('/skill/create'))
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        $model = new Skills();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string) $model->_id]);
        } else {
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
    public function actionUpdate($id) {
        if (!\Yii::$app->user->can('/skill/update'))
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');

        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'page' => Yii::$app->session->get('skill_page')]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Skills model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id) {
        if (!\Yii::$app->user->can('/skill/delete'))
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        $ids = explode(',', $id);
        foreach ($ids as $value) {
            $this->findModel($value)->delete();
        }
        return $this->redirect(['index', 'page' => Yii::$app->session->get('skill_page')]);
    }

    /**
     * Finds the Skills model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Skills the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Skills::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
