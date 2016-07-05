<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\web\Application;
use yii\base\InvalidConfigException;
use common\models\Setting;

class Settings extends Component {

    public function value($key) {
        $model = Setting::find()->where(['key' => $key])->one();
        return $model->value;
    }

    public function content($key) {
        $model = Setting::find()->where(['key' => $key])->one();
        return $model->content;
    }

}
