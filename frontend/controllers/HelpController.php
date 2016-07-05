<?php 

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\BlogCategory;
use common\models\Posts;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\mongodb\ActiveRecord;
use yii\mongodb\ActiveQueryInterface;
use yii\mongodb\Query;


class HelpController extends Controller {
	public function actionManual() {
        $manual = BlogCategory::find()->where(['parent'=>'5641a102c289faf91b8b4567', 'publish'=>1])->orderBy(['order' => SORT_ASC])->all();
    	$post = Posts::find()->where(['category_id'=>'5641a102c289faf91b8b4567', 'publish'=>'1'])->all();
        return $this->render('manual', ['manual'=>$manual,'post'=>$post]);
    }
    public function actionManualcat() {
        $manual = BlogCategory::find()->where(['parent'=>'5641a102c289faf91b8b4567', 'publish'=>1])->orderBy(['order' => SORT_ASC])->all();
        $post = Posts::find()->where(['category_id'=>'5641a102c289faf91b8b4567', 'publish'=>'1'])->all();
        return $this->render('manualcat', ['manual'=>$manual,'post'=>$post]);
    }
    public function actionManualdetail($id) {
        $manual = BlogCategory::find()->where(['parent'=>'5641a102c289faf91b8b4567', 'publish'=>1])->orderBy(['order' => SORT_ASC])->all();
        $post = Posts::find()->where(['category_id'=>'5641a102c289faf91b8b4567', 'publish'=>'1'])->all();
        $model = Posts::findOne($id);
    	return $this->render('manualdetail', ['manual'=>$manual, 'post'=>$post, 'model'=>$model]);
    }
    public function actionQuestion(){
    	$question = BlogCategory::find()->where(['parent'=>'5641a151c289fadd1c8b4567', 'publish'=>1])->orderBy(['order' => SORT_ASC])->all();
    	$post = Posts::find()->where(['category_id'=>'5641a151c289fadd1c8b4567', 'publish'=>'1'])->all();
        return $this->render('question', ['question'=>$question, 'post'=>$post]);
    }
    public function actionQuestioncat() {
        $question = BlogCategory::find()->where(['parent'=>'5641a151c289fadd1c8b4567', 'publish'=>1])->orderBy(['order' => SORT_ASC])->all();
        $post = Posts::find()->where(['category_id'=>'5641a151c289fadd1c8b4567', 'publish'=>'1'])->all();
        return $this->render('questioncat', ['question'=>$question,'post'=>$post]);
    }
    public function actionQuestiondetail($id){
    	$question = BlogCategory::find()->where(['parent'=>'5641a151c289fadd1c8b4567', 'publish'=>1])->orderBy(['order' => SORT_ASC])->all();
    	$post = Posts::find()->where(['category_id'=>'5641a151c289fadd1c8b4567', 'publish'=>'1'])->all();
        $model = Posts::findOne($id);
        return $this->render('questiondetail', ['question'=>$question, 'post'=>$post, 'model'=>$model]);
    }
    

}

?>