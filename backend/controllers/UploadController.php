<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class UploadController extends Controller {

    public function actionImage() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $fileName = 'file';
        $output_dir = Yii::$app->info->setting('file');
        if (isset($_FILES[$fileName])) {
            $getfile = \yii\web\UploadedFile::getInstanceByName($fileName);
//            $size = number_format($_FILES["myfile"]["size"] / 1024, 2);
            list($name, $ext) = explode(".", $getfile->name);
            list($width, $height) = getimagesize($getfile->tempName);
            $new_name = time();
            if (move_uploaded_file($getfile->tempName, $output_dir . 'thumbnails/' . $new_name . '.png')) {
                $fileNameArray = explode('.', $fileName);
                $fileTypeArray = explode('/', $getfile->type);
                if (($width > 400) || ( $height > 400)) {
                    $img = \Imagicks::open($output_dir . 'thumbnails/' . $new_name . '.png')->thumb(250, 250)->saveTo($output_dir . 'thumbnails/' . $new_name . '.png');
                } else {
                    if ($width > $height)
                        $num = $width;
                    else
                        $num = $height;
                    $img = \Imagicks::open($output_dir . 'thumbnails/' . $new_name . '.png')->thumb($num, $num)->saveTo($output_dir . 'thumbnails/' . $new_name . '.png');
                }
                $img_thumb = $output_dir . 'thumbnails/' . $new_name . '.png';
                return $new_name . '.png';
            }
//            if ($file->saveAs($uploadPath . 'thumbnails/' . $file->name)) {
//                $img = \Imagicks::open($output_dir . $new_name . '.' . $ext)->thumb(400, 400)->saveTo($output_dir . 'thumbnails/' . $new_name . '.png');
//                echo \yii\helpers\Json::encode($file);
//            }
        }

        return false;
    }

    public function actionRemove() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['file'])) {
            if (file_exists(Yii::$app->info->setting('file') . 'thumbnails/' . $_POST['file'])) {
                unlink(Yii::$app->info->setting('file') . 'thumbnails/' . $_POST['file']);
                return ['ok'];
            } else {
                return ['error'];
            }
        }
    }

}
