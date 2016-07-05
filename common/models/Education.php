<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

class Education extends ActiveRecord {

    public static function collectionName() {
        return 'education';
    }

    public function rules() {
        return [
            [['user_id', 'school', 'created_begin', 'created_end', 'course'], 'string'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'user_id',
            'school',
            'course',
            'created_begin',
            'created_end'
        ];
    }

}
