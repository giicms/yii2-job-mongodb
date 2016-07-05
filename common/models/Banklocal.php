<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Boss model
 *
 * @property string $actor
 * @property string $ower
 * @property string $job
 */
class Banklocal extends ActiveRecord {

    public static function collectionName() {
        return 'bank_local';
    }

    public function rules() {
        return [
            [['name'], 'required']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'bank_id',
            'city_id',
            'created_at',
            'updated_at'
        ];
    }

    public function attributeLabels() {
        return [
            'bank_id' => 'Ngân hàng',
            'city_id' => 'Tỉnh/Thành phố',
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    


}
