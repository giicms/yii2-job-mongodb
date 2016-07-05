<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Job;
use common\models\User;

class PersonalStorage extends ActiveRecord {

    public static function collectionName() {
        return 'personal_storage';
    }

    public function rules() {
        return [
            [['user_id', 'job_id', 'actor', 'owner'], 'string'],
            [['created_at'], 'integer']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'user_id',
            'job_id',
            'actor',
            'owner',
            'status',
            'created_at'
        ];
    }

    public function getId() {
        return (string) $this->id;
    }

    public function getJob() {
        return $this->hasOne(Job::className(), ['_id' => 'job_id']);
    }

    public function getFindactor() {
        return $this->hasOne(User::className(), ['_id' => 'actor']);
    }

}
