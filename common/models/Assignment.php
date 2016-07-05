<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Job;
use common\models\Bid;
use common\models\User;
use common\models\AssignmentStep;
use common\models\PaymentHistory;

/**
 * Assignment model
 *
 * @property string $conversation_id
 * @property string $job_id
 * @property string $actor
 * @property string $bid_id
 * @property string $price
 * @property string $time_start
 * @property string $time_end
 * @property string $required
 * @property string $status
 * @property string $working_status
 */
class Assignment extends ActiveRecord {

    const STATUS_GIVE = 1; // Boss da giao viec va cho nhan vien dong y lam viec
    const STATUS_DEPOSIT = 2; // Dat coc thanh toan
    const STATUS_COMMITMENT = 3; // Cam ket lam viec
    const STATUS_REQUEST = 4; // Nghiem thu
    const STATUS_PAYMENT = 5; // Hoan thanh & thanh toan
    const STATUS_COMPLETE = 6; // Ket thuc cong viec
	const STATUS_REVIEW = 7; // Review cong viec

    public static function collectionName() {
        return 'assignment';
    }

    public function rules() {
        return [
            [['job_id', 'bid_id', 'owner', 'actor'], 'string'],
            [['status_boss', 'status_member', 'created_at', 'payment'], 'integer'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'job_id',
            'bid_id',
            'owner',
            'actor',
            'status_boss',
            'status_member',
            'terms',
            'created_at',
            'payment'
        ];
    }

    public function attributeLabels() {
        return [
            'terms' => 'Tôi đã đọc kỹ, hiểu rõ và đồng ý với các điều khoản cam kết ở trên.'
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function getBid() {
        return $this->hasOne(Bid::className(), ['_id' => 'bid_id']);
    }

    public function getDeposit() {
        return PaymentHistory::find()->where(['assignment_id' => (string) $this->_id, 'resion'=> PaymentHistory::RES_DEPOSIT])->one();
    }
    public function getJob() {
        return $this->hasOne(Job::className(), ['_id' => 'job_id']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['_id' => 'actor']);
    }

    public function getStartday() {
        return AssignmentStep::find()->where(['assignment_id' => (string) $this->_id, 'status_actor' => Assignment::STATUS_COMMITMENT])->min('created_at');
    }

    public function getEndday() {
        return AssignmentStep::find()->where(['assignment_id' => (string) $this->_id, 'status_owner' => Assignment::STATUS_COMPLETE])->max('created_at');
    }

    public function getDepositday() {
        return PaymentHistory::find()->where(['assignment_id' => (string) $this->_id, 'resion' => PaymentHistory::RES_DEPOSIT])->one();
    }

    public function getPaymentday() {
        return PaymentHistory::find()->where(['assignment_id' => (string) $this->_id, 'resion' => PaymentHistory::RES_PAYMENT])->one();
    }

    public static function getOwner($id, $actor) {
        $model = Assignment::findOne($id);
        if ($model->actor == $actor) {
            return $model->owner;
        } else {
            return $model->actor;
        }
    }

    public function getAsigmentstep(){
        return $this->hasMany(AssignmentStep::className(), ['assignment_id' => 'id']);
    }

    public static function getOverasigmentstep($id){
        return AssignmentStep::find()->where(['assignment_id' => (string)$id, 'status_owner' => Assignment::STATUS_OVER])->one();
    }

	public function findComment($owner) {
        return Review::find()->where(['assignment' => (string) $this->_id, 'owner'=>$owner])->one();
    }
}
