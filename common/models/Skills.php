<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Account;

class Skills extends ActiveRecord {

    public static function collectionName() {
        return 'skills';
    }

    public function rules() {
        return [
            [['name'], 'required', 'message' => '{attribute} không được rỗng'],
            [['description', 'user_id'], 'string'],
            ['created_at', 'integer']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'user_id',
            'name',
            'description',
            'created_at'
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Tên kỷ năng',
            'description' => 'Mô tả',
            'user_id' => 'Người tạo',
            'created_at' => 'Ngày tạo'
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function getUser() {
        return $this->hasOne(Account::className(), ['_id' => 'user_id']);
    }

}
