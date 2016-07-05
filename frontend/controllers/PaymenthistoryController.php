<?php 

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Job;
use common\models\Assignment;
use common\models\PaymentHistory;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\mongodb\ActiveRecord;
use yii\mongodb\ActiveQueryInterface;
use yii\mongodb\Query;

class PaymenthistoryController extends Controller {

    public function actionSalarytable() {
        $making = Assignment::find()->where(['actor' => (string) Yii::$app->user->identity->id])->andWhere(['between','status_member', Assignment::STATUS_COMMITMENT, Assignment::STATUS_REQUEST])->andWhere(['between','status_boss', Assignment::STATUS_COMMITMENT, Assignment::STATUS_PAYMENT])->all();
        $completed = Assignment::find()->where(['actor' => (string) Yii::$app->user->identity->id])->andWhere(['between','status_member', Assignment::STATUS_COMPLETE, Assignment::STATUS_REVIEW])->all();
        $thismonth =[];
        foreach ($completed as $value) {
            $lastday = strtotime('last day of this month', time());
            $firstday = strtotime('first day of this month', time());
            if(($value->endday >= $firstday)&&($value->endday <= $lastday)){
                $thismonth[] = (string)$value->_id;
            }
        }
        $job_thismonth = Assignment::find()->where(['IN', '_id', $thismonth])->all();
        return $this->render('salarytable', ['making'=>$making, 'completed'=>$completed, 'job_thismonth'=>$job_thismonth]);
    }

//PROJECT_DEPOSIT
    public function actionPaymenthistory() {
    	$deposit = Job::find()->where(['owner'=> (string) Yii::$app->user->identity->id, 'publish' => Job::PUBLISH_ACTIVE, 'block' => Job::JOB_UNBLOCK, 'status' => Job::PROJECT_PENDING])->all();
        $arrdep =[];
        $arrpay =[];
        foreach ($deposit as $value) {
        	if($value->category->deposit > 0){
        		$arrdep[] = (string)$value->_id;
        	}
        }
        $job_deposit = Job::find()->where(['IN', '_id', $arrdep])->all();
        $payment = Job::find()->where(['owner'=> (string) Yii::$app->user->identity->id, 'publish' => Job::PUBLISH_ACTIVE, 'block' => Job::JOB_UNBLOCK, 'status' => Job::PROJECT_DEPOSIT])->all();
        $job_payment = Job::find()->where(['IN', '_id', $arrpay])->all();
		$payment_his = PaymentHistory::find()->where(['user'=>(string) Yii::$app->user->identity->id])->all();
        return $this->render('paymenthistory', ['deposit'=>$job_deposit, 'payment'=>$payment, 'payment_history'=>$payment_his]);
		
    }
}

?>
