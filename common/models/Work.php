<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Work model
 *
 * @property string $conversation_id
 * @property string $user_id
 * @property string $content
 * @property string $files
 */
class Work extends ActiveRecord {

    public static function tableName() {
        return ['work_done'];
    }

    public function attributes() {
        return [
            '_id',
            'user_id',
            'name',
            'description',
            'files'
        ];
    }

}
