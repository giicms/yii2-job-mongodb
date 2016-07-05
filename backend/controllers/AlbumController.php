<?php

namespace backend\controllers;

use Yii;
use common\models\Posts;
use common\models\BlogCategory;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;

/**
 * PostController implements the CRUD actions for Posts model.
 */
class AlbumController extends BackendController {

    /**
     * Lists all Posts models.
     * @return mixed
     */
    public function actionIndex($id) {
        $this->canUser();
        $dataProvider = new ActiveDataProvider([
            'query' => Posts::find()->where(['alias'=>'gal', 'category_id'=>$id])->orderBy(['updated_at' => SORT_DESC])
        ]);
        Yii::$app->session->setFlash('post', !empty($_GET['page']) ? $_GET['page'] : NULL);
        $model = Posts::find()->where(['alias' => 'gal'])->orderBy(['updated_at' => SORT_DESC])->all();
        $new = new Posts();
        if ($new->load(Yii::$app->request->post())) {
            $new->slug = Yii::$app->convert->string($new->name);
            $new->user_id = (string) Yii::$app->user->identity->id;
            if (!empty($_POST['thumbnail']))
                $new->thumbnail = $_POST['thumbnail'];
            $new->alias = 'gal';
            $new->publish = Posts::STATUS_ACTIVE;
            $new->created_at = $new->updated_at = time();
            if ($new->save()) {
                $this->render('index', [ 'dataProvider' => $dataProvider, 'model'=>$model, 'new'=>$new, 'id'=>$id ]);
            }
        }
        return $this->render('index', [
                    'dataProvider' => $dataProvider, 'model'=>$model, 'new'=>$new, 'id'=>$id
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
        $model = new Posts();
        $category = BlogCategory::find()->where(['parent' => '0'])->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->slug = Yii::$app->convert->string($model->name);
            $model->user_id = (string) Yii::$app->user->identity->id;
            if (!empty($_POST['thumbnail']))
                $model->thumbnail = $_POST['thumbnail'];
            $model->view = 0;
            $model->publish = Posts::STATUS_ACTIVE;
            $model->created_at = $model->updated_at = time();
            if ($model->save())
                $this->request('post');
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'category' => $category
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
        $category = BlogCategory::find()->where(['parent' => '0'])->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->slug = Yii::$app->convert->string($model->name);
            $model->user_id = (string) Yii::$app->user->identity->id;
            if (!empty($_POST['thumbnail']))
                $model->thumbnail = $_POST['thumbnail'];
            if ($model->save()){
                $this->redirect('/album/index/'.$model->category_id);
            }  
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'category' => $category
            ]);
        }
    }

    public function actionStatus() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($_POST['id']);
        if (!empty($model)) {
            if ($model->publish == Posts::STATUS_ACTIVE)
                $model->publish = Posts::STATUS_NOACTIVE;
            else
                $model->publish = Posts::STATUS_ACTIVE;
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
        $new = new Posts();
        $model = $this->findModel($id);
        foreach ($ids as $value) {
            $this->findModel($value)->delete();
        }
        return $this->redirect('/album/index/'.$model->category_id);
    }

    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

}
