<?php

namespace frontend\modules\gallery\controllers;

use Yii;
use yii\web\Controller;
use frontend\modules\gallery\models\Crop;
use frontend\modules\gallery\components\Resize;

class CropController extends Controller
{

    public function actionIndex()
    {
        $model = new Crop();
        if ($model->load(Yii::$app->request->post()))
        {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $output_dir = Yii::$app->setting->value("file");
            $url = $output_dir . 'thumbnails/' . $model->id . '.png';
            $thumb = $output_dir . 'thumbnails/150-' . $model->id . '.png';
            $cropped = Resize::resizeThumbnailImage($thumb, $url, $model->w, $model->h, $model->x1, $model->y1, 1);
            return ['url' => Yii::$app->setting->value('url_file') . 'thumbnails/150-' . $model->id . '.png', 'name' => $model->id . '.png'];
        }
        $src = Yii::$app->setting->value('url_file') . 'thumbnails/' . $_GET['id'] . '.png';
        return $this->renderAjax('index', ['src' => $src, 'model' => $model, 'id' => $_GET['id']]);
    }

}
