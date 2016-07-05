<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use common\models\Category;
use common\models\Sectors;
use common\models\Skills;
use common\models\SectorOptions;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Collection;
use yii\mongodb\Query;
use yii\web\NotFoundHttpException;
use backend\controllers\BackendController;

/**
 * Category controller
 */
class JobcategoryController extends BackendController
{

    public function actionIndex()
    {
        $this->canUser();
        if (!empty($_GET['id']))
            $id = $_GET['id'];
        else
            $id = NULL;
        $query = Category::find();
        if (!empty(\Yii::$app->user->identity->category))
            $model = Category::find()->where(['IN', '_id', \Yii::$app->user->identity->category])->all();
        else
            $model = Category::find()->all();
        $items = [];
        foreach ($model as $value)
        {
            $items[] = ['id' => $value->id, 'name' => $value->name, 'sector' => '-', 'test_number' => '-', 'test_time' => '-', 'create_sector' => 1, 'publish' => $value->publish];
            foreach ($value->sectors as $sector)
            {
                $items[] = ['id' => $sector->id, 'name' => '', 'sector' => $sector->name, 'test_number' => $sector->test_number, 'test_time' => $sector->test_time, 'create_sector' => 2, 'publish' => $sector->publish];
            }
        }

        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $items,
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        Yii::$app->session->setFlash('jobcategory', !empty($_GET['page']) ? $_GET['page'] : NULL);
        return $this->render('index', ['dataProvider' => $dataProvider, 'id' => $id, 'query' => $model
        ]);
    }

    public function actionCreate()
    {
        $this->canUser();
        if (!empty($_GET['id']))
        {
            $model = new Sectors();
            if ($model->load(Yii::$app->request->post()))
            {
                $model->category_id = $_GET['id'];
                $model->publish = Sectors::STATUS_ACTIVE;
                $model->slug = Yii::$app->convert->string($model->name);
                $skills = [];
                if (!empty($_POST['skills']))
                {
                    foreach ($_POST['skills'] as $value)
                    {
                        $skills[] = $value;
                    }
                }
                $model->skills = $skills;
                if ($model->save())
                {
                    Yii::$app->session->setFlash('success', 'Bạn đã thêm lĩnh vực thành công.');
                    $model->refresh();
                }
            }
            $category = Category::findOne($_GET['id']);
            $skills = Skills::find()->all();
            return $this->render('create_sector', ['model' => $model, 'category' => $category, 'skills' => $skills]);
        }
        else
        {
            $model = new Category();
            if ($model->load(Yii::$app->request->post()))
            {
                $model->publish = Category::STATUS_ACTIVE;
                $model->slug = Yii::$app->convert->string($model->name);
                if ($model->save())
                {
                    Yii::$app->session->setFlash('success', 'Bạn đã thêm danh mục thành công.');
                    $this->refresh();
                }
            }
            return $this->render('create', ['model' => $model]);
        }
    }

    public function actionUpdate($id)
    {
        $this->canUser();
        $model = $this->findModel($id);
        if (!empty($model->category_id))
        {
            $skills = Skills::find()->all();
            if ($model->load(Yii::$app->request->post()))
            {
                $skills = [];
                if (!empty($_POST['skills']))
                {
                    foreach ($_POST['skills'] as $value)
                    {
                        $skills[] = $value;
                    }
                }
                $model->skills = $skills;
                $model->slug = Yii::$app->convert->string($model->name);
                if ($model->save())
                {
                    $this->request('jobcategory');
                }
            }
            $query = SectorOptions::find()->where(['sector_id' => $id]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('update_sector', ['model' => $model, 'skills' => $skills, 'dataProvider' => $dataProvider]);
        }
        else
        {
            if ($model->load(Yii::$app->request->post()))
            {
                $model->publish = Category::STATUS_ACTIVE;
                $model->slug = Yii::$app->convert->string($model->name);
                if ($model->save())
                {
                    $this->request('jobcategory');
                }
            }
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionStatus()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['ids']))
        {
            if ($_POST['act'] == "close")
                $status = Category::STATUS_ACTIVE;
            else
                $status = Category::STATUS_NOACTIVE;
            foreach ($_POST['ids'] as $value)
            {
                $model = $this->findModel($value);
                $model->publish = $status;
                $model->save();
            }
            return ['ok'];
        }
        else
        {
            $model = $this->findModel($_POST['id']);
            if (!empty($model))
            {
                if ($model->publish == Category::STATUS_ACTIVE)
                    $model->publish = Category::STATUS_NOACTIVE;
                else
                    $model->publish = Category::STATUS_ACTIVE;
                $model->save();
                return ['ok'];
            }
        }
    }

    public function actionDelete($id)
    {
        $this->canUser();
        $ids = explode(',', $id);
        foreach ($ids as $value)
        {
            $this->findModel($value)->delete();
        }
        $this->request('jobcategory');
    }

    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null or ( $model = Sectors::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

}
