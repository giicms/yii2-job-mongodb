<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý role', 'url' => ['index']];
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
                <div class="x_title">
                    <h2>Chi tiết</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>     
                            <?= Html::a('Cập nhật', ['update', 'id' => (string) $model->name], ['class' => 'btn btn-primary']) ?>
                        </li>
                        <li>            <?=
                            Html::a('Xóa', ['delete', 'id' => (string) $model->name], [
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
                    <?php
                    echo DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'name',
                            'description:ntext',
                            'ruleName',
                            'data:ntext',
                        ],
                    ]);
                    ?>


                </div>
                <div class="row">
                    <div class="x_content">
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <?=
                            Html::listBox('roles', '', $avaliable, [
                                'id' => 'avaliable',
                                'multiple' => true,
                                'size' => 30,
                                'style' => 'width:100%']);
                            ?>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <div style="text-align: center">
                                <?php
                                echo Html::a('>>', '#', ['class' => 'btn btn-success', 'data-action' => 'assign']) . '<br>';
                                echo Html::a('<<', '#', ['class' => 'btn btn-success', 'data-action' => 'delete']) . '<br>';
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <?=
                            Html::listBox('roles', '', $assigned, [
                                'id' => 'assigned',
                                'multiple' => true,
                                'size' => 30,
                                'style' => 'width:100%']);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<?php
$this->render('_script', ['name' => $model->name]);
