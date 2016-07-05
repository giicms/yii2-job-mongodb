<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Thêm mới account';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý account', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Thêm mới';
?>
<div class="account-create">
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

                    <?=
                    $this->render('_form', [
                        'model' => $model,
                        'child' => $child,
                        'ga' => $ga
                    ])
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>