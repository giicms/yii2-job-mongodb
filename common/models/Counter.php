<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

class Counter extends ActiveRecord {

    public static function collectionName() {
        return 'counters';
    }

    public function rules() {
        return [
            [['last_visit'], 'safe'],
            [['ip_address'], 'string'],
            [['updated_at', 'hit'], 'integer'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'last_visit',
            'ip_address',
            'updated_at',
            'hit'
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

}
