<?php

namespace frontend\modules\gallery\models;

use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class Crop extends Model {

    public $id;
    public $x1;
    public $y1;
    public $x2;
    public $y2;
    public $w;
    public $h;

    public function rules() {
        return [
            [['id','x1', 'x2', 'y1', 'y2', 'w', 'h'], 'integer'],
        ];
    }

}
