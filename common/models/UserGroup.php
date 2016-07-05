<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;

class UserGroup extends ActiveRecord {

    const USERGROUP_SUPER = 1;
    const USERGROUP_ADMIN = 2;
    const USERGROUP_GROUP = 3;
    const USERGROUP_USER = 4;

    public $rule;
    public $parent;

    public static function collectionName() {
        return 'user_group';
    }

    public function rules() {
        return [
            [['name', 'key', 'level'], 'required'],
            [['rule', 'level'], 'integer']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'name',
            'key',
            'level'
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Tên nhóm',
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function getRules() {
        return [
            Item::TYPE_ROLE => 'Role',
            Item::TYPE_PERMISSION => 'Permission'
        ];
    }

    public function getLevels() {
        return [
            UserGroup::USERGROUP_SUPER => 'Super Admin',
            UserGroup::USERGROUP_ADMIN => 'Admin',
            UserGroup::USERGROUP_GROUP => 'Group',
            UserGroup::USERGROUP_USER => 'User'
        ];
    }

    public function getListRole() {
        $data = [];
        $min = \Yii::$app->user->identity->level + 1;
        $max = UserGroup::find()->max('level') + 1;
        $model = UserGroup::find()
                ->where(['between', 'level', (int) $min, (int) $max])
                ->all();
        return ArrayHelper::map($model, 'key', 'name');
    }

}
