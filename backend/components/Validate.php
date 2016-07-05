<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components;

use Yii;
use yii\validators\Validator;

class Validate extends Validator {

    public function validateAttribute($model, $attribute) {
        if (!preg_match('/^.{8,10}$/', $model->$attribute)) {
            $this->addError($model, $attribute, 'Mat khau must be bwtween 8 to 10 characters.');
        }
    }

}
