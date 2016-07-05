<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components\widgets;
use Yii;
use yii\base\Widget;
use common\models\Online;
use common\models\Onlinedaily;
use common\models\User;
use yii\db\Query;

class OnlinedailyWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        $timexpired = 300;
        $timeout = time() - $timexpired;
        $model = Online::find()->where(['between', 'time', 10, $timeout-1])->all();
        if(!empty($model)){
            foreach ($model as $key => $value) {
                $del = Online::findOne($value['_id']);
                $del->delete();
            }
        }

        $online = Online::find()->where(['ip'=> $_SERVER['REMOTE_ADDR']])->one();
        if(!empty($online)){
            $online->time = time();
            $online->site = $_SERVER['REQUEST_URI'];
            $online->agent = $_SERVER['HTTP_USER_AGENT'];
            $online->save();
        }else{
            $online = new Online();
            $online->ip = $_SERVER['REMOTE_ADDR'];
            $online->site = $_SERVER['REQUEST_URI'];
            $online->agent = $_SERVER['HTTP_USER_AGENT'];
            $online->time = time();
            if( $online->save() ) {
                $daily = Onlinedaily::find()->where(['day'=> (string)date('m-d-Y')])->one();
                // var_dump($daily); exit;
                if(!empty($daily)){
                    $daily->counter = $daily->counter +1;
                    if(!Yii::$app->user->isGuest){
                        if (\Yii::$app->user->identity->role == User::ROLE_BOSS) {
                            $daily->boss = $daily->boss +1;
                        }elseif (\Yii::$app->user->identity->role == User::ROLE_MEMBER) {
                            $daily->member = $daily->member +1;
                        }
                    }
                    $daily->save(); 
                }else{
                    $daily = new Onlinedaily();
                    $daily->day = date('m-d-Y');
                    $daily->created_at = strtotime(date('d-m-Y'));
                    $daily->counter = 1;
                    if(!Yii::$app->user->isGuest){
                        if (\Yii::$app->user->identity->role == User::ROLE_BOSS) {
                            $daily->boss = 1;
                            $daily->member = 0;
                        }elseif (\Yii::$app->user->identity->role == User::ROLE_MEMBER) {
                            $daily->member = 1;
                            $daily->boss = 0;
                        }
                    }else{
                        $daily->member = 0;
                        $daily->boss = 0;
                    }
                    $daily->save(); 
                }
            }
        }
    }
}
