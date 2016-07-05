<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Collection;
use common\models\User;

/**
 * Upload controller
 */
class UploadController extends FrontendController {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    'create' => ['post'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionFile() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $output_dir = Yii::$app->params['file'];
        if (isset($_FILES["myfile"])) {
            $ret = array();

            $error = $_FILES["myfile"]["error"];
            //You need to handle  both cases
            //If Any browser does not support serializing of multiple files using FormData() 
            if (!is_array($_FILES["myfile"]["name"])) { //single file
                $fileName = $_FILES["myfile"]["name"];

                list($name, $ext) = explode(".", $fileName);
                $new_name = time() . '.' . $ext;
                if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $new_name)) {
                    $fileNameArray = explode('.', $fileName);
                    $fileTypeArray = explode('/', $_FILES["myfile"]["type"]);
                    $size = number_format($_FILES["myfile"]["size"] / 1024, 2);
                    $ret[] = array('name' => Yii::$app->params['url_file'] . $new_name, 'size' => $size);
                }
            } else {  //Multiple files, file[]
                $fileCount = count($_FILES["myfile"]["name"]);
                for ($i = 0; $i < $fileCount; $i++) {
                    $fileName = $_FILES["myfile"]["name"][$i];
                    list($name, $ext) = explode(".", $fileName);
                    $new_name = time() . '.' . $ext;

                    if (move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . $new_name)) {
                        $fileNameArray = explode('.', $new_name);
                        $fileTypeArray = explode('/', $_FILES["myfile"]["type"][$i]);
                        $media->user_id = \Yii::$app->user->identity->id;
                        $media->title = $fileNameArray[0];
                        $media->type = $fileTypeArray[0];

                        $media->size = $_FILES["myfile"]["size"][$i];
                        if ($fileTypeArray[1] == 'pdf') {
                            $url = \app\functions\Imagick::convertImage(Yii::$app->basePath . '/uploads/', $new_name);
                        } else {
                            $url = '/uploads/' . $new_name;
                        }
//                        \app\functions\Imagick::open(Yii::$app->basePath . $url)->thumb(60, 60)->saveTo($output_dir . 'thumbnail/' . $fileName);
//                        \app\functions\Imagick::cropImage(Yii::$app->basePath . '/uploads/', $fileName, 60, 60, 60, 60);
                        $media->url = '/uploads/' . $new_name;
                        $media->created_at = time();
                        $media->save();
                        $ret[] = array('id' => $media->id, 'url' => '/uploads/' . $new_name, 'name' => $new_name);
                    }
                }
            }
            return [
                'data' => $ret
            ];
        }
    }

    public function actionImage() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $output_dir = Yii::$app->params['file'];
        if (isset($_FILES["myfile"])) {

            $ret = array();

            $error = $_FILES["myfile"]["error"];
            //You need to handle  both cases
            //If Any browser does not support serializing of multiple files using FormData() 
            if (!is_array($_FILES["myfile"]["name"])) { //single file
                $fileName = $_FILES["myfile"]["name"];
                $size = number_format($_FILES["myfile"]["size"] / 1024, 2);
                list($name, $ext) = explode(".", $fileName);
//                list($width, $height) = getimagesize($_FILES["myfile"]["tmp_name"]);



                $new_name = time();
                if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $new_name . '.' . $ext)) {
                    $fileNameArray = explode('.', $fileName);
                    $fileTypeArray = explode('/', $_FILES["myfile"]["type"]);
//                    if (($width > 400) || ( $height > 400)) {
//                        $img = \Imagicks::open($output_dir . $new_name . '.' . $ext)->thumb(400, 400)->saveTo($output_dir . 'thumbnails/' . $new_name . '.png');
//                    } else {
//                        if ($width > $height)
//                            $num = $width;
//                        else
//                            $num = $height;
                    $img = \Imagicks::open($output_dir . $new_name . '.' . $ext)->thumb(400, 400)->saveTo($output_dir . 'thumbnails/' . $new_name . '.png');
//                    }
                    $img_thumb = $output_dir . 'thumbnails/' . $new_name . '.png';
                    Yii::$app->session->setFlash('img', $new_name . '.png');
                    $ret[] = ['url' => Yii::$app->params['url_file'] . 'thumbnails/' . $new_name . '.png', 'size' => $size, 'name' => $new_name . '.png', 'img_id' => $new_name];
                }
            } else {  //Multiple files, file[]
                $fileCount = count($_FILES["myfile"]["name"]);
                for ($i = 0; $i < $fileCount; $i++) {
                    $fileName = $_FILES["myfile"]["name"][$i];
                    list($name, $ext) = explode(".", $fileName);
                    $new_name = md5($name . time()) . '.' . $ext;
                    if (move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . $new_name)) {
                        $img = \Imagicks::open($output_dir . $new_name)->thumb(150, 150)->saveTo($output_dir . 'thumbnails/' . $new_name);
                        $ret[] = array('url' => Yii::$app->params['url_file'] . 'thumbnails/' . $new_name, 'name' => $new_name, 'id' => time());
                    }
                }
            }
            return [
                'data' => $ret
            ];
        }
    }

    public function actionRemove() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (file_exists(Yii::$app->params['file'] . $_POST['file'])) {
            unlink(Yii::$app->params['file'] . $_POST['file']);
            return ['ok'];
        } else {
            return ['error'];
        }
    }

    public function actionCropimage() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['img'])) {
            $crop = \Imagicks::cropImage(Yii::$app->params['file'] . 'thumbnails/', $_POST['img'], $_POST['x1'], $_POST['y1'], $_POST['w'], $_POST['h']);
            $rezize150 = \Imagicks::open(Yii::$app->params['file'] . 'thumbnails/' . $crop)->thumb(150, 150)->saveTo(Yii::$app->params['file'] . 'thumbnails/150-' . $_POST['img']);
            $rezize60 = \Imagicks::open(Yii::$app->params['file'] . 'thumbnails/150-' . $_POST['img'])->thumb(60, 60)->saveTo(Yii::$app->params['file'] . 'thumbnails/60-' . $_POST['img']);
            $user = User::findOne(Yii::$app->user->identity->id);
            $user->avatar = $_POST['img'];
            $user->save();
            return ['url' => Yii::$app->params['url_file'] . 'thumbnails/' . $_POST['w'] . '-' . $_POST['img'], 'name' => $_POST['img']];
        }
    }

    public function actionAjax() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $fileName = 'file';
//        $output_dir = Yii::$app->info->setting('file');
        $output_dir = Yii::$app->params['file'];
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
        }

        return false;
    }

}
