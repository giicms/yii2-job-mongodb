<?php

namespace backend\controllers;

use Yii;
use common\models\Review;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use backend\controllers\BackendController;

/**
 * ReviewController implements the CRUD actions for Review model.
 */
class ReviewController extends BackendController {

    /**
     * Lists all Review models.
     * @return mixed
     */
    public function actionIndex() {
        $this->canUser();
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['between', 'rating', 1, 5])->orderBy(['rating' => SORT_DESC])
        ]);

        $review = Review::find()->all();
        return $this->render('index', [
                    'dataProvider' => $dataProvider, 'review' => $review,
        ]);
    }

    /**
     * Displays a single Review model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id) {
        $this->canUser();
        $user = User::findOne((string) $id);
        $comment = User::getComment((string) $id);
        return $this->render('view', [
                    'user' => $user, 'comment' => $comment,
        ]);
    }

    /**
     * Creates a new Review model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->canUser();
        $model = new Review();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string) $model->_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Review model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id) {
        $this->canUser();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string) $model->_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Review model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->canUser();
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Review model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Review the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Review::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

}
