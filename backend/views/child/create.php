
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Cập nhập quyền cho ' . $item;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý vai trò', 'url' => ['index']];
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
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <?php

                                function category($data = array(), $item, $indent = 0, $parent = 'NULL') {
                                    foreach ($data as $key => $value) {
                                        if ($value->parent == $parent) {
                                            unset($data[$key]);
                                            $exit = $value->getExit($item, $value->name);
                                            if ($value->parent == 'NULL') {
                                                ?>

                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="checkbox">


                                                        <?php
                                                        if ($value->type == 1) {
                                                            ?>
                                                            <label> <input type="checkbox" <?= !empty($exit) ? "checked" : "" ?> value="<?= $value->name ?>" name="child[]"> <?= $value->name ?> </label>
                                                            <?php
                                                        } else {
                                                            echo '<strong>' . $value->description . '</strong>';
                                                        }
                                                        ?>


                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="col-md-2 col-sm-4 col-xs-12">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" <?= !empty($exit) ? "checked" : "" ?> value="<?= $value->name ?>" name="child[]"> <?= $value->name ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            category($data, $item, $indent + 1, $value->id);
                                        }
                                    }
                                }

                                category($authitem, $item);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>