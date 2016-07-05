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
use common\models\User;

class Info extends Component {

    public function isBoss() {
        $user = User::findOne(\Yii::$app->user->id);
        if ($user->role == User::ROLE_BOSS)
            return TRUE;
        else
            return FALSE;
    }

}
