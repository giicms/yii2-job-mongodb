<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\User;
use common\models\Job;
use yii\mongodb\Query;
use common\models\Assignment;


class Statistical extends ActiveRecord  {

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'statistical';
    }

    public function attributes() {
        return [
            '_id',
            'objects',
            'role',
            'status',
            'publish',
            'type',
            'created_at'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['objects', 'role', 'type'], 'string'],
            [['created_at', 'status', 'publish'], 'integer'],
        ];
    }

}
