<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

class UserLang extends ActiveRecord {

    public static function collectionName() {
        return 'user_lang';
    }

    public function rules() {
        return [
            [['language_id', 'user_id', 'level_id'], 'required']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'language_id',
            'level_id',
            'user_id'
        ];
    }

}
