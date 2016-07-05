<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Questions;
use common\models\Category;
use common\models\Sectors;

class Membership extends User {

    public $email;
    public $email_active;
    public $name;
    public $slug;
    public $slugname;
    public $fbid;
    public $phone;
    public $address;
    public $password;
    public $password_repeat;
    public $questions;
    public $category;
    public $sector;

    public function rules() {
        return [
            [['name', 'email'], 'filter', 'filter' => 'trim'],
            [['name', 'email', 'phone', 'password', 'password_repeat'], 'required', 'message' => '{attribute} không được rỗng'],
            ['phone', 'unique', 'targetAttribute' => 'phone', 'message' => '{attribute} này đã tồn tại trong hệ thống'],
            ['phone', 'number', 'integerOnly' => true, 'message' => 'Số điện thoại phải là những dãy số'],
            ['phone', 'string', 'min' => 10, 'max' => 11, 'tooShort' => 'Số điện thoại phải từ 10 đến 11 số', 'tooLong' => 'Số điện thoại phải từ 10 đến 11 số!'],
            ['email', 'email', 'message' => 'Email này không đúng.'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Email này đã tồn tại trong hệ thống.'],
            ['password', 'string', 'min' => 8, 'tooShort' => 'Mật khẩu phải trên 8 ký tự!'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Hai mật khẩu không trùng nhau!'],
            ['email_active', 'default', 'value' => 0],
            ['sector', 'default'],
            [['questions','fbid', 'slug', 'slugname', 'category', 'sector'], 'string']
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

    public function attributeLabels() {
        $labels = [
        ];

        return array_merge($labels, parent::attributeLabels());
    }

    public function getCategoryList() {
        $models = Category::find()->all();
        $data = [];
        if ($models) {
            foreach ($models as $value) {
                $data[(string) $value['_id']] = $value['name'];
            }
        }
        return $data;
    }

    public function getSectorList() {
        $models = Sectors::find()->where(['category_id' => $this->category_id])->all();
        $data = [];
        if ($models) {
            foreach ($models as $value) {
                $data[(string) $value['_id']] = $value['name'];
            }
        }
        return $data;
    }

}
