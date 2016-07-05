<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\components\widgets\AvatarWidget;
$this->title = 'Giới thiệu bản thân';
?>

<section>
    <div class="introduce profile-edit commitments">
        <div class="container">
            <div class="row">
                <!-- introduce item -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                    if (Yii::$app->session->hasFlash('success'))
                    {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            <?= Yii::$app->session->getFlash('success') ?>
                        </div>
                    <?php } ?>
                    <div class="title-container">
                        <h3>Tạo hồ sơ năng lực của bạn</h3>
                        <p>
                            Việc đầu tiên là bạn cần phải hoàn thiện hồ sơ năng lực của mình. Nó có vai trò rất quan trọng để khách hàng có thể đánh giá được khả năng của bạn, và nó là một công cụ marketing cho bạn để nổi bật trước hàng ngàn ứng viên khác.
                        </p>
                    </div>    

                    <div class="step-profile">
                        <ul class="list-unstyled">
                            <li class="step_1 step-done"><span>1</span><div>Giới thiệu bản thân</div></li>
                            <li class="step_2 text-center"><span>2</span><div class="text-center">Kinh nghiệm và học vấn</div></li>
                            <li class="step_3 text-right pull-right"><span>3</span><div class="text-right">Hoàn thành hồ sơ</div></li>
                        </ul>
                    </div>
                    <h4 class="title-box ">Thông tin cá nhân</h4>
                    <?php $form = ActiveForm::begin(['id' => 'profile', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal  frm-Profile']]); ?>  
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label"><b>Bạn cần có tấm hình đại duyệt</b></div>
                        <div class="col-md-6 col-sm-8 col-xs-12">
                            <div class="profile-item no-border">
                                <?= AvatarWidget::widget(['crop' => TRUE, 'setValue' => 'profile-avatar']) ?>
                            </div>
                        </div>
                    </div>
                    <?= $form->field($model, 'avatar', ['template' => '<label class="col-md-3 col-sm-3 col-xs-12 control-label">{label}</label><div  class="col-md-7 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->hiddenInput(['value' => Yii::$app->user->identity->avatar])->label(FALSE) ?>
                    <?= $form->field($model, 'birthday', ['template' => '<label class="col-md-3 col-sm-3 col-xs-12 control-label">{label}</label><div  class="col-md-7 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput(['class' => 'form-control datepicker2', 'value' => date('d/m/Y', $user->birthday)]) ?>
                    <?= $form->field($model, 'cmnd', ['template' => '<label class="col-md-3 col-sm-3 col-xs-12 control-label">{label}</label><div  class="col-md-7 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput(['data-toggle' => 'tooltip', 'data-placement' => 'right', 'value' => Yii::$app->user->identity->cmnd]) ?>
                    <?=
                    $form->field($model, 'address', [
                        'template' => '
                            <label class="col-md-3 col-sm-12 col-xs-12 control-label">{label}</label>
                            <div  class="col-md-3 col-sm-6 col-xs-12">{input}{hint}{error}</div>
                            <div class="col-md-2 col-sm-3 col-xs-12">
                                <div class="select">
                                    ' . $form->field($model, "city")->dropDownList($model->cityList, ["prompt" => "Chọn thành phố ", "class" => "form-control select-city"])->label(FALSE) . '
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12">
                                <div class="select">
                                    ' . $form->field($model, "district")->dropDownList(["0" => "Chọn quận/huyện"], ["class" => "form-control profile-district"])->label(FALSE) . '
                                </div>
                            </div>
                            '])->textInput(['value' => Yii::$app->user->identity->address])
                    ?>
                    <?= $form->field($model, 'description', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-7 col-sm-12 col-xs-12">{input}{hint}{error}</div>'])->textarea(['class' => 'form-control', 'value' => Yii::$app->user->identity->description]) ?>
                    <div class="form-group">
                        <label class="col-md-3 col-sm-4 col-xs-12 control-label">Kỹ năng bản thân</label>
                        <div  class="col-md-7 col-sm-12 col-xs-12">
                            <div class="select">
                                <select name="skills[]" class="form-control skill" multiple>
                                    <?php
                                    if (!empty($user->getSkill))
                                    {
                                        foreach ($user->getSkill as $value)
                                        {
                                            $skill = $user->getSkillname($value);
                                            if (!empty($user->skills))
                                            {
                                                ?>
                                                <option <?= in_array($value, $user->skills) ? "selected" : "" ?> value="<?= $value ?>"><?= $skill ?></option>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <option value="<?= $value ?>"><?= $skill ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>       
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label"><b>Trình độ ngoại ngữ</b></div>
                        <div class="language col-md-7 col-sm-10 col-xs-12">

                            <div class="row row-item-0">
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div class="select">
                                        <?php
                                        echo $form->field($model, 'language[0]')->dropDownList($model->languageList, ['prompt' => 'Chọn ngôn ngữ', 'class' => 'form-control select-ajax'])->label(FALSE);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div class="select">
                                        <?php
                                        echo $form->field($model, 'language_level[0]')->dropDownList(['0' => "Chọn cấp độ"], ['class' => 'form-control profile-language-0'])->label(FALSE);
                                        ?>
                                    </div>             
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12 option">
                                    <a class="btn btn-blue add" id="add-0" data-bind=0 href="javascript:void(0)"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>

                        </div>

                    </div>
                    <input type="hidden" id="count_lang" name="count_lang" value="0">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="submit-form-boss">
                                <button type="submit" class="btn btn-blue">Lưu và tiếp tục</button>
                                <a class="btn call-back" href="#">Quay lại</a>
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
    var formJob = $("form#createJob").serialize();
    var upload = {
        url: "' . Yii::$app->urlManager->createUrl(["upload/image"]) . '",
        method: "POST",
        allowedTypes: "jpg,png,jpeg,gif",
        fileName: "myfile",
        multiple: false,
        maxSize: 100000,
        onBeforeSend: function () {
            $(".loading").html("Đang tải...");
        },
        onSuccess: function (files, data, xhr)
        {
            $.each(data, function (index, value) {
                window.location.href = "' . $_SERVER['REQUEST_URI'] . '";          
            });
        },
        onError: function (files, status, errMsg)
        {
            $(".resultFile").html("Không đúng định dạng hoặc size không quá 2 MB");
        }
    };
        $(".uploadFile").uploadFile(upload);

})');
?>
<?= $this->registerJs('
    $(document).on("change", ".select-ajax", function () {
    var change = this.id;
 $.ajax({
   url:"' . Yii::$app->urlManager->createUrl(["ajax/languagelist"]) . '",
   type:"POST",            
   data:"id="+$("#"+change+" option:selected").val(),
   dataType:"json",
   success:function(data){     
   
         var html;

         for (index = 0; index < data.length; ++index) {
         html += "<option value=\'"+data[index].id+"\'>"+data[index].name+"</option>";
         }
               $("."+change).html(html);
        

       }
      });
    });

');
?>

<?=
$this->registerJs('$(document).ready(function ()
{
    $(document).on("click", ".add", function () {
    var i =$(this).attr("data-bind");
    var id = this.id;
    var html;
    if(i>=1){
    for (index = 0; index <= i; ++index) {
    html += ","+$("#profile-language-"+index+" option:selected").val();
}
    }else{
    html += ","+$("#profile-language-"+i+" option:selected").val();
}
    
    var language_id = html;
          $.ajax({
                url:"' . Yii::$app->urlManager->createUrl(["ajax/addlanguage"]) . '",
                type:"POST",            
                data:{i:i,language_id:language_id},
                success:function(data){   
                    if(i >= 0){
                       if(data){
                            $("#count_lang").val(i);
                            $(".row-item-"+i+" div.option").html("<a class=\'btn btn-danger delete\' data-bind=\'"+i+"\' href=\'javascript:void(0)\'><i class=\'fa fa-plus\'></i></a>");
                       }
                    }
                    $(".language").append(data);
                    
                    }
            });   

    });

})');
?>

<?=
$this->registerJs('$(document).ready(function ()
{
    $(document).on("click", ".delete", function () {
    var i =$(this).attr("data-bind");
    $(".row-item-"+i).remove();
    });
});
        tinyMCE.init({
        selector:"textarea",
        height: 300,
        setup : function(editor) {
            editor.on("change", function(e) {
                var content = tinyMCE.activeEditor.getContent();
                if(content == "")
                   $("#profile-description").val("");
                else 
                   $("#profile-description").val(content);
            });
       }
});
');
?>



<!-- slect city -->
<?= $this->registerJs("
    $(document).ready(function(){
        $('.select-city').change(function(){
            var id_city = this.value;
            $.ajax({
                url:'" . Yii::$app->urlManager->createUrl(["ajax/selectdistrict"]) . "',
                type:'post',
                data: 'id_city='+id_city,
                success:function(data){     
                    var html;
                    for (index = 0; index < data.length; ++index) {
                        html += '<option value=\"'+data[index].id+'\">Quận '+data[index].name+'</option>';
                    }
                    $('.profile-district').html(html);
                }
            })
            return false;
            
        })
    });
") ?>

<?= $this->registerJs('
$(document).on("click", ".modal-cancel", function (event){
                 window.location.href = "' . Yii::$app->urlManager->createUrl(["membership/about"]) . '";
});') ?>

<?= $this->registerJs('    
$(".skill").select2({
      placeholder: "Chọn các kỹ năng",
    maximumSelectionSize: 5
});'); ?>