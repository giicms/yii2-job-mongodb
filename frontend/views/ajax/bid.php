<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Book việc</h4>
</div>
<div class="modal-body">


    <?php
    $form = ActiveForm::begin([
                'id' => 'formBid',
                'options' => ['class' => 'form-horizontal'],
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
    ]);
    ?>  
    <div class="form-group">
        <label class="col-md-4 col-sm-4 col-xs-12">Tiêu đề công việc</label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <strong class="title"><?= $job->name ?></strong>
            <!--<input type="hidden" id="bid" name="bid_id" value="">-->
        </div>
    </div>
    <?= $form->field($bid, 'job_id')->hiddenInput(['value' => $model->id])->label(FALSE) ?>
    <?= $form->field($bid, 'period', ['template' => '<label class="col-md-4 col-sm-4 col-xs-12">Thời gian hoàn thành</label><div class="col-md-8 col-sm-8 col-xs-10"><div class="row"><div class="col-md-3">{input}</div> <div class="col-md-2" style="padding-top:5px; padding-left:0"> ngày</div></div>{hint}{error}</div>'])->textInput(['type' => 'number', 'min' => 1]) ?>
    <?= $form->field($bid, 'price', ['template' => '<label class="col-md-4 col-sm-4 col-xs-12">Chào giá</label><div class="col-md-8 col-sm-8 col-xs-10"><div class="row"><div class="col-md-5">{input}</div> <div class="col-md-5 dvt" style="padding-top:5px; padding-left:0"><span></span> VNĐ</div></div>{hint}{error}</div>'])->textInput(['placeholder' => "Ví dụ: 2.000.000"]) ?>
    <?= $form->field($bid, '_price', ['template' => '<div class="col-sm-offset-4 col-md-8 col-sm-8 col-xs-10"><div style="display:none">{input}</div>{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($bid, 'content', ['template' => '<label class="col-md-4 col-sm-4 col-xs-12">Tin nhắn</label><div  class="col-md-8 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textarea(['placeholder' => "Vài dòng chào giá của bạn."]) ?>
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">
            <button id="submitInvited" type="submit" class="btn btn-default btn-boss">Gởi nhận việc</button>
            <a href="#"  data-dismiss="modal" class="alert"><strong>Hủy</strong></a>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?= $this->registerJs('
$("#bidcreate-price").keyup(function(event) {
    if(event.which >= 37 && event.which <= 40){
    event.preventDefault();
     
  }
  var price = $(this).val().replace(/\D/g, "");
    $("#bidcreate-_price").val(price);
  $(this).val(function(index, value) {
    return value
      .replace(/\D/g, "")
      .replace(/([0-9])([0-9]{3})$/, "$1.$2")  
      .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".")
    ;
  });
})
');
?>
<?=
$this->registerCss('
        .field-bidcreate-_price{
        margin-bottom: 0 !important;
    }
 ')?>