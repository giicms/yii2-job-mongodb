<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Thêm mới danh mục';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý danh mục', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $this->title ?></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <?php
                $form = ActiveForm::begin([
                            'layout' => 'horizontal',
                            'fieldConfig' => [
                                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                                'horizontalCssClasses' => [
                                    'label' => 'col-sm-3',
                                    'offset' => 'col-sm-offset-3',
                                    'wrapper' => ' col-md-6 col-sm-9 col-xs-12',
                                    'error' => '',
                                    'hint' => '',
                                ],
                            ],
                ]);
                ?>  
                <?=
                $this->render('_form', [
                    'model' => $model,
                    'form' => $form
                ])
                ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>