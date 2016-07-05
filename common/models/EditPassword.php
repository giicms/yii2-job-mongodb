<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class EditPassword extends Model {

    public $password;
    public $password_rep;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['password'], 'required', 'message' => '{attribute} không được rỗng'],
            ['password', 'string', 'min' => 8, 'tooShort' => 'Mật khẩu phải trên 8 ký tự!'],
            ['password_rep', 'compare', 'compareAttribute' => 'password', 'message' => 'Xác nhận mật khẩu mới không đúng!'],
        ];
    }
   
    



}
