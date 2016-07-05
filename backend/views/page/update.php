<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Cập nhật: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh mục', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name
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
                <div class="x_title">
                    <h2>Cập nhật</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>     
                            <?= Html::a('Xem chi tiết', ['view', 'id' => (string) $model->_id], ['class' => 'btn btn-primary']) ?>
                        </li>
                        <li>            <?=
                            Html::a('Xóa', ['delete', 'id' => (string) $model->_id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Bạn có muốn xóa mẫu tin này không?',
                                    'method' => 'post',
                                ],
                            ])
                            ?></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                    $this->render('_form', [
                        'model' => $model,
                    ])
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>