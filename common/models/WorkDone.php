<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

class WorkDone extends ActiveRecord {

    public static function collectionName() {
        return 'work_done';
    }

    public function rules() {
        return [
            [['name'], 'required'],
            [['user_id', 'description', 'link'], 'string'],
            [['files'], 'default']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'user_id',
            'name',
            'description',
            'link',
            'files'
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Tên dự án',
            'description' => 'Mô tả dự án',
            'Link' => 'Link dự án',
            'files' => 'Hình ảnh dự án'
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

}
