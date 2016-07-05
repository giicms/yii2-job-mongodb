<?php 

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\Membership;
use frontend\models\Profile;
use common\models\Page;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\mongodb\ActiveRecord;
use yii\mongodb\ActiveQueryInterface;
use yii\mongodb\Query;

class PageController extends Controller {
	

	public function actionIndex($slug){
		$model = Page::find()->where(['alias'=>$slug])->one();
		if(!empty($model)){
			return $this->render('index', ['model'=>$model]);
		} else {
            throw new \yii\web\NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
		
	}

	// begin boss
	public function actionPageboss(){
		return $this->render('pageboss');
	}

	// begin nhan vien
	public function actionPageworkers(){
		return $this->render('pageworkers');
	}
	public function actionAbout(){
		$about = Page::find()->where(['alias'=>'gioi-thieu'])->one();
		$recruit = Page::find()->where(['alias'=>'co-hoi-nghe-nghiep'])->one();
		$membership = Page::find()->where(['alias'=>'doi-ngu'])->one();
		$partner = Page::find()->where(['alias'=>'doi-tac'])->one();
		$newspaper = Page::find()->where(['alias'=>'bao-chi'])->one();
		$info_contact = Page::find()->where(['alias'=>'thong-tin-lien-he'])->one();
		$map_contact = Page::find()->where(['alias'=>'ban-do-lien-he'])->one();
		return $this->render('about', ['about'=>$about, 
										'recruit'=>$recruit, 
										'membership'=>$membership, 
										'partner'=>$partner, 
										'newspaper'=>$newspaper, 
										'info_contact'=>$info_contact,
										'map_contact'=>$map_contact
									]);
	}
	public function actionPrivacy(){
		$privacy = Page::find()->where(['alias'=>'quy-che-bao-mat'])->one();
		return $this->render('privacy', ['privacy'=>$privacy]);
	}
	public function actionTermsofuse(){
		$termsofuse = Page::find()->where(['alias'=>'dieu-khoan-su-dung'])->one();
		return $this->render('termsofuse', ['termsofuse'=>$termsofuse]);
	}
	public static function getPage($alias){
		$model = Page::find()->where(['alias'=>$alias])->all();
		return $model;
	}


}

?>
