<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Account;

class ForgetPassword extends Model {

    public $email;
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['email'], 'required', 'message' => '{attribute} không được rỗng!'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Account', 'message' => 'Email này đã tồn tại trong hệ thống!'],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => 'Nhập địa chỉ email'
        ];
    }

}
