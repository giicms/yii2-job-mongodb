<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Menu;

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
                    <?php
                    echo Menu::widget([
                        'items' => [
                            ['label' => 'Xem', 'template' => '<a href="{url}" class="btn-primary">{label}</a>', 'url' => ['post/view', 'id' => $model->id], 'visible' => \Yii::$app->user->can('/category/index')],
                            [
                                'label' => 'Xóa',
                                'template' => '<a href="{url}" class="btn-danger" data-confirm="Bạn có muốn xóa mẫu tin này không?">{label}</a>',
                                'url' => ['category/dele', 'id' => $model->id],
                                'visible' => \Yii::$app->user->can('/category/index')
                            ],
                        ],
                        'options' => ['class' => 'nav navbar-right panel_toolbox'],
                    ]);
                    ?>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">


                    <?=
                    $this->render('_form_edit', [
                        'model' => $model
                    ])
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>