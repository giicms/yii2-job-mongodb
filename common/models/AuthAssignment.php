<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Account;
use common\models\AuthItem;
use common\models\UserGroup;

class AuthAssignment extends ActiveRecord {

    public static function collectionName() {
        return 'auth_assignment';
    }

    public function rules() {
        return [
            [['item_name', 'user_id'], 'required', 'message' => '{attribute} không được rỗng'],
            [['created_at'], 'integer'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'item_name',
            'user_id',
            'created_at',
        ];
    }
    
      public function attributeLabels() {
        return [
            'user_id' => 'Tên nhân viên',
            'item_name' => 'Quyền'
        ];
    }


    public function getUser() {
        return $this->hasOne(Account::className(), ['_id' => 'user_id']);
    }

    public function getAccount() {
        $account = Account::find()->all();
        $data = [];
        if ($account) {
            foreach ($account as $value) {
                $data[(string) $value->id] = $value->name;
            }
        }
        return $data;
    }

    public function getGroup() {
        $parent = UserGroup::find()->all();
        $data = [];
        if ($parent) {
            foreach ($parent as $value) {
                $data[$value['key']] = $value['name'];
            }
        }
        return $data;
    }

    public function getId() {
        return (string) $this->_id;
    }

}
