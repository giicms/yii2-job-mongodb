<?php

namespace frontend\modules\gallery\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Collection;
use frontend\modules\gallery\components\Resize;
use common\models\User;

class UploadController extends Controller
{

    public function actionIndex()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $output_dir = Yii::$app->setting->value("file");
        if (isset($_FILES["myfile"]))
        {
            $data = [];
            $error = $_FILES["myfile"]["error"];
            if ($error == 0)
            {
                $fileName = $_FILES["myfile"]["name"];
                $size = number_format($_FILES["myfile"]["size"] / 1024, 2);
                list($name, $ext) = explode(".", $fileName);
                list($width, $height) = getimagesize($_FILES["myfile"]["tmp_name"]);
                $new_name = time();
                if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $new_name . '.' . $ext))
                {
                    $fileNameArray = explode('.', $fileName);
                    $fileTypeArray = explode('/', $_FILES["myfile"]["type"]);
                    if ($width >= $height)
                    {
                        $x1 = $x2 = ($width - $height) / 2;
                        $y1 = $y2 = 0;
                        $w = $h = $height;
                    }
                    else
                    {
                        $x1 = $x2 = 0;
                        $y1 = $y2 = ($height - $width) / 2;
                        $w = $h = $width;
                    }

                    if ($width > 400)
                        $scale = 500 / $w;
                    else
                        $scale = $w / $w;
                    $cropped = Resize::resizeThumbnailImage($output_dir . 'thumbnails/' . $new_name . '.png', $output_dir . $new_name . '.' . $ext, $w, $h, $x1, $y1, $scale);
                    $data = ['url' => Yii::$app->setting->value("url_file") . 'thumbnails/' . $new_name . '.png', 'size' => $size, 'name' => $new_name . '.png', 'img_id' => $new_name];
                }
            } else
            {
                $data = ['error' => 'Dung lượng upload quá 2 MB, hoặc hình không đúng định dạng (jpg,png,jpeg,gif). '];
            }
            return [
                'data' => $data
            ];
        }
    }

    public function actionMultiple()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

}
