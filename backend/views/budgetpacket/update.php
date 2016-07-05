<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\BudgetPrice;

/* @var $this yii\web\View */
/* @var $model common\models\Skills */

$this->title = 'Cập nhật gói';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý gói', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Cập nhật';
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
                <div class="x_content">
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
                    echo $this->render('_form', ['form' => $form, 'model' => $model])
                    ?>  
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-3 col-sm-6 col-xs-12">
                            <?= Html::submitButton( 'Cập nhật', ['class' =>  'btn btn-success']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>