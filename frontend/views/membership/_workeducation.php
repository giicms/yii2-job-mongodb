<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="work-progress">
    <div class="row">  
        <div class="col-md-1 col-sm-2 col-xs-3">
            <i class="icon icon-education-progress"></i>
        </div>
        <div class="col-md-11 col-sm-10 col-xs-9">
            <div class="row">
                <div class="col-md-10 col-sm-11 col-xs-12">
                    <h4 class="text-blue">
                        <b>Bạn đã học ở đâu? </b>
                    </h4>
                </div>
                <div class="col-md-2 col-sm-1 col-xs-12">
                    <a href="javascript:void(0)" class="btn eduacation"  title="Bạn đã học ở đâu"><i class="fa fa-pencil"></i> Chỉnh sửa</a>
                </div>
            </div>
            <p>Cho khách hàng biết thêm học vấn của bạn </p>
        </div>
        <div class="col-md-11 col-sm-10 col-xs-12 pull-right education-list">
            <?php
            if (!empty($education)) {
                foreach ($education as $value) {
                    echo '<p>' . $value->created_begin . '-' . $value->created_end . ': ' . $value->course . ' tại ' . $value->school . '</p>';
                }
            }
            ?>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg work-eduacation in" id="eduacation" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">TRÌNH ĐỘ HỌC VẤN </h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['id' => 'frmeducation', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>  
                <div class="row tb-head">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <b>Tên trường</b>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <b>Ngành học</b>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-6">
                        <b>Thời gian từ</b>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-6">
                        <b>Đến </b>
                    </div>
                </div>
                <div id="list_education" class="list-info row">
                    <?php
                    if (count($education) > 2)
                        $counteducation = count($education);
                    else
                        $counteducation = 2;
                    for ($i = 0; $i < 5; $i++) {

                        if ($i > $counteducation)
                            $display = "none";
                        else
                            $display = "block";
                        ?>
                        <div class="row-item row row-item-education-<?= $i ?>" style="display:<?= $display ?>">
                            <input type="hidden" name ="education_id[<?= $i ?>]" value="<?= !empty($education[$i]) ? (string) $education[$i]->_id : "" ?>">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="Education[school][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($education[$i]) ? $education[$i]->school : "" ?>" placeholder="<?= !empty($education[$i]->school) ? $education[$i]->school : "" ?>">
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="Education[course][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($education[$i]) ? $education[$i]->course : "" ?>" placeholder="<?= !empty($education[$i]) ? $education[$i]->course : "" ?>">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6">
                                <input name="Education[created_begin][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($education[$i]) ? $education[$i]->created_begin : "" ?>" placeholder="<?= !empty($education[$i]) ? $education[$i]->created_begin : "" ?>">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6">
                                <input name="Education[created_end][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($education[$i]) ? $education[$i]->created_end : "" ?>" placeholder="<?= !empty($education[$i]) ? $education[$i]->created_end : "" ?>">
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="row-item field-education">
                    <a class="add-education" data-count="2" href="javascript:void(0)"><i class="fa fa-plus"></i> Thêm mới </a>
                </div>

                <div class="row-item">
                    <a href="javascript:void(0)" class="btn btn-blue submit-education">Lưu lại</a>
                </div>
                <?php ActiveForm::end(); ?>
            </div>


        </div>

    </div>
</div>
<?=
$this->registerJs('$(document).ready(function ()
{
    $(document).on("click", ".eduacation", function () {
        $("#eduacation").modal("show");
    });
});
    $(document).on("click", ".add-education", function () {
    var count =parseInt($(this).attr("data-count"))+1;   
    document.getElementsByClassName("row-item-education-"+count)[0].style.display="block";
    if(count > 5){
    $(".field-education").html("");
    } else {
    $(".field-education").html("<a class=\'add-education\' data-count="+count+" href=\'javascript:void(0)\'><i class=\'fa fa-plus\'></i> Thêm mới </a>");
    }
    });
');
?>
<?= $this->registerJs("$(document).on('click', '.submit-education', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/education"]) . "',
               type: 'post',
          data: $('form#frmeducation').serialize(),
        success: function(data) {
          if(data){
          var rs = '';
         for (i = 0; i < data.length; i++) { 
            rs += '<p>'+data[i].created_begin +'-'+data[i].created_end+': '+data[i].course+' tại '+data[i].school+'</p>';
          }
          $('.education-list').html(rs);
       $('#eduacation').modal('hide');          
}
        }
    });

});") ?>
