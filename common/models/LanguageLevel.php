<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

class LanguageLevel extends ActiveRecord {

    public static function collectionName() {
        return 'language_level';
    }

    public function rules() {
        return [
            [['name', 'language_id'], 'required', 'message' => '{attribute} không được rỗng'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'language_id',
            'name'
        ];
    }

}
