<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Conversation;
use common\models\User;

/**
 * Messages model
 *
 * @property string $conversation_id
 * @property string $user_id
 * @property string $content
 * @property string $file
 */
class Messages extends ActiveRecord {

    const PUBLISH_ACTIVE = 1;
    const PUBLISH_BLOCK = 2;

    public static function tableName() {
        return 'messages';
    }

    public function rules() {
        return [
            [['job_id', 'owner', 'actor'], 'string'],
            [['created_at', 'updated_at', 'status', 'publish'], 'integer']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'owner',
            'actor',
            'status',
            'publish',
            'created_at',
            'updated_at',
            'job_id'
        ];
    }

    public function attributeLabels() {
        return [
            'owner' => 'Người tạo',
            'actor' => 'Người tham gia',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cuối cuộc trò chuyện',
            'publish' => 'Trạng thái'
        ];
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public static function conversation($id) {
        return Conversation::find()->where(['message_id' => $id])->orderBy(['created_at' => SORT_ASC])->all();
    }

    public function getUserowner() {
        return $this->hasOne(User::className(), ['_id' => 'owner']);
    }

    public function getUseractor() {
        return $this->hasOne(User::className(), ['_id' => 'actor']);
    }

    public function getId() {
        return (string) $this->_id;
    }

}
