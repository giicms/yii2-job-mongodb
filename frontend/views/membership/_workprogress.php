<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="work-progress">
    <div class="row">  
        <div class="col-md-1 col-sm-2 col-xs-3">
            <i class="icon icon-work-progress"></i>
        </div>
        <div class="col-md-11 col-sm-10 col-xs-9">
            <div class="row">
                <div class="col-md-10 col-sm-11 col-xs-12">
                    <h4 class="text-blue">
                        <b>Thêm vào các công việc bạn đã làm </b>
                    </h4>
                </div>
                <div class="col-md-2 col-sm-1 col-xs-12">
                    <a class="btn work" title="Quá trình làm việc"><i class="fa fa-pencil"></i> Chỉnh sửa</a>
                </div>
            </div>
            <p>Cho khách hàng biết thêm kinh nghiệm làm việc của bạn </p>
        </div>
        <div class="col-md-11 col-sm-10 col-xs-12 pull-right work-list">
            <?php
            if (!empty($work)) {
                foreach ($work as $value) {
                    echo '<p>' . $value->created_begin . '-' . $value->created_end . ': ' . $value->position . ' tại ' . $value->company . '</p>';
                }
            }
            ?>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg work-progress in" id="progress" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">KINH NGHIỆM LÀM VIỆC </h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['id' => 'frmprogress', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>  
                <div class="row tb-head">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <b>Tên công ty</b>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <b>Vị trí công việc</b>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-6">
                        <b>Thời gian từ</b>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-6">
                        <b>Đến </b>
                    </div>
                </div>
                <div id="list_work" class="list-info row">
                    <?php
                    if (count($work) > 2)
                        $countwork = count($work);
                    else
                        $countwork = 2;
                    for ($i = 0; $i < 5; $i++) {

                        if ($i > $countwork)
                            $display = "none";
                        else
                            $display = "block";
                        ?>
                        <div class="row-item row row-item-work-<?= $i ?>" style="display:<?= $display ?>">
                            <input type="hidden" name ="work_id[<?= $i ?>]" value="<?= !empty($work[$i]) ? (string) $work[$i]->_id : "" ?>">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="Workprocess[company][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($work[$i]) ? $work[$i]->company : "" ?>" placeholder="<?= !empty($work[$i]->company) ? $work[$i]->company : "" ?>">
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="Workprocess[position][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($work[$i]) ? $work[$i]->position : "" ?>" placeholder="<?= !empty($work[$i]) ? $work[$i]->position : "" ?>">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6">
                                <input name="Workprocess[created_begin][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($work[$i]) ? $work[$i]->created_begin : "" ?>" placeholder="<?= !empty($work[$i]) ? $work[$i]->created_begin : "" ?>">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6">
                                <input name="Workprocess[created_end][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($work[$i]) ? $work[$i]->created_end : "" ?>" placeholder="<?= !empty($work[$i]) ? $work[$i]->created_end : "" ?>">
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="row-item field-work">
                    <a class="add-field" data-count="2" href="javascript:void(0)"><i class="fa fa-plus"></i> Thêm mới </a>
                </div>

                <div class="row-item">
                    <a href="javascript:void(0)" class="btn btn-blue submit-progress">Lưu lại</a>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>
<?=
$this->registerJs('$(document).ready(function ()
{
    $(document).on("click", ".work", function () {
        $("#progress").modal("show");
    });
});
    $(document).on("click", ".add-field", function () {
    var count =parseInt($(this).attr("data-count"))+1;   
    document.getElementsByClassName("row-item-work-"+count)[0].style.display="block";
    if(count == 4){
    $(".field-work").html("");
    } else {
    $(".field-work").html("<a class=\'add-field\' data-count="+count+" href=\'javascript:void(0)\'><i class=\'fa fa-plus\'></i> Thêm mới </a>");
    }
    });
');
?>
<?= $this->registerJs("$(document).on('click', '.submit-progress', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/workprogress"]) . "',
               type: 'post',
          data: $('form#frmprogress').serialize(),
        success: function(data) {
          if(data){
          var rs = '';
         for (i = 0; i < data.length; i++) { 
            rs += '<p>'+data[i].created_begin +'-'+data[i].created_end+': '+data[i].position+' tại '+data[i].company+'</p>';
          }
          $('.work-list').html(rs);
       $('#progress').modal('hide');          
}
        }
    });

});") ?>