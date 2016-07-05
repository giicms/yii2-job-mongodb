<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\components;

use Yii;
use yii\base\Component;
use yii\web\Application;
use yii\base\InvalidConfigException;
use common\models\User;
use common\models\Setting;

class Info extends Component {

    public function isBoss() {
        if (Yii::$app->user->identity->role == User::ROLE_BOSS)
            return TRUE;
        else
            return FALSE;
    }

    public function setting($key) {
        $model = Setting::find()->where(['key' => $key])->one();
        return $model->value;
    }

}
