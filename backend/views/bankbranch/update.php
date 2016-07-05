<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\BudgetPrice;

/* @var $this yii\web\View */
/* @var $model common\models\Skills */

$this->title = 'Cập nhật chi nhánh ngân hàng';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý chi nhánh ngân hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $this->title ?></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <?php
                    $form = ActiveForm::begin([
                                'fieldConfig' => [
                                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                                    'horizontalCssClasses' => [
                                        'label' => 'col-sm-3',
                                        'offset' => 'col-sm-offset-3',
                                        'wrapper' => ' col-md-6 col-sm-9 col-xs-12',
                                        'error' => '',
                                        'hint' => '',
                                    ],
                                ],
                    ]);
                    ?>  
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'bank_local')->dropDownList($model->cityList, ['prompt' => 'Chọn địa điểm']) ?>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'bank')->dropDownList($model->bankList, ['prompt' => 'Chọn ngân hàng']); ?>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?= $form->field($model, 'name')->textInput() ?> 
                        </div>
                    </div>       
                    
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-6 col-sm-9 col-xs-12">
                            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->registerJs('
$("#bankbranch-bank_local").on("change",function(){  
    var id = $(this).val();
    $.ajax({
        url:"' . Yii::$app->urlManager->createUrl(["bankbranch/select"]) . '",
        type:"POST",            
        data:{id: id}, 
        dataType:"json",
        success:function(data){     
            if(data){
                var html = "<option value>Chọn ngân hàng</option>";
                for (index = 0; index < data.length; ++index) {
                    html += "<option value="+data[index].id+">"+data[index].name+" - "+data[index].code+"</option>";
                }    
            } else{
                html = "<option value>Chưa có ngân hàng</option>";
            }
            $("#bankbranch-bank").html(html);
        }
    });
});'); ?>
