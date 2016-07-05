<?php

namespace backend\controllers;

use Yii;
use common\models\UserGroup;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rbac\Item;
use common\models\AuthItem;
use backend\controllers\BackendController;

/**
 * UsergroupController implements the CRUD actions for UserGroup model.
 */
class UsergroupController extends BackendController {

    /**
     * Lists all UserGroup models.
     * @return mixed
     */
    public function actionIndex() {
        if (!\Yii::$app->user->can('/usergroup/index'))
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        $dataProvider = new ActiveDataProvider([
            'query' => UserGroup::find()->orderBy(['level' => SORT_ASC]),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserGroup model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id) {
        if (!\Yii::$app->user->can('/usergroup/view'))
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        if (!\Yii::$app->user->can('/usergroup/view'))
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        $model = new UserGroup();

        if ($model->load(Yii::$app->request->post())) {
            $model->level = (int) $model->level;
            if ($model->save()) {
                $auth = new AuthItem(null);
                $auth->type = $model->rule;
                $auth->name = $model->key;
                $auth->description = $model->name;
                $auth->save();
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id) {
        if (!\Yii::$app->user->can('/usergroup/update'))
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->level = (int) $model->level;
            if ($model->save()) {
                $auth = new AuthItem(null);
                $auth->type = $model->rule;
                $auth->name = $model->key;
                $auth->description = $model->name;
                $auth->save();
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id) {
        if (!\Yii::$app->user->can('/usergroup/delete'))
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return UserGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = UserGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
