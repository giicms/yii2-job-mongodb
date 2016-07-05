<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

class Onlinedaily extends ActiveRecord {

    public static function collectionName() {
        return 'online_daily';
    }

    public function rules() {
        return [
            [['day'], 'string'],
            [['counter', 'member', 'boss', 'created_at'], 'integer'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'day',
            'created_at',
            'counter',
            'member',
            'boss'
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

}
