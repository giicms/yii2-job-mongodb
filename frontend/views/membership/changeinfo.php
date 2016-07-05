<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use frontend\components\widgets\AvatarWidget;

$this->title = 'Chỉnh sửa hồ sơ';
?>
<section>
    <div class="introduce profile-edit commitments">
        <div class="container">
            <div class="row">
                <!-- introduce item -->
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <h4 class="title-box ">Thông tin cá nhân</h4>
                    <?php $form = ActiveForm::begin(['id' => 'profile', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal  frm-Profile']]); ?>  
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label"><b>Bạn cần có tấm hình đại duyệt</b></div>
                        <div class="col-md-6 col-sm-8 col-xs-12">
                            <div class="profile-item no-border">
                                <?= AvatarWidget::widget(['crop' => TRUE, 'setValue' => 'membershipinfo-avatar']) ?>
                            </div>
                        </div>
                    </div>
                    <?= $form->field($model, 'avatar', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-7 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->hiddenInput(['value' => $user->avatar])->label(FALSE) ?>
                    <?= $form->field($model, 'name', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-7 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput(['class' => 'form-control', 'value' => $user->name]) ?>
                    <?= $form->field($model, 'email', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-7 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput(['class' => 'form-control', 'value' => $user->email]) ?>
                    <?= $form->field($model, 'phone', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-7 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput(['class' => 'form-control', 'value' => $user->phone]) ?>
                    <?= $form->field($model, 'birthday', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-7 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput(['class' => 'form-control datepicker2', 'value' => date('d/m/Y', $user->birthday)]) ?>
                    <?= $form->field($model, 'cmnd', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-7 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput(['data-toggle' => 'tooltip', 'data-placement' => 'right', 'value' => $user->cmnd]) ?>
                    <?=
                    $form->field($model, 'address', [
                        'template' => '
                            <label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label>
                            <div  class="col-md-3 col-sm-4 col-xs-12">{input}{hint}{error}</div>
                            <div class="col-md-2 col-sm-3 col-xs-12">
                                <div class="select">
                                    <select name="MembershipInfo[city]" class="form-control select-city" id="membershipinfo-city">
                                        ' . $model->getCityList($user->city) . '
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12">
                                <div class="select">
                                    <select name="MembershipInfo[district]" class="form-control profile-district" id="membershipinfo-district">
                                        ' . $model->getDistrictList($user->city, $user->district) . '
                                    </select>
                                </div>
                            </div>
                        '])->textInput(['value' => $user->address])
                    ?>

                    <?= $form->field($model, 'description', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-7 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textarea(['class' => 'area-content form-control', 'value' => $user->description]) ?>
                    <?= $form->field($model, 'bankaccount', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-7 col-sm-12 col-xs-12">{input}{hint}{error}</div>'])->textarea(['class' => 'bankaccount form-control', 'value' => $user->bankaccount, 'rows' => 4]) ?>
                    <input type="hidden" id="count_lang" name="count_lang" value="0">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="submit-form-boss">
                                <button type="submit" class="btn btn-blue">Lưu và tiếp tục</button>
                                <?= Html::a('Quay lại', ['membership/profile'], ['class' => 'btn call-back']) ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>    

            </div>
        </div>
    </div>
</section>

<?= $this->registerJs("$(document).on('click', '.save-us', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["membership/saveus"]) . "',
               type: 'post',
          data: $('form#profile').serialize(),
        success: function(data) {
            
        }
    });

});
") ?>

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
        tinyMCE.init({
        selector:'.area-content',
        height: 300,
        setup : function(editor) {
            editor.on('change', function(e) {
                var content = tinyMCE.activeEditor.getContent();
                if(content == '')
                   $('#membershipinfo-description').val('');
                else 
                   $('#membershipinfo-description').val(content);
            });
       }
});

		") ?>

