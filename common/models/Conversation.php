<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Conversation model
 *
 * @property string $job_id
 * @property string $status
 * @property string $actor
 * @property string $onwer
 */
class Conversation extends ActiveRecord {

    const PUBLISH_ACTIVE = 1;
    const PUBLISH_BLOCK = 2;

    public static function collectionName() {
        return 'conversation';
    }

    public function rules() {
        return [
            [['message_id', 'owner', 'actor', 'content'], 'string'],
            [['created_at', 'status', 'active', 'set', 'publish', 'date', 'order'], 'integer'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'message_id',
            'owner',
            'actor',
            'content',
            'created_at',
            'date',
            'publish',
            'status',
            'active',
            'set',
            'date',
            'order'
        ];
    }

    public function attributeLabels() {
        return [
            'owner' => 'Người tạo',
            'actor' => 'Người tham gia',
            'content' => 'Nội dung',
            'created_at' => 'Ngày tạo',
            'publish' => 'Trạng thái'
        ];
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    public function getOwners() {
        return $this->hasOne(User::className(), ['_id' => 'owner']);
    }

    public function getProfile() {
        return $this->hasOne(User::className(), ['_id' => 'actor']);
    }

    public function getId() {
        return (string) $this->_id;
    }

}
