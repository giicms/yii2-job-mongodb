<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

                <div class="x_content">
                    <table class="table table-bordered table-striped">
                        <tr><th style="width:10%">Tên lĩnh vực</th><td><?= $model->name ?><br><small><?= $model->category->name ?></small></td></tr>
                        <tr><th>Mô tả</th><td><?= $model->description ?></td></tr>
                        <tr><th>Skills</th><td>
                                <ul class="nav">
                                    <?php
                                    if ($model->skills) {
                                        $arr = [];
                                        foreach ($model->skills as $key => $value) {
                                            echo '<li>' . $model->getSkill($value)->name . '</li>';
                                        }
//                                    echo implode(', ', $arr);
                                    }
                                    ?>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <?= Html::a('Cập nhật', ['sector/update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                                <?=
                                Html::a('Xóa', ['sector/delete', 'id' => $model->id], [
                                    'data-confirm' => 'Bạn có muốn xóa mẫu tin này không?',
                                    'data-method' => 'GET',
                                    'class' => 'btn btn-danger'
                                        ]
                                );
                                ?>
                            </td>
                        </tr>
                    </table>

                </div>

            </div>

        </div>
    </div>

</div>
</div>