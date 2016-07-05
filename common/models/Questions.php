<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Questions model
 *
 * @property string $content
 */
class Questions extends ActiveRecord {

    public static function tableName() {
        return [ 'questions'];
    }

    public function rules() {
        return [
            [['content'], 'required']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'content'
        ];
    }

    public function attributeLabels() {
        return [
            'content' => 'Nội dung câu hỏi',
        ];
    }

}
