<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<h4 class="title-box">Các dự án của bạn</h4>
<div class="work-progress well">
    <div class="row">  
        <div class="col-md-1 col-sm-2 col-xs-3">
            <i class="icon icon-workdone-progress"></i>
        </div>
        <div class="col-md-11 col-sm-10 col-xs-9">
            <div class="row">
                <div class="col-md-10 col-sm-11 col-xs-12">
                    <h4 class="text-blue">
                        <b>Các dự án đã thực hiện </b>
                    </h4>
                </div>
                <div class="col-md-2 col-sm-1 col-xs-12">
                    <a class="btn" data-toggle="modal" data-target="#modalWorkdone"><i class="fa fa-plus"></i> Thêm mới </a>
                </div>
            </div>
            <p>Thêm các dự án tiêu biểu của bạn đã làm để khách hàng có thể đánh giá năng lực của bạn</p>  
        </div>
        <div class="col-md-11 col-sm-10 col-xs-12 pull-right">
            <div class="row  workdone-list">
                <?php
                if (!empty($workdone)) {
                    foreach ($workdone as $value) {
                        ?>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <h4><?= $value->name ?></h4>
                            <p><?= $value->description ?></p>
                            <?php
                            if (!empty($value->files)) {
                                foreach ($value->files as $value) {
                                    echo '<img class="img-rounded" style="width:60px;" src="' . \Yii::$app->params['url_file'] . 'thumbnails/' . $value . '">';
                                }
                            }
                            ?>

                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg in" id="modalWorkdone" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DỰ ÁN ĐÃ THỰC HIỆN </h4>
            </div>
            <div class="modal-body">
                <div class="modal-alert"></div>
                <?php $form = ActiveForm::begin(['id' => 'formworkdone', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>  
                <!--                <div class="row tb-head">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <b>Tên dự án</b>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <b>Mô tả ngắn </b>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <b>Link dự án</b>
                                    </div>
                                </div>-->

                <?= $form->field($model, 'name', ['template' => '<label class="col-md-4 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-8 col-sm-8 col-xs-12">{input}{hint}{error}</div>']) ?>

                <?= $form->field($model, 'description', ['template' => '<label class="col-md-4 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-8 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textarea() ?>

                <?= $form->field($model, 'link', ['template' => '<label class="col-md-4 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-8 col-sm-8 col-xs-12">{input}{hint}{error}</div>']) ?>

                <!--    <div class="row-item field-workdone">
                        <a class="add-field" data="2" href="javascript:void(0)"><i class="fa fa-plus"></i> Thêm mới </a>
                    </div>-->
                <div class="row-item">
                    <label for="exampleInputFile">Thêm hình ảnh cho các dự án đã thực hiện </label>
                    <div class="uploadProject">Chọn file...</div>
                </div>
                <div class="row-item img-project">

                </div>

                <div class="row-item">
                    <button type="submit" class="btn btn-blue">Lưu và tiếp tục</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>
<?=
$this->registerJs('$(document).ready(function ()
{
    var upload = {
        url: "' . Yii::$app->urlManager->createUrl(["upload/image"]) . '",
        method: "POST",
        allowedTypes: "jpg,png,jpeg,gif",
        fileName: "myfile",
        multiple: true,
        onBeforeSend: function () {
            $(".loading").html("Đang tải");
        },

             onSuccess: function (files, data, xhr)
        {
            $.each(data, function (index, value) {
               $(".img-project").append("<div class=\"col-md-4 col-sm-4 col-xs-12\"><img class=\"img-rounded\" src="+value[0].url+"> <input type=\"hidden\" name=\"img[]\" value="+value[0].name+"> <a class=\deleteFile\ href=\javascript:void(0)\ >Xóa</a></div>");
            });
        },
        onError: function (files, status, errMsg)
        {
            $(".img-project").html("Không đúng định dạng hoặc size quá lớn");
        }
    };
        $(".uploadProject").uploadFile(upload);
        
    $(document).on("click", ".deleteFile", function () {
        var comfirm = confirm("Bạn có muốn xóa cái file không");
        if(comfirm){
          $.ajax({
                url:"' . Yii::$app->urlManager->createUrl(["upload/remove"]) . '",
                type:"POST",            
                data:"file="+$("#job-file").val(),
                dataType:"json",
                success:function(data){     
                           if(data=="ok"){
                           $(".resultFile").html("");
                              $("#job-file").val("");
                           }
                    }
            });   
        }
    });

})');
?>


