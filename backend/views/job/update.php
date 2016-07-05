<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\job */

$this->title = 'Cập nhật: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Công việc', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => (string) $model->_id]];
$this->params['breadcrumbs'][] = 'Cập nhật';
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
                    <?= $this->render('_form', ['model' => $model, 'options' => $options, 'district' => $district, 'budget' => $budget]) ?>
                </div>

            </div>
        </div>

    </div>
</div>
