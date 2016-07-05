<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="work-progress">
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
                    <a class="btn modalWorkdone"><i class="fa fa-plus"></i> Thêm mới </a>
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
                        <div class="col-md-4 col-sm-4 col-xs-12" id="workdone_<?= $value->id ?>">
                            <h4><?= $value->name ?></h4>
                            <p><?= $value->description ?></p>
                            <?php
                            if (!empty($value->files)) {
                                foreach ($value->files as $file) {
                                    echo '<a class="fancybox" href="' . \Yii::$app->params['url_file'] . $file . '" data-fancybox-group="gallery"><img class="img-rounded" style="width:60px;" src="' . \Yii::$app->params['url_file'] . 'thumbnails/' . $file . '"></a>';
                                }
                            }
                            ?>
                            <div>
                                <a class="modalWorkdone" href="javascript:void(0)" data-id="<?= $value->id ?>"><i class="fa fa-pencil-square-o"></i></a>
                                <a class="deleteWorkdone" href="javascript:void(0)" data-id="<?= $value->id ?>"><i class="fa fa-trash"></i></a>
                            </div>
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
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                <h4 class="modal-title">DỰ ÁN ĐÃ THỰC HIỆN </h4>
            </div>
            <div class="modal-body">
                <div class="modal-alert"></div>
                <?php $form = ActiveForm::begin(['id' => 'frmworkdone', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>  
                <?= $form->field($newworkdone, 'id')->hiddenInput()->label(FALSE) ?>
                <?= $form->field($newworkdone, 'name', ['template' => '<label class="col-md-4 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-8 col-sm-8 col-xs-12">{input}{hint}{error}</div>']) ?>

                <?= $form->field($newworkdone, 'description', ['template' => '<label class="col-md-4 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-8 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textarea() ?>

                <?= $form->field($newworkdone, 'link', ['template' => '<label class="col-md-4 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-8 col-sm-8 col-xs-12">{input}{hint}{error}</div>']) ?>
                <div class="row-item">
                    <label for="exampleInputFile">Thêm hình ảnh cho các dự án đã thực hiện </label>
                    <div class="uploadProject"><a class="btn btn-success" style="padding:6px 20px;"><i class="fa fa-upload"></i></a></div>
                    <div class="loading-img"></div>
                </div>
                <div class="row-item img-project">

                </div>

                <div class="row-item">
                    <a href="javascript:void(0)" class="submit-project btn btn-blue" style="padding:6px 12px; margin: 0 15px 0 0 !important">Lưu và tiếp tục</a>
                    <a href="javascript:void(0)" class="btn btn-danger modalWorkdone-cancel">Đóng</a>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>
<?=
$this->registerJs("$('.modalWorkdone').click(function(event) {
        event.preventDefault();
        var id = $(this).attr('data-id');
        if(id){
        $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/workdone"]) . "',
            type: 'post',
            data: {id:id},
            success: function(data) {
              $('#modalWorkdone').modal('show');
                   if(data){
                    var img = '';
                      for (i = 0; i < data.files.length; i++) { 
            img += '<div class=\"col-md-3 col-sm-3 col-xs-4 img_'+i+'\"><img class=\"img-rounded\" style=\"width:100px\" src=" . Yii::$app->params['url_file'] . 'thumbnails/' . "'+data.files[i]+'> <input type=\"hidden\" name=\"img[]\" value='+data.files[i]+'> <a class=\deleteFile\ href=\javascript:void(0)\ data-img='+data.files[i]+' id='+i+'>Xóa</a></div>';
          }
                    $('#modalWorkdone').find('.modal-body input#workdone-id').val(data.id);
                    $('#modalWorkdone').find('.modal-body input#workdone-name').val(data.name);
                    $('#modalWorkdone').find('.modal-body textarea#workdone-description').val(data.description);
                    $('#modalWorkdone').find('.modal-body input#workdone-link').val(data.link);
                    $('.img-project').html(img);
               }
            }
        });
} else {
           $('#modalWorkdone').modal({
                   show: true,
                   backdrop: 'static',
                   keyboard: false
    });  
}
});
$('.fancybox').fancybox();
");
?>
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
            $(".loading-img").html("Đang tải...");
        },

             onSuccess: function (files, data, xhr)
        {
                    $(".loading-img").html("");
            $.each(data, function (index, value) {
               $(".img-project").append("<div class=\"col-md-4 col-sm-4 col-xs-12 img_"+value[0].id+"\"><img class=\"img-rounded\"  style=\"width:100px\" src="+value[0].url+"> <input type=\"hidden\" name=\"img[]\" value="+value[0].name+"> <a class=\deleteFile\ href=\javascript:void(0)\ data-img="+value[0].name+" id="+value[0].id+">Xóa</a></div>");
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
        var id =$(this).attr("id");
        if(comfirm){
          $.ajax({
                url:"' . Yii::$app->urlManager->createUrl(["upload/remove"]) . '",
                type:"POST",            
                data:"file="+$(this).attr("data-img"),
                dataType:"json",
                success:function(data){     
                           if(data=="ok"){
                            $(".img_"+id).remove();
                           }
                    }
            });   
        }
    });
    
$(document).on("click", ".deleteWorkdone", function () {
        var comfirm = confirm("Bạn có muốn xóa cái dự án này không");
        var id =$(this).attr("data-id");
        if(comfirm){
          $.ajax({
                url:"' . Yii::$app->urlManager->createUrl(["ajax/deleteworkdone"]) . '",
                type:"POST",            
                data:{id:id},
                dataType:"json",
                success:function(data){     
                           if(data==1){
                            $("#workdone_"+id).remove();
                           }
                    }
            });   
        }
    });

})');
?>


<?= $this->registerJs("$(document).on('click', '.submit-project', function (event){
        event.preventDefault();
        var id = $('#workdone-id').val();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/workdone"]) . "',
               type: 'post',
          data: $('form#frmworkdone').serialize(),
        success: function(data) {
          if(data){
          var rs = '';
         for (i = 0; i < data.length; i++) { 
            rs += '<p>'+data[i].name +'</p>';
          }
//          $('.workdone-list').html(rs);
                if(!id){
                 $('.img-project').html('');
                 $('.modal-alert').html('<p class=\"alert alert-success\">Bạn đã thêm mới thành công</p>');
                 } else {
                      $('.modal-alert').html('<p class=\"alert alert-success\">Bạn đã cập nhật thành công</p>');
                }
                      $('#workdone-name').val();
                      $('#workdone-description').val();
                      $('#workdone-name').val();  
                
}
        }
    });

});

$('.modalWorkdone-cancel').click(function() {
     window.location.href = '" . $_SERVER['REQUEST_URI'] . "';
})
") ?>
