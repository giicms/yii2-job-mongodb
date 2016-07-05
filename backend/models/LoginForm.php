<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Account;

/**
 * Login form
 */
class LoginForm extends Model
{

    public $username;
    public $password;
    public $code;
    public $rememberMe = true;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'code'], 'required', 'message' => '{attribute} không được rỗng!'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['code', 'validateCode']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Tên đăng nhập hoặc email',
            'password' => 'Mật khẩu',
            'code' => 'Mã code',
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
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password))
            {
                $this->addError($attribute, 'Tên đăng nhập hoặc mật khẩu chưa chính xác.');
            }
            elseif ($user->status == Account::STATUS_BLOCK)
            {
                $this->addError($attribute, 'Tài khoản này đã bị khóa.');
            }
        }
    }

    public function validateCode($attribute, $params)
    {
        $ga = new \backend\components\GoogleAuthenticator();
        if (!$this->hasErrors())
        {
            $user = $this->getUser();
            $checkResult = $ga->verifyCode($user->secret, $this->code, 1);
            if (!$checkResult)
            {
                $this->addError($attribute, 'Mã code nhập chưa đúng.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate())
        {
            $login = Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        else
        {
            $login = false;
        }
        return $login;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null)
        {
            $this->_user = Account::findByUsername($this->username);
//            $this->_user = Account::find()->where(['email' => $this->username])->orWhere(['username' => $this->username])->one();
        }

        return $this->_user;
    }

}
