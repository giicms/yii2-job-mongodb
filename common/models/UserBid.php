<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Boss model
 *
 * @property string $actor
 * @property string $ower
 * @property string $job
 */
class UserBid extends ActiveRecord {

    const STATUS_NOACCEPT = 1;
    const STATUS_ACCEPT = 2;
    const STATUS_CLOSE = 3;
    const STATUS_PENDING = 4;

    public static function collectionName() {
        return 'user_bid';
    }

    public function rules() {
        return [
            [['owner_id', 'actor_id', 'message'], 'required'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'owner_id',
            'actor_id',
            'message',
            'created_at',
            'status'
        ];
    }

    public function attributeLabels() {
        return [
            'owner_id' => 'Khách hàng',
            'actor_id' => 'Nhân viên',
            'message' => 'Tin nhắn',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày book'
        ];
    }

    public function getOwner() {
        return $this->hasOne(User::className(), ['_id' => 'owner_id']);
    }

    public function getActor() {
        return $this->hasOne(User::className(), ['_id' => 'actor_id']);
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function getDropstatus() {
        return [
            self::STATUS_NOACCEPT => 'Chưa chấp nhận',
            self::STATUS_ACCEPT => 'Chấp nhận',
            self::STATUS_CLOSE => 'Hủy chấp nhận',
            self::STATUS_PENDING => 'Đang làm việc'
        ];
    }

}
