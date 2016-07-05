<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$labels = $this->context->labels();
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $labels['Items'], 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
$opts = Json::htmlEncode([
            'assignUrl' => Url::to(['assign', 'id' => $model->name]),
            'items' => $items
        ]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
?>
<div class="auth-item-view">
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <?php
            if (!in_array(Yii::$app->user->id, $user_id)) {
                ?>
                <?= Html::a('Update', ['update', 'id' => $model->name], ['class' => 'btn btn-primary pull-right']) ?>
                <?php
                echo Html::a('Delete', ['delete', 'id' => $model->name], [
                    'class' => 'btn btn-danger  pull-right',
                    'data-confirm' => 'Are you sure to delete this item?',
                    'data-method' => 'post',
                ]);
            }
            ?>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">


            <div class="row">
                <div class="col-sm-11">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'name',
                            'description:ntext',
                            'ruleName',
                            'data:ntext',
                        ],
                        'template' => '<tr><th style="width:25%">{label}</th><td>{value}</td></tr>'
                    ]);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <input class="form-control search" data-target="avaliable"
                           placeholder="<?= 'Search for avaliable' ?>">
                    <select multiple size="20" class="form-control list" data-target="avaliable">
                    </select>
                </div>
                <div class="col-sm-1">
                    <?php
                    if (!in_array(Yii::$app->user->id, $user_id)) {
                        ?>
                        <br><br>
                        <a href="#" class="btn btn-success btn-assign" data-action="assign">&gt;&gt;
                            <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i></a><br>
                        <a href="#" class="btn btn-danger btn-assign" data-action="remove">&lt;&lt;
                            <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i></a>
                    <?php } ?>
                </div>
                <div class="col-sm-5">
                    <input class="form-control search" data-target="assigned"
                           placeholder="<?= 'Search for assigned' ?>">
                    <select multiple size="20" class="form-control list" data-target="assigned">
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
