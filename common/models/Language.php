<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

class Language extends ActiveRecord {

    public static function collectionName() {
        return 'languages';
    }

    public function rules() {
        return [
            [['name'], 'required', 'message' => '{attribute} không được rỗng'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'name',
            'slug'
        ];
    }

}
