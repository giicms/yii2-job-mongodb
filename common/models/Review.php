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
 */
class Review extends ActiveRecord {

    public static function collectionName() {
        return 'reviews';
    }

    public function rules() {
        return [
            [['rating'], 'required', 'message' => 'Đánh giá của bạn '],
            [['comment'], 'required', 'message' => 'Hãy cho chúng tôi biết nhận xét của bạn'],
            [['owner', 'actor'], 'string'],
            [['created_at', 'rating'], 'integer']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'assignment',
            'actor',
            'owner',
            'rating',
            'comment',
            'created_at'
        ];
    }

    public function attributeLabels() {
        return [
            'comment' => 'Nhận xét',
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['_id' => 'actor']);
    }

    public function getFindAssignment() {
        return $this->hasOne(Assignment::className(), ['_id' => 'assignment']);
    }

    public function getFindowner() {
        return $this->hasOne(User::className(), ['_id' => 'owner']);
    }
}
