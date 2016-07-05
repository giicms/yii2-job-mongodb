<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\job */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-form">

    <?php
    $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => 'col-sm-2',
                        'offset' => 'col-sm-offset-2',
                        'wrapper' => 'col-md-6 col-sm-9 col-xs-12',
                        'error' => '',
                        'hint' => '',
                    ],
                ],
    ]);
    ?> 
    <?= $form->field($model, 'name')->textInput(); ?>
    <?php
    foreach ($options as $value)
    {
        $arr = [];
        if (!empty($value->options))
        {
            foreach ($value->options as $val)
            {
                if (!empty($model->options[$value->id]['other']))
                {
                    $other = $model->options[$value->id]['other'];
                    $str = 'Khác,' . $model->options[$value->id]['option'];
                }
                else
                {
                    $other = '';
                    $str = $model->options[$value->id]['option'];
                }
                if (in_array($val, explode(',', $str)))
                    $check = 1;
                else
                    $check = 0;
                if (!empty($model->options[$value->id]['other']))
                    $other = $model->options[$value->id]['other'];
                else
                    $other = '';
                $arr[$val] = ['id' => $value->id, 'name' => $val, 'checked' => $check, 'other' => $other];
            }
        }
        if ($value->type == 1)
        {
            echo $form->field($model, $value->id)
                    ->radioList($arr, [
                        'item' => function($index, $label, $name, $checked, $value)
                        {
                            $text = $label['name'] == 'Khác' ? '<input type=text name="' . $label['id'] . '" value="' . $label['other'] . '" style="margin-left:10px;padding:6px 12px" >' : '';
                            $check = $label['checked'] == 1 ? ' checked="checked"' : '';
                            $return = '<div class="radio"><label>';
                            $return .= '<input type="radio" ' . $check . ' name="' . $name . '[]" value="' . $value . '" > ' . $label['name'];
                            $return .='</label>' . $text . '</div>';
                            return $return;
                        }
                    ])
                    ->label();
        }
        else
        {
            echo $form->field($model, $value->id)
                    ->checkboxList($arr, [
                        'item' => function($index, $label, $name, $checked, $value)
                        {
                            $text = $label['name'] == 'Khác' ? '<input type=text name="' . $label['id'] . '" value="' . $label['other'] . '" style="margin-left:10px;padding:6px 12px" >' : '';
                            $check = $label['checked'] == 1 ? ' checked="checked"' : '';
                            $return = '<div class="checkbox"><label>';
                            $return .= '<input type="checkbox" ' . $check . ' name="' . $name . '" value="' . $value . '" > ' . $label['name'];
                            $return .='</label>' . $text . '</div>';
                            return $return;
                        }
                    ])
                    ->label();
        }
    }
    ?>

    <?= $form->field($model, 'description')->textarea() ?>

    <?=
            $form->field($model, 'work_location')
            ->radioList($model->worklocation, [
                'item' => function($index, $label, $name, $checked, $value)
                {
                    $check = $checked ? ' checked="checked"' : '';
                    $return = '<label id="type-' . $value . '" class="radio-inline">';
                    $return .= '<input type="radio" ' . $check . ' name="' . $name . '" value="' . $value . '" > ' . $label;
                    $return .='</label>';
                    return $return;
                }
            ])->label();
    ?>

    <?= $form->field($model, 'address', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('address'), 'class' => 'form-control']])->label(FALSE) ?>

    <div class="location">
        <?= $form->field($model, 'city_id', ['template' => '<div class="col-md-3 col-sm-6 col-xs-12 col-sm-offset-2 select">{input}{hint}{error}</div>'])->dropDownList($model->cityList, ['prompt' => 'Chọn tỉnh thành'])->label(FALSE); ?>

        <?php
        if (!empty($district))
            $data = $district;
        else
            $data = [];
        echo $form->field($model, 'district_id', ['template' => '<div class="col-md-3 col-sm-6 col-xs-12 col-sm-offset-2 select">{input}{hint}{error}</div>'])->dropDownList($data, ['prompt' => 'Chọn quận huyện'])->label(false);
        ?>     
    </div>  

    <?php
    echo $form->field($model, 'budget_type', ['template' => '{label}<div class="col-md-3 col-sm-6 col-xs-12 select">{input}{hint}{error}</div>'])->dropDownList($budget, ['prompt' => 'Chọn loại ngân sách']);
    ?>

    <?= $form->field($model, 'deadline', ['template' => '{label}<div class="col-md-2 col-sm-4 col-xs-12">{input}{hint}{error}</div>'])->textInput(['value' => !empty($model->deadline) ? date('d/m/Y', $model->deadline) : "", 'class' => 'date-picker form-control']); ?>  
    <?=
            $form->field($model, 'level', ['template' => '{label}<div class="col-md-8 col-sm-10 col-xs-12"><div class="row">{input}</div></div><div class="col-md-12 col-sm-12 col-xs-12">{hint}{error}</div>'])
            ->checkboxList($model->levels, [
                'item' => function($index, $label, $name, $checked, $value)
                {
                    $check = $label['checked'] == 1 ? ' checked="checked"' : '';
                    $active = $label['checked'] == 1 ? 'active' : '';
                    $return = '<div class="col-md-3 col-sm-6 col-xs-12"><label class="level-item ' . $active . '">';
                    $return .= '<div class="level-active"></div>';
                    $return .= '<i class="icons ' . $label['icon'] . '"></i>';
                    $return .= '<div class="line-gray"></div>';
                    $return .= '<div class="title-job"><p>' . $label['name'] . '</p></div>';
                    $return .= '<input type="checkbox" ' . $check . ' name="' . $name . '" value="' . $label['id'] . '"  style="display:none"  > ';
                    $return .='</label></div>';
                    return $return;
                }
            ])->label();
    ?>


    <?= $form->field($model, 'num_bid', ['template' => '{label}<div class="col-md-1 col-sm-2 col-xs-12">{input}{hint}{error}</div>'])->textInput(['type' => 'number']); ?>

    <div class="form-group">
        <label class="col-md-2 col-sm-4 col-xs-12 control-label">File đính kèm</label>
        <div  class="col-md-6 col-sm-8 col-xs-12">
            <div class="uploadFile">Chọn file...</div>
            <div class="resultFile"></div>
            <?= $form->field($model, 'file')->hiddenInput(['value' => ''])->label(FALSE) ?>
            <?php
            if (!empty($model->file))
                echo 'Có ' . count($model->file) . ' đính kèm';
            ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-md-6 col-sm-8 col-xs-12">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?=
$this->registerJs('$(document).ready(function ()
{
    var upload = {
        url: "' . Yii::$app->urlManager->createUrl(["upload/file"]) . '",
        method: "POST",
        allowedTypes: "doc,docx,pdf,png,gif,jpg,zip,raz",
        fileName: "myfile",
        multiple: false,
        onBeforeSend: function () {
            $(".loading").html("Đang tải");
        },
        onSuccess: function (files, data, xhr)
        {
            $.each(data, function (index, value) {
                $(".loading").html("");
                if(value[0].error){
                $(".resultFile").html(value[0].error);
                } else {
                $(".resultFile").html("Bạn đã upload thành công ("+value[0].size+" KB) <a class=\deleteFile\ href=\javascript:void(0)\ >Xóa</a>");
                $("#jobcreate-file").val(value[0].name);
                }
            });
        },
        onError: function (files, status, errMsg)
        {
            $(".resultFile").html("Không đúng định dạng hoặc size quá lớn");
        }
    };
        $(".uploadFile").uploadFile(upload);
        
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
<?= $this->registerJs('
$("#jobcreate-deadline").datepicker({minDate:1, dateFormat:"dd/mm/yy"});
$("#job-price").keyup(function(event) {
    if(event.which >= 37 && event.which <= 40){
    event.preventDefault();
  }

  $(this).val(function(index, value) {
    return value
      .replace(/\D/g, "")
      .replace(/([0-9])([0-9]{3})$/, "$1.$2")  
      .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".")
    ;
  });
});
    $("label").tooltip({
        placement : "top"
    });
');
?>

<!-- cấp bậc nhân viên làm việc -->
<?= $this->registerJs('
    $("document").ready(
                function(){
                    $(".level-item input:checkbox").click(
                        function(){
                        var check = $(this).is(":checked");
                        if(check){
                         $(this).parent().addClass("active");
                        } else {
                         $(this).parent().removeClass("active");
                        }         
                        }
                    );  
                }
            );
') ?>
<?=
$this->registerJs('
$("textarea").textareaAutoSize();      
$(".skill").select2({
      placeholder: "Chọn các kỹ năng",
    maximumSelectionSize: 10
});
');
?>
<?php
if (!empty($model) && $model->work_location == 2)
{
    echo '<input type ="hidden" id="update_address" value="' . $model->address . '">';
    echo '<input type ="hidden" id="update_city" value="' . $model->city_id . '">';
    echo '<input type ="hidden" id="update_district" value="' . $model->district_id . '">';
    echo $this->registerJs('
     $("document").ready(
     
                function(){
                                  document.getElementsByClassName("location")[0].style.display = "block";
                          document.getElementsByClassName("field-jobcreate-address")[0].style.display = "block";
                                      }
            );');
    echo $this->registerJs('
     $("document").ready(
     
                function(){
                      
                    $("#jobcreate-work_location input:radio").click(
                        function(){
                            if($(this).val()==1){
                                   document.getElementsByClassName("location")[0].style.display = "none";
                          document.getElementsByClassName("field-jobcreate-address")[0].style.display = "none";
                                }   else {
                                       document.getElementsByClassName("location")[0].style.display = "block";
                                document.getElementsByClassName("field-jobcreate-address")[0].style.display = "block";
                                }
                   
                        }
                    );  
                }
            );');
}
else
{
    echo $this->registerJs('
     $("document").ready(
        function(){
            document.getElementsByClassName("location")[0].style.display = "none";
            document.getElementsByClassName("field-jobcreate-address")[0].style.display = "none";
            $("#jobcreate-address").val("0");
            $("#jobcreate-city_id").append("<option selected value=0>Null</option>");
            $("#jobcreate-district_id").append("<option selected value=0>Null</option>");
            $("#jobcreate-work_location input:radio").click(
                function(){
                    if($(this).val()==1){
                        document.getElementsByClassName("location")[0].style.display = "none";
                        document.getElementsByClassName("field-jobcreate-address")[0].style.display = "none";
                        $("#jobcreate-address").val("0");
                        $("#jobcreate-city_id").append("<option selected value=0>Null</option>");
                         $("#jobcreate-district_id").append("<option selected value=0>Null</option>");
                    } else {
                        document.getElementsByClassName("location")[0].style.display = "block";
                        document.getElementsByClassName("field-jobcreate-address")[0].style.display = "block";
                        $("#jobcreate-address").val("");
                        $("#jobcreate-city_id option[value=0]").remove();
                        $("#jobcreate-district_id option[value=0]").remove();
                    }
                   
            });  
        });');
}
?>


<?= $this->registerJs('
$("#jobcreate-city_id").on("change",function(){    
 $.ajax({
   url:"' . Yii::$app->urlManager->createUrl(["ajax/selectdistrict"]) . '",
   type:"POST",            
   data:"id_city="+$("#jobcreate-city_id option:selected").val(),
   dataType:"json",
   success:function(data){     
         if(data){
         var html;
         for (index = 0; index < data.length; ++index) {
        
         html += "<option value="+data[index].id+">"+data[index].name+"</option>";
}    
         } else{
              html = "<option>Chuyên mục này chưa có</option>";
         }
               $("#jobcreate-district_id").html(html);
       } 
      });
    });
//        tinyMCE.init({
//        selector:"textarea",
//        height: 300,
//        setup : function(editor) {
//            editor.on("change", function(e) {
//                var content = tinyMCE.activeEditor.getContent();
//                if(content == "")
//                   $("#jobcreate-description").val("");
//                else 
//                   $("#jobcreate-description").val(content);
//            });
//       }
//});
');
?>

<?= $this->registerCss('
        .level-item{
        width: 100%;
    }
    .level-item:hover, .level-item.active{
        border: 1px solid #20a8df;

    }
    .level-item:hover h4, .level-item.active h4{
        color: #20a8df;
    }
    
    textarea{
        min-height: 100px;
    }
        ') ?>