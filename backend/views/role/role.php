
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Thêm mới permission';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý permission', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Thêm mới';
?>
<div class="account-create">
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
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>  
                    <?= $form->field($model, 'parent', ['template' => '<label class="col-md-2 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->dropDownList($parent); ?>
                    <div class="form-group">
                        <label class="col-md-2 col-sm-4 col-xs-12 control-label">Childs</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="row">
                                <?php

                                function category($data = array(), $indent = 0, $parent = 'NULL') {
                                    foreach ($data as $key => $value) {
                                        if ($value->parent == $parent) {
                                            unset($data[$key]);
                                            if ($value->parent == 'NULL') {
                                                ?>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="<?= $value->name ?>" name="child[]"> <?= $value->name ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="col-md-2 col-sm-4 col-xs-12">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox"> <?= $value->name ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            category($data, $indent + 1, $value->id);
                                        }
                                    }
                                }

                                category($auth);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-4">
                            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>