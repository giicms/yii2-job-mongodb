<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->name;
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
                    <h2>Chi tiết</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>     
                            <?= Html::a('Cập nhật', ['update', 'id' => (string) $model->_id], ['class' => 'btn btn-primary']) ?>
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
                    DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th width="15%">{label}</th><td>{value}</td></tr>',
                        'attributes' => [
                            'name',
                            'slug',
                            'description',
                            'content:html',
                            [
                                'attribute' => 'thumbnail',
                                'format' => ['html'],
                                'value' => (!empty($model->thumbnail)) ? '<img height="100" src="'. $model->thumbnail .'">' : ""
                            ],
                            [
                                'attribute' => 'category_id',
                                'value' => $model->category->name,
                            ],
                            'view',
                            [
                                'attribute' => 'created_at',
                                'value' => date('d/m/Y', $model->created_at),
                            ],
                            [
                                'attribute' => 'updated_at',
                                'value' => date('d/m/Y', $model->updated_at),
                            ],
                        ],
                    ])
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>