<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Account;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý quyền';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ ROUTE
                <!-- <small>
                    Some examples to get you started
                </small> -->
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách route</h2>
           
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="row">
                        <div class="col-lg-5">
                            <?php
                            echo Html::listBox('routes', '', $new, [
                                'id' => 'new',
                                'multiple' => true,
                                'size' => 40,
                                'style' => 'width:100%']);
                            ?>
                        </div>
                        <div class="col-lg-1">
                            &nbsp;<br><br>
                            <?php
                            echo Html::a('>>', '#', ['class' => 'btn btn-success', 'data-action' => 'assign']) . '<br>';
                            echo Html::a('<<', '#', ['class' => 'btn btn-success', 'data-action' => 'delete']) . '<br>';
                            ?>
                        </div>
                        <div class="col-lg-5">
                            <?php
                            echo Html::listBox('routes', '', $exists, [
                                'id' => 'exists',
                                'multiple' => true,
                                'size' => 40,
                                'style' => 'width:100%',
                                'options' => $existsOptions]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->render('_script');
