<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Account;

/**
 * Change password form
 */
class ChangePassword extends Account {

    public $password;
    public $password_new;
    public $password_repeat;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['password',], 'required', 'message' => '{attribute} không được rỗng!'],
            ['password', 'string', 'min' => 8, 'tooShort' => 'Mật khẩu phải trên 8 ký tự!'],
            ['password', 'validatePassword'],
            ['password_new', 'string', 'min' => 8, 'tooShort' => 'Mật khẩu mới phải trên 8 ký tự!'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password_new', 'message' => 'Hai mật khẩu không trùng nhau!'],
        ];
    }

    public function attributeLabels() {
        return [
            'password' => 'Mật khẩu cũ',
            'password_new' => 'Mật khẩu mới',
            'password_repeat' => 'Nhập lại mật khẩu',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password))
                $this->addError($attribute, 'Mật khẩu cũ chưa chính xác.');
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser() {
        if ($this->_user === null) {
            $this->_user = Account::findByUsername(Yii::$app->user->identity->username);
        }

        return $this->_user;
    }

}
