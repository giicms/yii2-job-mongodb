<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\db\Query;
use yii\widgets\Menu;
use common\models\User;

class ActionWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        $controller = Yii::$app->controller->id;
        echo Menu::widget([
            'items' => [
                ['label' => '<span class="glyphicon glyphicon-eye-open"></span>', 'url' => ['view', 'id' => (string) $this->id], 'visible' => \Yii::$app->user->can('/' . $controller . '/view')],
                ['label' => '<span class="glyphicon glyphicon-pencil"></span>', 'url' => ['update', 'id' => (string) $this->id], 'visible' => \Yii::$app->user->can('/' . $controller . '/update')],
                ['label' => '<span class="glyphicon glyphicon-trash"></span>', 'template' => '<a href="{url}" data-confirm="Bạn có muốn xóa mẫu tin này không?">{label}</a>', 'url' => ['delete', 'id' => (string) $this->id], 'visible' => \Yii::$app->user->can('/' . $controller . '/delete')],
            ],
            'encodeLabels' => false,
            'options' => ['class' => 'nav navbar-right panel_toolbox'],
        ]);
    }

}
