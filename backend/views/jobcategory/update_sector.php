<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Menu;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Cập nhật lĩnh vực: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh mục', 'url' => ['/jobcategory/index']];
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

                <div class="x_content">
                    <?= $this->render('_formsector', ['model' => $model, 'skills' => $skills]) ?>
                </div>

            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách yêu cầu</h2>
                    <?php
                    echo Menu::widget([
                        'items' => [['label' => 'Thêm mới', 'template' => '<a href="{url}" class="btn-success">{label}</a>', 'url' => ['/sectoroption/create', 'id' => $model->id], 'visible' => \Yii::$app->user->can('/sectoroption/create')]
                        ],
                        'options' => [ 'class' => 'nav navbar-right panel_toolbox'],
                    ]);
                    ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                    GridView::widget([
                        'id' => 'sectoroption',
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'columns' => [

                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'name',
                                'format' => 'html',
                                'value' => function ($data)
                                {

                                    return $data->name;
                                },
                            ],
                            [
                                'label' => 'Yêu cầu',
                                'format' => 'html',
                                'value' => function ($data)
                                {
                                    $options = $data->options;
                                    $html = '';
                                    if (!empty($options))
                                    {
                                        foreach ($options as $value)
                                        {
                                            $html .= $value . '<br>';
                                        }
                                    }
                                    return $html;
                                },
                            ],
                            [
                                'class' => 'backend\components\columns\ActionColumn',
                                'template' => '{update} {delete} {trash}',
                                'buttons' => [
                                    'update' => function ($url, $model, $key)
                                    {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/sectoroption/update', 'id' => $key]);
                                    },
                                            'delete' => function ($url, $model, $key)
                                    {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/sectoroption/delete', 'id' => $key]);
                                    },
                                        ],
                                    ],
                                ],
                                'tableOptions' => ['class' => 'table table-striped responsive-utilities jambo_table bulk_action'],
                            ]);
                            ?>

                </div>
            </div>
        </div>

    </div>
</div>