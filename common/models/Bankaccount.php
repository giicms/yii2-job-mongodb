<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

class Bankaccount extends ActiveRecord {

    public static function collectionName() {
        return 'bankaccount';
    }

    public function rules() {
        return [
            [['user_id', 'account_holder', 'bank_local', 'bank_name', 'branch_bank', 'bankaccount'], 'string'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'user_id',
            'account_holder',
            'bank_local',
            'bank_name',
            'branch_bank',
            'bankaccount',
            'created_at',
            'updated_at'
        ];
    }

    public function attributeLabels() {
        return [
            'bankaccount' => 'Số tài khoản',
            'account_holder' => 'Chủ tài khoản',
            'bank_local' => 'Tỉnh/Thành phố',
            'bank_name' => 'Tên ngân hàng',
            'branch_bank' => 'Chi nhánh ngân hàng',
        ];
    }

    public static function findBank($id) {
        return Bank::findOne((string)$id);
    }

    public static function findCity($id) {
        return City::findOne((string)$id);
    }

    public static function findBranch($id) {
        return Bankbranch::findOne((string)$id);
    }   

    public static function listbank($id){
        $banks =[];
        $data = [];
        $models = Bank::find()->all();
        foreach ($models as $bank) {
            if (in_array($id, $bank->city)) {
                $banks[] = $bank->_id;
            }
        }
        $model = Bank::find()->where(['in', '_id', $banks])->all();
        if ($model) {
            foreach ($model as $value) {
                $data[] = ['id'=>(string)$value->_id, 'name'=>$value->name, 'code'=>$value->code];
            }
        }
        return $data;
    }  

    public static function listbranch($local, $bank){
        return $model = Bankbranch::find()->where(['bank'=>(string)$bank , 'bank_local'=>(string)$local])->all();
        var_dump($model); exit;
    }  

}
