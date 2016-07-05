<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\job */

$this->title = 'Thêm công việc mới';
$this->params['breadcrumbs'][] = ['label' => 'Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="job-create">
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
                    <?= $this->render('_form', ['model' => $model, 'options' => $options]) ?>
                </div>

            </div>
        </div>

    </div>
</div>
