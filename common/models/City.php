<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\District;

/**
 * City model
 *
 * @property string $name
 */
class City extends ActiveRecord {

    public static function collectionName() {
        return 'cities';
    }

    public function rules() {
        return [
            [['name', 'region'], 'required', 'message' => '{attribute} không được rỗng']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'name',
            'region'
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Tên tỉnh/thành phố',
            'region' => 'Miền, vùng'
        ];
    }

    public function getDistrict() {
        return District::find()->where(['city_id' => $this->id])->all();
    }

    public function getId() {
        return (string) $this->_id;
    }

}
