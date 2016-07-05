<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use common\models\BlogCategory;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Collection;
use yii\mongodb\Query;
use backend\controllers\BackendController;

/**
 * Category controller
 */
class GalleryController extends BackendController {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex() {
        $this->canUser();
        $items = $this->gallery();
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $items,
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        $model = BlogCategory::find()->where(['alias' => 'gallery'])->orderBy(['order' => SORT_ASC])->all();
        $new = new BlogCategory();
        if ($new->load(Yii::$app->request->post())) {
            $category = BlogCategory::findOne($new->parent);
            if (!empty($category))
                $new->level = $category->level + 1;
            else
                $new->level = 0;
            $new->publish = BlogCategory::STATUS_ACTIVE;
            $new->slug = Yii::$app->convert->string($new->name);
            $new->alias = 'gal';
            $new->order = (int) $new->order;
            $new->created_at = time();
            $new->updated_at = time();
            if ($new->save()) {
                $this->redirect(['index']);
            }
        }
        return $this->render('index', ['model' => $model, 'dataProvider' => $dataProvider, 'new' => $new]);
    }

    public function actionUpdate($id) {
        $this->canUser();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $category = BlogCategory::findOne($model->parent);
            if (!empty($category))
                $model->level = $category->level + 1;
            else
                $model->level = 0;
            $model->slug = Yii::$app->convert->string($model->name);
            $model->order = (int) $model->order;
            $model->updated_at = time();
            if ($model->save()) {
                $this->redirect(['index']);
            }
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionStatus() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($_POST['id']);
        if (!empty($model)) {
            if ($model->publish == BlogCategory::STATUS_ACTIVE)
                $model->publish = BlogCategory::STATUS_NOACTIVE;
            else
                $model->publish = BlogCategory::STATUS_ACTIVE;
            if ($model->save()) {
                return ['messages' => $model->publish];
            }
        }
    }

    public function actionDelete($id) {
        $this->canUser();
        $ids = explode(',', $id);
        foreach ($ids as $value) {
            $this->findModel($value)->delete();
        }
        return $this->redirect(['index']);
    }


    protected function gallery(&$data = [], $parent = "") {
        $gallery = BlogCategory::find()->where(['parent' => (string) $parent, 'alias'=>'gal'])->all();
        foreach ($gallery as $key => $value) {
            $data[] = $value;
            unset($gallery[$key]);
            $this->gallery($data, $value->id);
        }
        return $data;
    }

    protected function findModel($id) {
        if (($model = BlogCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

}
