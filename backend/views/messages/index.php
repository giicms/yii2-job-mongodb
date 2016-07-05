<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Messages;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý cuộc trò chuyện';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ CUỘC TRÒ CHUYỆN
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
                    <h2>Danh sách cuộc trò chuyện</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>     

                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form>
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><label>Người tạo</label><input type="text" class="form-control" name="name"></div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label>Ngày tạo</label>
                                <div id="reportrange_right" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; margin-bottom: 10px; margin-right: 10px">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    <span>Lọc theo ngày tạo</span> <b class="caret"></b>
                                    <input id="datefrom" value="" type="hidden" name="from">
                                    <input id="dateto" value="" type="hidden" name="to">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <button type="submit" class="btn btn-success" style="margin-top:25px">Lọc</button> 
                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['messages']) ?>" class="btn btn-primary" style="margin-top:25px">Reset</a>
                            </div>
                        </div>
                    </form>
                    <?php
                    Pjax::begin([
                        'id' => 'pjax_gridview_messages',
                    ])
                    ?>
                    <?=
                    GridView::widget([
                        'id' => 'gridMessages',
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'columns' => [
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'multiple' => true,
                            ],
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'owner',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return $data->userowner->name;
                                },
//                                'headerOptions' => ['class' => 'sorting'],
                            ],
                            [
                                'attribute' => 'actor',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return $data->useractor->name;
                                },
//                                'headerOptions' => ['class' => 'sorting'],
                            ],
                            [
                                'attribute' => 'created_at',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return date('d/m/Y', $data->created_at);
                                },
//                                'headerOptions' => ['class' => 'sorting'],
                            ],
                            [
                                'attribute' => 'updated_at',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return date('d/m/Y', $data->updated_at);
                                },
//                                'headerOptions' => ['class' => 'sorting'],
                            ],
                            [
                                'attribute' => 'publish',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->publish == Messages::PUBLISH_ACTIVE)
                                        $check = 'checked';
                                    else
                                        $check = '';
                                    return '<input type="checkbox" name="publish" ' . $check . '>';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view}',
                            ],
                        ],
//                        'options' => ['class' => 'grid-view gridview-newclass'],
                        'tableOptions' => ['class' => 'table table-striped responsive-utilities jambo_table bulk_action'],
                    ]);
                    ?>
                    <?php Pjax::end() ?> 
                    <?= Html::a("Không hiển thị", "javascript:void(0)", ["class" => "btn_action_multiple btn btn-primary", "data" => "close"]) ?> 
                    <?= Html::a("Hiển thị", "javascript:void(0)", ["class" => "btn_action_multiple btn btn-success", "data" => "open"]) ?> 
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->registerJs('
   $(".btn_action_multiple").click(function () {
    var keys = $("#gridMessages").yiiGridView("getSelectedRows");
    var act = $(this).attr("data");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn chọn các mẫu tin này không (s)");
        }
       if (msg == true) {
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["messages/block"]) . '", data:{ids:keys,act:act}, success: function (data) {
            if(data=="ok"){
          window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
              }
            }, });
    }
    return false;
});
');
?>

<?= $this->registerJs(" $(document).ready(function () {

            var cb = function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange_right span').html(start.format('D/MM/YYYY') + ' - ' + end.format('D/MM/YYYY'));
                $('#datefrom').val(start.format('D/MM/YYYY'));
                $('#dateto').val(end.format('D/MM/YYYY'));
            }
            var d = new Date();
            var month = d.getMonth()+1;
            var day = d.getDate();
            var timeto = '12/01/2015';
            var timefrom = (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day + '/' + d.getFullYear();

            var optionSet1 = {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: timeto,
                maxDate: timefrom,
                dateLimit: {
                    days: 60
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Hôm nay': [moment(), moment()],
                    'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 ngày trước': [moment().subtract(6, 'days'), moment()],
                    '30 ngày trước': [moment().subtract(29, 'days'), moment()],
                    'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                    'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'right',
                buttonClasses: ['btn btn-default'],
                applyClass: 'btn-small btn-primary',
                cancelClass: 'btn-small',
                format: 'MM/DD/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Clear',
                    fromLabel: 'Từ',
                    toLabel: 'Đến',
                    customRangeLabel: 'Tùy chọn',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
                    firstDay: 1
                }
            };

            $('#reportrange_right span').html(moment().subtract(29, 'days').format('DD/MM/YYYY') + ' - ' + moment().format('DD/MM/YYYY'));
            
            

            $('#reportrange_right').daterangepicker(optionSet1, cb);
            
            $('#options1').click(function () {
                $('#reportrange_right').data('daterangepicker').setOptions(optionSet1, cb);
            });

            $('#options2').click(function () {
                $('#reportrange_right').data('daterangepicker').setOptions(optionSet2, cb);
            });

            $('#destroy').click(function () {
                $('#reportrange_right').data('daterangepicker').remove();
            });

        });
") ?>
<?= $this->registerJs('$("[name=publish]").bootstrapSwitch({onText:"&nbsp;",offText:"&nbsp;",onColor:"default",offColor:"default"});') ?>
<?= $this->registerJs('
$("input[name=publish]").on("switchChange.bootstrapSwitch", function(event, state) {
    var key = $(this).parent().parent().parent().parent("tr").attr("data-key");
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["messages/block"]) . '", data: {id: key,state:state}, success: function (data) {
            }, });
});
') ?>
