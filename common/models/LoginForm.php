<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class LoginForm extends Model {

    public $username;
    public $password;
    public $rememberMe = true;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // username and password are both required
            [['username', 'password'], 'required', 'message' => '{attribute} không được rỗng'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword']
        ];
    }

    public function attributeLabels() {
        return [
            'username' => 'Email',
            'password' => 'Mật khẩu',
            'rememberMe' => 'Nhớ tài khoản',
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
                $this->addError($attribute, 'Email hoặc mật khẩu chưa chính xác.');
            elseif ($user->status == User::STATUS_NOACTIVE)
                $this->addError($attribute, 'Tài khoản này chưa kích hoạt.');
            elseif ($user->publish == User::PUBLISH_BLOCK)
                $this->addError($attribute, 'Tài khoản này đã bị khóa.');
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser() {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
//            $this->_user = User::find()->where(['or', ['email' => $this->username, 'phone' => $this->username]])->one();
        }

        return $this->_user;
    }

}
