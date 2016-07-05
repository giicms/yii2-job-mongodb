<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class ChangePassword extends Model {

    public $password;
    public $password_new;
    public $password_rep;
    public $_user;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // username and password are both required
            [['password', 'password_new', 'password_rep'], 'required', 'message' => '{attribute} không được rỗng'],
            ['password_new', 'string', 'min' => 8, 'tooShort' => 'Mật khẩu mới phải trên 8 ký tự!'],
            ['password_rep', 'compare', 'compareAttribute' => 'password_new', 'message' => 'Xác nhận mật khẩu không đúng!'],
            ['password', 'validatePassword']
        ];
    }
   


    public function attributeLabels() {
        return [
            'password' => 'Mật khẩu hiện tại',
            'password_new' => 'Mật khẩu mới',
            'password_rep' => 'Xác nhận mật khẩu mới',
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
            // var_dump(Yii::$app->user->identity->id); exit;
            $user = $this->getUser((string)Yii::$app->user->identity->id);

            if (!$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Email hoặc mật khẩu chưa chính xác.');
            } elseif ($user->status == User::STATUS_NOACTIVE) {
                 $this->addError($attribute, 'Tài khoản này chưa kích hoạt.');
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser($id) {
        if ($this->_user === null) {
            $this->_user = User::findOne($id);
//            $this->_user = User::find()->where(['or', ['email' => $this->username, 'phone' => $this->username]])->one();
        }

        return $this->_user;
    }

}
