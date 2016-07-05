
<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<section>
    <div class="introduce dang-viec">
        <div class="container">
            <div class="row">
                <div class="title-container">
                    <h3><?= Html::encode($this->title) ?></h3>
                </div>
                <!-- introduce item -->
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal frm-dangviec']]); ?>  
                    <div class="form-group" >
                        <label class="col-md-3 col-sm-4 col-xs-12 control-label">Danh mục</label>
                        <div class="col-md-6 col-sm-8 col-xs-12">
                            <?= $sector->category->name ?>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="col-md-3 col-sm-4 col-xs-12 control-label">Lĩnh vực</label>
                        <div class="col-md-6 col-sm-8 col-xs-12">
                            <?= $sector->name ?>
                        </div>
                    </div>
                    <?= $form->field($model, 'name', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div>']) ?>
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
                            echo $form->field($model, $value->id, ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-9 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])
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
                            echo $form->field($model, $value->id, ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-9 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])
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

                    <?= $form->field($model, 'description', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}<p class="pull-right"><span id="character_count">0</span> / 5000 ký tự</p></div>'])->textarea() ?>
                    <?=
                            $form->field($model, 'work_location', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-9 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])
                            ->radioList(
                                    $model->worklocation, [
                                'item' => function($index, $label, $name, $checked, $value)
                                {
                                    $check = $checked ? ' checked="checked"' : '';
                                    $return = '<label id="type-' . $value . '" class="radio-inline">';
                                    $return .= '<input type="radio" ' . $check . ' name="' . $name . '" value="' . $value . '" > ' . $label;
                                    $return .='</label>';
                                    return $return;
                                }
                                    ]
                            )
                            ->label();
                    ?>

                    <?= $form->field($model, 'address', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div>', 'inputOptions' => ['placeholder' => $model->getAttributeLabel('address')]])->label(FALSE) ?>

                    <div class="form-group location">
                        <label class="col-md-3 col-sm-4 col-xs-12 control-label"></label>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <div class="select">
                                <?php
                                echo $form->field($model, 'city_id')->dropDownList($model->cityList, ['prompt' => 'Chọn tỉnh thành'])->label(FALSE);
                                ?>
                            </div>

                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <div class="select">
                                <?php
                                if (!empty($district))
                                    $data = $district;
                                else
                                    $data = [];
                                echo $form->field($model, 'district_id')->dropDownList($data, ['prompt' => 'Chọn quận huyện'])->label(false);
                                ?>     
                            </div>
                        </div>
                    </div>     


                    <div class="form-group" >
                        <label class="col-md-3 col-sm-4 col-xs-12 control-label">Loại ngân sách công việc</label>
                        <div class="col-md-6 col-sm-8 col-xs-12">
                            <div class="select">
                                <?php
                                echo $form->field($model, 'budget_type')->dropDownList($budget, ['prompt' => 'Chọn loại ngân sách'])->label(FALSE);
                                ?>
                            </div>
                        </div>
                    </div>

                    <?= $form->field($model, 'deadline', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-2 col-sm-4 col-xs-6">{input}{hint}{error}</div>'])->textInput(['value' => !empty($model->deadline) ? date('d/m/Y', $model->deadline) : ""]) ?>
                    <?=
                            $form->field($model, 'level', ['template' => '<label class="col-md-12 col-sm-12 col-xs-12  control-label">{label}</label>{input}<div class="col-md-12 col-sm-12 col-xs-12">{hint}{error}</div>'])
                            ->radioList($model->levels, [
                                'item' => function($index, $label, $name, $checked, $value)
                                {
                                    $check = $label['checked'] == 1 ? ' checked="checked"' : '';
                                    $active = $label['checked'] == 1 ? 'active' : '';
                                    $return = '<div class="col-md-3 col-sm-6 col-xs-12"><label class="level-item ' . $active . '">';
                                    $return .= '<div class="level-active"></div>';
                                    $return .= '<i class="icon ' . $label['icon'] . '"></i>';
                                    $return .= '<div class="line-gray"></div>';
                                    $return .= '<div class="title-job"><p>' . $label['name'] . '</p></div>';
                                    $return .= '<input type="checkbox" ' . $check . ' name="' . $name . '[]" value="' . $label['id'] . '"  style="display:none"  > ';
                                    $return .='</label></div>';
                                    return $return;
                                }
                            ])->label();
                    ?>

                    <?= $form->field($model, 'num_bid', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-2 col-sm-4 col-xs-6">{input}{hint}{error}</div>']) ?>
                    <div class="form-group">
                        <label class="col-md-3 col-sm-4 col-xs-12 control-label">File đính kèm</label>
                        <div  class="col-md-9 col-sm-8 col-xs-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="uploadFile"><a class="btn btn-success" style="padding:6px 20px;">Tải file lên <i class="fa fa-upload"></i></a></div>
                                </div>
                                <div class="col-md-12" style="padding-top:10px">File tải lên dung lượng không quá 2MB và thuộc các định dạng (doc, docx, pdf, png, gif, jpg, zip, raz)</div>
                            </div>
                            <div class="resultFile">

                            </div>
                            <?= $form->field($model, 'file')->hiddenInput(['value' => ''])->label(FALSE) ?>
                            <?php
                            if (!empty($model->file))
                                echo 'Có ' . count($model->file) . ' đính kèm';
                            ?>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="submit-form-boss">
                                <?php
                                if (empty($model['_id']))
                                {
                                    ?>
                                    <button type="submit" class="btn btn-blue" name="post-work">Đăng việc</button>
                                    <button type="submit" class="btn btn-square" name="save-draft">Lưu nháp</button>

                                    <button type="submit" class="btn btn-link" name="save-view">Xem trước</button>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <button type="submit" class="btn btn-blue">Cập nhật</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
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
    $("#jobcreate-description").keyup(function(){
        var count = $(this).val().length;
        $("#character_count").text(count);
    })
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