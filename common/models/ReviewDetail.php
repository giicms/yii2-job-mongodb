<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * ReviewDetail model
 *
 * @property string $review_id
 * @property string $criteria_id
 * @property string $point
 */
class Review extends ActiveRecord {

    public static function tableName() {
        return ['riview_detail'];
    }

    public function attributes() {
        return [
            '_id',
            'review_id',
            'criteria_rid',
            'piont'
        ];
    }

}
