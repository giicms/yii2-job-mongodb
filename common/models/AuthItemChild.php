<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\AuthItem;
use common\models\UserGroup;

class AuthItemChild extends ActiveRecord {

    public static function collectionName() {
        return 'auth_item_child';
    }

    public function rules() {
        return [
        ];
    }

    public function attributes() {
        return [
            '_id',
            'parent',
            'child',
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function getAuthList() {
        $models = UserGroup::find()->all();
        $data = [];
        if ($models) {
            $data['NULL'] = 'Parent';
            foreach ($models as $value) {
                $data[$value['key']] = $value['name'];
            }
        }
        return $data;
    }


}
