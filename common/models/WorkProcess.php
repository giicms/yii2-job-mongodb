<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

class WorkProcess extends ActiveRecord {

    public static function collectionName() {
        return 'work_process';
    }

    public function rules() {
        return [
            [['user_id', 'company', 'created_begin', 'created_end', 'position'], 'string'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'user_id',
            'company',
            'position',
            'created_begin',
            'created_end'
        ];
    }

}
