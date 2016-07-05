<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\City;

/**
 * Boss model
 *
 * @property string $actor
 * @property string $ower
 * @property string $job
 */
class Bank extends ActiveRecord {

    const PUBLISH_ACTIVE = 1; //hiên thị
    const PUBLISH_NONE = 2; //khong hien thi

    public static function collectionName() {
        return 'bank';
    }

    public function rules() {
        return [
            [['name', 'code', 'city'], 'required', 'message' => '{attribute} không được rỗng'],
            [['slug', 'name'], 'string'],
            [['created_at', 'updated_at', 'publish'], 'integer']
        ];
    }

    
    public function attributes() {
        return [
            '_id',
            'name',
            'code',
            'city',
            'slug',
            'publish',
            'created_at',
            'updated_at'
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Tên ngân hàng',
            'code' => 'Tên giao dịch',
            'city' => 'Địa điểm',
            'publish' => 'Hiển thị'
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function getCityList(){
        $models = City::find()->all();
        $data = [];
        if ($models) {
            foreach ($models as $value) {
                $data[$value->id] = $value->name;
            }
        }
        return $data;
    }

    public function getCityid(){
        $model = Bank::findOne($this->_id);
        $cities ='';
        if(!empty($model->city)){        
            foreach ($model->city as $value) {
                $city = City::findOne($value);
                $cities.= $city->name.'<br>';
            }
        }
        return $cities;
    }
}
