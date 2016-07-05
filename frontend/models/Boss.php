<?php

namespace frontend\models;

use common\models\User;
use common\models\Questions;
use yii\base\Model;
use Yii;
use common\models\City;
use common\models\District;

/**
 * Signup form
 */
class Boss extends User {

    public $email;
    public $email_active;
    public $name;
    public $slug;
    public $slugname;
    public $fbid;
    public $phone;
    public $boss_type;
    public $company_name;
    public $company_code;
    public $address;
    public $city;
    public $district;
    public $password;
    public $password_repeat;
    public $verifyCode;
    public $questions;

    public function rules() {
        return [
            [['name', 'email'], 'filter', 'filter' => 'trim'],
            [['name', 'email', 'phone', 'password', 'password_repeat', 'questions'], 'required', 'message' => '{attribute} không được rỗng!'],
            ['phone', 'unique', 'targetAttribute' => 'phone', 'message' => '{attribute} này đã tồn tại trong hệ thống!'],
            ['phone', 'number', 'integerOnly' => true, 'message' => 'Số điện thoại phải là những dãy số'],
            ['phone', 'string', 'min' => 10, 'max' => 11, 'tooShort' => 'Số điện thoại phải từ 10 đến 11 số', 'tooLong' => 'Số điện thoại phải từ 10 đến 11 số!'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Email này đã tồn tại trong hệ thống!'],
            ['password', 'string', 'min' => 8, 'tooShort' => 'Mật khẩu phải trên 8 ký tự!'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Hai mật khẩu không trùng nhau!'],
            ['email_active', 'default', 'value' => 0],
            [['address', 'questions', 'fbid', 'slug', 'slugname'], 'string']
        ];
    }

    public function getQuestionList() {
        $models = Questions::find()->all();
        $data = [];
        if ($models) {
            foreach ($models as $value) {
                $data[(string) $value['_id']] = $value['content'];
            }
        }
        return $data;
    }

    public function getCityList() {
        $models = City::find()->all();
        $data = [];
        if ($models) {
            foreach ($models as $value) {
                $data[(string) $value['_id']] = $value['name'];
            }
        }
        return $data;
    }


}
