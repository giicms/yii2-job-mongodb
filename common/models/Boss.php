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
class Boss extends ActiveRecord {

    public static function tableName() {
        return [ 'boss'];
    }

    public function attributes() {
        return [
            '_id',
            'actor',
            'ower',
            'job'
        ];
    }

}
