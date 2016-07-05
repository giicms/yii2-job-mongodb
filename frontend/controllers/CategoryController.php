<?php 
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\User;
use common\models\Category;
use common\models\Sectors;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\mongodb\ActiveRecord;
use yii\mongodb\ActiveQueryInterface;
use yii\mongodb\Query;

/**
 * Site controller
 */
class CategoryController extends Controller {

	public function actionIndex() {
        $model = Category::find()->all();
        $members = User::find()->where(['role' => User::ROLE_MEMBER, 'step' => 5])->orderBy(['rating' => SORT_DESC])->limit(5)->all();
        return $this->render('index', ['jobCategory'=> $model, 'member'=>$members]);
    }

}
?>
