<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Thêm mới bài test';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý bài test', 'url' => ['index']];
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
                <div class="x_content">
                    <?= $this->render('_form', ['model' => $model]) ?>
                </div>
            </div>

        </div>
    </div>
</div>
<?=
$this->registerJs('
$("#testquestion-category").select2({
      placeholder: "Danh mục ngành nghề",
    maximumSelectionSize: 10
});

');
?>
