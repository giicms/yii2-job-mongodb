<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\components\widgets\AvatarWidget;

$this->title = 'Chỉnh sửa hồ sơ cá nhân';
?>
<section>

    <div class="introduce profile-edit">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php $form = ActiveForm::begin(['id' => 'profile', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>  

                    <div class="title-container">
                        <h3>Hồ sơ cá nhân </h3>
                    </div>
                    <h4 class="title-box">Thông tin cá nhân </h4>
                    <hr>
                    <?php if (Yii::$app->session->hasFlash('error')) { ?>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="alert alert-danger" role="alert">
                                    <?= Yii::$app->session->getFlash('error') ?>
                                </div>
                            </div>
                        </div>    
                    <?php } ?>
                    <?= $form->field($model, 'name', ['template' => '<div><div class="col-md-3 col-sm-4 col-xs-12 ">{label}</div><div  class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div></div>'])->textInput(['class' => 'form-control', 'value' => $user->name]) ?>

                    <div class="form-group">
                        <div>
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <label class="control-label">Ảnh đại diện</label>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <div class="profile-item no-border">
                                    <?= AvatarWidget::widget(['crop' => TRUE, 'setValue' => 'bossinfo-avatar']) ?>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <?= $form->field($model, 'avatar', ['template' => '<div><div class="col-md-3 col-sm-4 col-xs-12">{label}</div><div  class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div></div>'])->hiddenInput(['value' => $user->avatar])->label(FALSE) ?>
                    <?= $form->field($model, 'email', ['template' => '<div><div class="col-md-3 col-sm-4 col-xs-12">{label}</div><div  class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div></div>'])->textInput(['class' => 'form-control', 'value' => $user->email]) ?>
                    <?= $form->field($model, 'phone', ['template' => '<div><div class="col-md-3 col-sm-4 col-xs-12">{label}</div><div  class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div></div>'])->textInput(['class' => 'form-control', 'value' => $user->phone]) ?>

                    <?=
                            $form->field($model, 'boss_type', ['template' => '<div class="col-md-3 col-sm-4 col-xs-12">{label}</div><div class="col-md-9 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])
                            ->radioList(
                                    $model->type, [
                                'item' => function($index, $label, $name, $checked, $value) {
                                    $check = ($value == Yii::$app->user->identity->boss_type) ? ' checked="checked"' : 'no';
                                    $return = '<label id="type-' . $value . '" class="radio-inline">';
                                    $return .= '<input type="radio" ' . $check . ' name="' . $name . '" value="' . $value . '" > ' . $label;
                                    $return .='</label>';
                                    return $return;
                                }
                                    ]
                            )
                            ->label();
                    ?>
                    <div id="company" style="<?php
                    if (empty($user->boss_type) || $user->boss_type == 1) {
                        echo 'display:none';
                    }
                    ?>">
                             <?= $form->field($model, 'company_name', ['template' => '<div><div class="col-md-3 col-sm-4 col-xs-12">{label}</div><div  class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div></div>'])->textInput(['class' => 'form-control', 'value' => (!empty($user->company_name)) ? $user->company_name : '0']) ?>
                             <?= $form->field($model, 'company_code', ['template' => '<div><div class="col-md-3 col-sm-4 col-xs-12">{label}</div><div  class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div></div>'])->textInput(['class' => 'form-control', 'value' => (!empty($user->company_code)) ? $user->company_code : '0']) ?>
                    </div>
                    <?= $form->field($model, 'address', ['template' => '<div><div class="col-md-3 col-sm-4 col-xs-12">{label}</div><div  class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div></div>'])->textInput(['class' => 'form-control', 'value' => $user->address]) ?>
                    <div class="form-group">
                        <div>
                            <div class="col-md-3 col-sm-4 col-xs-12"></div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'city', ['template' => '<div class="col-md-12 col-sm-12"><div class="select">{input}</div>{hint}{error}</div>'])->dropDownList($model->cityList, ['prompt' => 'Chọn tỉnh / thành phố'])->label(FALSE); ?>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'district', ['template' => '<div class="col-md-12 col-sm-12"><div class="select">{input}</div>{hint}{error}</div>'])->dropDownList($model->districtList, ['prompt' => 'Chọn quận / huyện'])->label(FALSE); ?>
                            </div>
                        </div>
                    </div>

                    <?php
                    if (!empty($model->company_name)) {
                        ?>
                        <h4 class="title-box">Thông tin công ty</h4>
                        <hr> 
                        <?= $form->field($model, 'company_name', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textInput(['value' => $user->company_name]) ?>
                        <?= $form->field($model, 'company_code', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textInput(['value' => $user->company_code]) ?>      
                    <?php } ?>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="submit-form-boss">
                                <button type="submit" class="btn btn-blue">Lưu và tiếp tục</button>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
if ($user->boss_type == 2) {
    echo $this->registerJs('
        $("document").ready(
            function(){
                $("input:radio").click(function(){
                    if($(this).val()==1){
                        document.getElementById("company").style.display="none";
                    }   else {
                        document.getElementById("company").style.display="block";
                    }
                });  
            }
        );');
} else {
    echo $this->registerJs('
        $("document").ready(
            function(){
                $("input:radio").click(function(){
                    if($(this).val()==1){
                        document.getElementById("company").style.display="none";
                        $("#bossinfo-company_name").val(0);
                        $("#bossinfo-company_code").val(0);
                    }   else {
                        document.getElementById("company").style.display="block";
                        $("#bossinfo-company_name").val("");
                        $("#bossinfo-company_code").val("");
                    }
                });  
            }
        );');
}
?>

<?= $this->registerJs('
$("#bossinfo-city").on("change",function(){    
    $.ajax({
        url:"' . Yii::$app->urlManager->createUrl(["ajax/selectdistrict"]) . '",
        type:"POST",            
        data:"id_city="+$("#bossinfo-city option:selected").val(),
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
            $("#bossinfo-district").html(html);
        } 
    });
});'); ?>
<?= $this->registerJs("$(document).on('click', '.save-us', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["boss/saveus"]) . "',
               type: 'post',
          data: $('form#profile').serialize(),
        success: function(data) {
            
        }
    });

});
") ?>
<?=
$this->registerJs('$(document).ready(function ()
{
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
                window.location.href = "' . $_SERVER['REQUEST_URI'] . '";   
        },
        onError: function (files, status, errMsg)
        {
            $(".resultFile").html("Không đúng định dạng hoặc size không quá 2 MB");
        }
    };
        $(".uploadFile").uploadFile(upload);

})');
?>
<?=
$this->registerJs("$(document).ready(function(){

				jQuery('#cropbox').Jcrop({
					onChange: showCoords,
					onSelect: showCoords,
                                        minSize: [150,150],
                                        setSelect:[50, 50, 200, 200 ],
                                        aspectRatio: 1/1,

				});

			});

			// Simple event handler, called from onChange and onSelect
			// event handlers, as per the Jcrop invocation above
			function showCoords(c)
			{
				jQuery('#x1').val(c.x);
				jQuery('#y1').val(c.y);
				jQuery('#x2').val(c.x2);
				jQuery('#y2').val(c.y2);
				jQuery('#w').val(c.w);
				jQuery('#h').val(c.h);
			};")
?>

<?= $this->registerJs("$(document).on('submit', '#cropimage', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["upload/cropimage"]) . "',
               type: 'post',
          data: $('form#cropimage').serialize(),
        success: function(data) {
          if(data){
  window.location.href = '" . $_SERVER['REQUEST_URI'] . "';        
}
        }
    });

});") ?>
<?= $this->registerJs('
$(document).on("click", ".modal-cancel", function (event){
                 window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
});') ?>