<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\SectorOptions;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Collection;
use yii\mongodb\Query;
use backend\controllers\BackendController;
use common\models\Category;
use common\models\Sectors;

class SectoroptionController extends BackendController
{

    public function actionIndex()
    {
        $this->canUser();

        $query = SectorOptions::find()->where(['publish' => SectorOptions::PUBLISH_YES])->orderBy(['sector_id' => SORT_DESC]);
        if (!empty($_GET['sector']))
            $query = $query->andWhere(['sector_id' => $_GET['sector']]);
        if (!empty($_GET['key']))
            $query = $query->andWhere(['like', 'name', $_GET['key']]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $category = Category::find()->all();
        return $this->render('index', ['dataProvider' => $dataProvider, 'category' => $category
        ]);
    }

    public function actionTrash()
    {
        $this->canUser();
        $query = SectorOptions::find()->where(['publish' => SectorOptions::PUBLISH_NO])->orderBy(['sector_id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('trash', ['dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate($id)
    {
        $this->canUser();
        $model = new SectorOptions();
        $model->options = [];
        if ($model->load(Yii::$app->request->post()))
        {
            $sector = Sectors::findOne($id);
            $model->category_id = $sector->category_id;
            $model->sector_id = $sector->id;
            $options = [];
            foreach ($model->options as $key => $value)
            {
                $options[] = $value;
            }
            $model->options = $options;
            if ($model->save())
            {
                Yii::$app->session->setFlash('success', 'Bạn đã yêu cầu thành công.');
                $this->redirect(['create','id'=>$id]);
            }
        }

        return $this->render('create', ['model' => $model, 'id' => $id]);
    }

    public function actionUpdate($id)
    {
        $this->canUser();
        $model = $this->findModel($id);

        foreach ($model->options as $option)
        {
            $data[$option] = $option;
        }
        $model->options = $data;
        if ($model->load(Yii::$app->request->post()))
        {
            $model->publish = SectorOptions::PUBLISH_YES;
            if ($model->save())
            {
                $this->redirect(['/jobcategory/update', 'id' => $model->sector_id]);
            }
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->canUser();
        if (!empty($id))
        {
            foreach (explode(',', $id) as $value)
            {
                $model = $this->findModel($value);
                $model->publish = SectorOptions::PUBLISH_NO;
                $model->save();
            }
        }
        $this->redirect(['index']);
    }

    public function actionRemove($id)
    {
        if (!empty($id))
        {
            foreach (explode(',', $id) as $value)
            {
                $this->findModel($value)->delete();
            }
        }
        $this->redirect(['trash']);
    }

    protected function findModel($id)
    {
        if (($model = SectorOptions::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
