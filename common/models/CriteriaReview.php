<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * CriteriaReview model
 *
 * @property string $conversation_id
 * @property string $user_id
 * @property string $content
 * @property string $files
 */
class CriteriaReview extends ActiveRecord {

    public static function tableName() {
        return ['ceriater_review'];
    }

    public function attributes() {
        return [
            '_id',
            'name'
        ];
    }

}
