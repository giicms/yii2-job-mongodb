<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

class AuthRule extends ActiveRecord {

    public static function collectionName() {
        return 'auth_rule';
    }

    public function rules() {
        return [
            [['name'], 'required', 'message' => '{attribute} không được rỗng'],
            [['data'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'name',
            'data',
            'created_at',
            'updated_at',
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

}
