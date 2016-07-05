<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\City;
use common\models\Questions;
use common\models\Category;
use common\models\Sectors;
use common\models\Language;

class Profile extends User {

    public $avatar;
    public $birthday;
    public $cmnd;
    public $address;
    public $description;
    public $language;
    public $language_level;
    public $district;

    public function rules() {
        return [
            [['avatar'], 'required', 'message' => 'Bạn chưa cập nhật avatar'],
            [['birthday', 'cmnd', 'address', 'description', 'city', 'district'], 'required', 'message' => '{attribute} không được rỗng'],
            ['language', 'default']
        ];
    }

    public function getLanguageList() {
        $models = Language::find()->all();
        if ($models) {
            foreach ($models as $value) {
                $data[(string) $value['_id']] = $value['name'];
            }
        }
        return $data;
    }

    public function getCityList() {
        $models = City::find()->all();
        if ($models) {
            foreach ($models as $value) {
                $data[(string) $value['_id']] = $value['name'];
            }
        }
        return $data;
    }


}
