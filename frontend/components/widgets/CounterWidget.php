<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components\widgets;

use yii\base\Widget;
use common\models\Counter;
use common\models\Onlinedaily;
use yii\db\Query;

class CounterWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        $time_now = time();    // lưu thời gian hiện tại
        $time_out = 900; // khoảng thời gian chờ để tính một kết nối mới (tính bằng ms)
        $ip_address = \Yii::$app->params['ip'];    // lưu lại IP của kết nối

        $time = $time_now - $time_out;
        $model = Counter::find()->where(['ip_address' => $ip_address])->one();
        if (!empty($model)) {
            if ($model->updated_at <= $time) {
                $model->last_visit = $time_now;
                $model->updated_at = $time_now;
                $model->hit = $model->hit + 1;
                $model->save();
            }
        } else {
            $counter = new Counter();
            $counter->ip_address = $ip_address;
            $counter->last_visit = $time_now;
            $counter->hit = 1;
            $counter->save();
        }
		
		
    }

}
