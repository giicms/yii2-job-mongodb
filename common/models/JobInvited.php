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
class JobInvited extends ActiveRecord {

    const STATUS_NOACCEPT = 1;
    const STATUS_ACCEPT = 2;
    const STATUS_CLOSE = 3;

    public static function collectionName() {
        return 'job_invited';
    }

    public function rules() {
        return [
            [['job_id', 'message'], 'required', 'message' => '{attribute} không được rỗng'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'job_id',
            'actor',
            'message',
            'created_at',
            'status'
        ];
    }

    public function attributeLabels() {
        return [
            'message' => 'Tin nhắn',
            'job_id' => 'Công việc'
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['_id' => 'actor']);
    }

    public function getId() {
        return (string) $this->_id;
    }

}
