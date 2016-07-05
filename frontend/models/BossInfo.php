<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Questions;
use common\models\Category;
use common\models\Sectors;
use common\models\Language;
use common\models\City;
use common\models\District;

class BossInfo extends User {

    const TYPE_PERSONAL = 1;
    const TYPE_COMPANY = 2;

    public $avatar;
    public $name;
    public $email;
    public $address;
    public $company_name;
    public $company_code;
    public $phone;
    public $city;
    public $district;
    public $boss_type;

    public function rules() {
        return [
            [['avatar'], 'required', 'message' => 'Bạn chưa cập nhật avatar'],
            [['name', 'email'], 'filter', 'filter' => 'trim'],
            [['name', 'email', 'phone', 'address', 'city', 'district', 'boss_type'], 'required', 'message' => '{attribute} không được rỗng!'],
            ['phone', 'unique', 'targetAttribute' => 'phone', 'message' => '{attribute} này đã tồn tại trong hệ thống!'],
            ['phone', 'number', 'integerOnly' => true, 'message' => 'Số điện thoại phải là những dãy số'],
            ['phone', 'string', 'min' => 10, 'max' => 11, 'tooShort' => 'Số điện thoại phải từ 10 đến 11 số', 'tooLong' => 'Số điện thoại phải từ 10 đến 11 số!'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Email này đã tồn tại trong hệ thống!'],
        ];
    }

    public function getType() {
        return [
            self::TYPE_PERSONAL => 'Cá nhân',
            self::TYPE_COMPANY => 'Công ty'
        ];
    }

    public function attributeLabels() {
        return array(
            'name' => 'Họ và tên',
            'boss_type' => 'Đây là khách hàng',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'company_name' => 'Tên công ty',
            'company_code' => 'Mã số kinh doanh'
        );
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

    public function getDistrictList() {
        $models = District::find()->where(['city_id' => \Yii::$app->user->identity->city])->all();
        $data = [];
        if ($models) {
            foreach ($models as $value) {
                $data[(string) $value['_id']] = $value['name'];
            }
        }
        return $data;
    }

}
