<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

class Online extends ActiveRecord {

    public static function collectionName() {
        return 'online';
    }

    public function rules() {
        return [
            [['ip', 'site', 'agent'], 'string'],
            [['time'], 'integer'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'ip',
            'site',
            'agent',
            'time'
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

}
