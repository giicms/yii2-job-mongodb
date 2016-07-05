<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="modal fade" id="invited" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Mời nhận việc</h4>
            </div>
            <div class="modal-body">
                <?php
                if (!empty($job)) {
                    ?>
                    <?php $form = ActiveForm::begin(['id' => 'formInvited', 'options' => ['class' => 'form-horizontal']]); ?>  
                    <div class="form-group">
                        <label class="col-sm-3">Nhân viên</label>
                        <div class="col-sm-9">
                            <strong class="actor-name"></strong>
                            <input type="hidden" id="jobinvited-actor" name="JobInvited[actor]" value="">
                        </div>
                    </div>


                    <?= $form->field($invited, 'message', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label" style="text-align:left">{label}</label><div  class="col-md-9 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textarea() ?>
                    <div class="form-group">
                        <label class="col-sm-3">Chọn công việc</label>
                        <div class="col-sm-4">Từ công việc đã đăng</div>
                        <div class="col-sm-5">
                            <div class="select">
                                <select name="JobInvited[job_id]" id="jobinvited-job_id" style="width:100%" class="form-control">
                                    <?php
                                    foreach ($job as $value) {
                                        ?>
                                        <option selected value="<?= (string) $value['_id'] ?>"><?= $value->name ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-8">
                            <button id="submitInvited" type="submit" class="btn btn-default btn-boss">Mời nhận việc</button>
                            <a href="#"  data-dismiss="modal" class="alert"><strong>Hủy</strong></a>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                    <?php
                } else {
                    echo 'Bạn chưa có công việc nào trong hệ thống!';
                }
                ?>
            </div>
        </div>
    </div>
</div>