<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * City model
 *
 * @property string $name
 * @property string $city_id
 */
class District extends ActiveRecord {

    public static function collectionName() {
        return 'districts';
    }

    public function rules() {
        return [
            [['name', 'city_id'], 'required'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'city_id',
            'name'
        ];
    }

    public function attributeLabels() {
        return [
            'city_id' => 'Tỉnh/thành',
            'name' => 'Tên quận/huyện',
        ];
    }

    public function getCity() {
        return $this->hasOne(City::className(), ['_id' => 'city_id']);
    }

    public function getId() {
        return (string) $this->_id;
    }

}
