<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Setting model
 *
 * @property string $name
 */
class Setting extends ActiveRecord {

    public static function collectionName() {
        return 'settings';
    }

    public function rules() {
        return [
            [['key', 'value'], 'required'],
            [['content','description'], 'string']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'key',
            'value',
            'description',
            'content'
        ];
    }

    public function attributeLabels() {
        return [
            'description' => 'Mô tả',
            'content' => 'Nội dung'
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

}
