<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Bank;

/**
 * Boss model
 *
 * @property string $actor
 * @property string $ower
 * @property string $job
 */
class Bankbranch extends ActiveRecord {

    const PUBLISH_ACTIVE = 1; //hiên thị
    const PUBLISH_NONE = 2; //khong hien thi

    public static function collectionName() {
        return 'branch_bank';
    }

    public function rules() {
        return [
            [['bank_local', 'bank', 'name'], 'required', 'message'=> '{attribute} không được rỗng']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'bank_local',
            'bank',
            'name',
            'publish',
            'created_at',
            'updated_at'
        ];
    }

    public function attributeLabels() {
        return [
            'bank_local' => 'Địa điểm',
            'bank' => 'Ngân hàng',
            'name' => 'Tên chi nhánh',
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

    public function getBankList(){
        $models = Bank::find()->all();
        $data = [];
        if ($models) {
            foreach ($models as $value) {
                $data[$value->id] = $value->name;
            }
        }
        return $data;
    }

    public static function getCityid($id){
        $model = City::findOne((string)$id);    
        return $model->name;
    }

    public static function getBankid($id){
        $model = Bank::findOne((string)$id);    
        return $model['name'].' ('.$model['code'].')';
    }

    


}
