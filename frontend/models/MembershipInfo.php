<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\City;
use common\models\District;
use common\models\Questions;
use common\models\Category;
use common\models\Sectors;
use common\models\Language;

class MembershipInfo extends User {

    public $avatar;
    public $birthday;
    public $cmnd;
    public $address;
    public $description;
    public $city;
    public $district;
    public $name;
    public $slug;
    public $slugname;
    public $email;
    public $phone;

    public function rules() {
        return [
            [['avatar'], 'required', 'message' => 'Bạn chưa cập nhật avatar'],
            [['birthday', 'cmnd', 'address', 'description', 'city', 'district', 'name', 'email', 'phone'], 'required', 'message' => '{attribute} không được rỗng'],
	    [['slug', 'slugname', 'bankaccount'], 'string'],
            [['phone','cmnd'], 'number']
        ];
    }

    public static function getCityList($id) {
        $models = City::find()->all();
        $option ="";
        $selected = "";
        if ($models) {
            foreach ($models as $value) {
                if($value['_id'] == $id){ $selected = 'selected= "selected"';} else{ $selected = '';}
                $data = "<option value='".$value['_id']."' ".$selected.">".$value['name']."</option>";
                $option .= $data;
            }
        }
        return $option;
    }

    public static function getDistrictList($city, $id) {
        $models = District::find()->where(['city_id'=> $city])->all();
        $option ="";
        $selected = "";
        if ($models) {
            foreach ($models as $value) {
                if($value['_id'] == $id){ $selected = 'selected= "selected"';} else{ $selected = '';}
                $data = "<option value='".$value['_id']."' ".$selected.">Quận ".$value['name']."</option>";
                $option .= $data;
            }
        }
        return $option;
    }

}
