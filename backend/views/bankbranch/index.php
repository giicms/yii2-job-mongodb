<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use common\models\City;
use common\models\Bank;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý chi nhánh ngân hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ CHI NHÁNH NGÂN HÀNG
                <!-- <small>
                    Some examples to get you started
                </small> -->
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thêm mới</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php
                    $form = ActiveForm::begin([
                        'fieldConfig' => [
                            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                            'horizontalCssClasses' => [
                                'label' => 'col-sm-2',
                                'offset' => 'col-sm-offset-4',
                                'wrapper' => ' col-md-10 col-sm-10 col-xs-12',
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
                        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách gói</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?=
                    GridView::widget([
                        'id' => 'girdBudgetpacket',
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'columns' => [
                            // [
                            //     'class' => 'yii\grid\CheckboxColumn',
                            //     'multiple' => true,
                            // ],
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'bank_local',
                                'format' => 'html',
                                'value' => function($data) {
                                    return $data->getCityid($data->bank_local);
                                }
                            ],
                            [
                                'attribute' => 'bank',
                                'format' => 'html',
                                'value' => function($data) {
                                    return $data->getBankid($data->bank);
                                }
                            ],
                            'name',
                            
                            [
                                'label' => 'Hiển thị',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->publish == Bank::PUBLISH_ACTIVE)
                                        $check = 'checked';
                                    else
                                        $check = '';
                                    return '<input type="checkbox" id="checkstatus" name="publish" ' . $check . '>';
                                },
                                'visible' => Yii::$app->user->can('/member/block')
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update}',
                            ],
                        ],
                        'tableOptions' => ['class' => 'table table-striped responsive-utilities jambo_table bulk_action'],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->registerJs('
    $(".btn_delete_multiple").click(function () {
    var keys = $("#girdBudgetpacket").yiiGridView("getSelectedRows");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn xóa các mẫu tin này không (s)");
        }
      if (msg == true) {
     if(keys!=""){
      var url = "' . Yii::$app->urlManager->createUrl(["budgetpacket/delete"]) . '";  
         window.location.href = url + "/?id=" + keys;  
         }
    }
    return false;
});
');
?>

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
<?= $this->registerJs('$("[name=publish]").bootstrapSwitch({onText:"&nbsp;",offText:"&nbsp;",onColor:"default",offColor:"default"});') ?>
<?= $this->registerJs('
$("input[name=publish]").on("switchChange.bootstrapSwitch", function(event, state) {
    var key = $(this).parent().parent().parent().parent("tr").attr("data-key");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["bankbranch/publish"]) . '", 
        data: {id: key,state:state}, 
        success: function (data) {}, 
    });
});') ?>


