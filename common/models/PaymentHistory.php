<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

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
class PaymentHistory extends ActiveRecord {

    const RES_DEPOSIT = 1; //Dat coc cong viec
    const RES_PAYMENT = 2; //thanh toan cong viec
    const RES_SAVING  = 2; //Nap vào tai khoan tiet kiem

    public static function tableName() {
        return 'payment_history';
    }

    public function rules() {
        return [
            [['user', 'assignment_id'], 'string'],
            [['value', 'resion', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'user',
            'assignment_id',
            'value',
            'resion',
            'created_at',
            'updated_at',
        ];
    }
	
	public function getAssignment() {
        return $this->hasOne(Assignment::className(), ['_id' => 'assignment_id']);
    }

}
