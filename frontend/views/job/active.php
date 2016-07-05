
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $model->name;
?>
<section>
    <div class="introduce published_work">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-container">
                        <h3>Đăng việc thành công! Công việc của bạn đã được gởi.</h3>
                        <p class="alert-boss">Công việc của bạn sẽ được hiển thị trong trang tìm kiếm công việc, khoản 20 phút sao khi đăng.</p>
                    </div>
                </div>
                <!-- introduce item -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="container-content">
                        <h4 class="text-blue"><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $model->slug . '/' . (string) $model->_id) ?>" title="<?= $model->name ?>"><strong><?= $model->name ?></strong></a><small> - Đăng cách đây <?= Yii::$app->convert->time($model->created_at) ?></small></h4>
                        <p><span class="text_gray"><?= $model->category->name ?> - <?= $model->sector->name ?></span></p>
                        <p><?php
                            echo '<b>Ngân sách dự án: </b>' . $model->budget ;
                            ?></p>
                        <?php
                        foreach ($model->options as $option)
                        {
                            if (!empty($option['other']))
                                $other = ',' . $option['other'];
                            else
                                $other = '';
                            echo '<p><b>' . $option['name'] . ':</b> ' . trim($option['option'] . $other, ',') . '</p>';
                        }
                        ?>
                        <p><b>Nội dung công việc:</b></p>
                        <p><?= nl2br($model->description) ?></p>

                    </div>
                    <div class="container-content suggest">
                        <p class="pull-left"><b>Gợi ý các nhân viên tốt nhất cho công việc của bạn - 
                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $model->slug . '/' . (string) $model->_id) ?>" title="<?= $model->name ?>"><?= $model->name ?></a></b></p>
                        <a href="#" class="pull-right btn btn-square invitation"  data-toggle="modal" data-target="#modal" title="Mời tất cả nộp hồ sơ">Mời tất cả nộp hồ sơ</a>
                    </div>
                </div>    
                <?php
                if (!empty($users))
                {
                    foreach ($users as $value)
                    {
                        ?>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="user-item">
                                <img class="img-circle" src="<?= Yii::$app->params['url_file'] ?>thumbnails/<?= !empty($value->avatar) ? '60-' . $value->avatar : "avatar.png" ?>"/>
                                <div class="user-content">
                                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $value->slug) ?>"><?= $value->name; ?></a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Mời tất cả nộp hồ sơ</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['id' => 'formInvited', 'options' => ['class' => 'form-horizontal']]); ?>  
                <div class="form-group">
                    <label class="col-sm-4">Tiêu đề công việc</label>
                    <div class="col-sm-8">
                        <strong><?= $model['name'] ?></strong>
                        <input type="hidden" name="JobInvited[job_id]" value="<?= (string) $model['_id'] ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4">Nhân viên</label>
                    <div class="col-sm-8">

                        <select name="JobInvited[actor][]" id="jobinvited-actor" style="width:100%" class="form-control select2" multiple>
                            <?php
                            if (!empty($users))
                            {
                                foreach ($users as $value)
                                {
                                    ?>
                                    <option selected value="<?= (string) $value['_id'] ?>"><?= $value->name ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <?= $form->field($invited, 'message', ['template' => '<label class="col-md-4 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-8 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textarea() ?>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button id="submitInvited" type="submit" class="btn btn-default btn-boss">Mời nhận việc</button>
                        <a href="#"  data-dismiss="modal" class="alert"><strong>Hủy</strong></a>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

<?= $this->registerJs("$(document).on('submit', '#formInvited', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["job/jobinvited"]) . "',
               type: 'post',
          data: $('form#formInvited').serialize(),
        success: function(data, status) {
          if(data){
       $('#modal').modal('hide');          
}
        }
    });

});

") ?>
<?=
$this->registerJs("$('#jobinvited-actor').select2({
    maximumSelectionSize: 10
});")?>