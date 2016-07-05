<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý danh mục công việc';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ DANH MỤC CÔNG VIỆC
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
                    <h2>Danh sách danh mục công việc</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>     
                        <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['jobcategory/create']) ?>" class="btn btn-success">Thêm mới</a> </li>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="job-category">
                        <table class="table table-striped responsive-utilities jambo_table bulk_action">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th style="width:25%">Tên danh mục</th>
                                    <th>Tên lĩnh vực</a></th>
                                    <th>Icon</a></th>
                                    <th>Thời gian cho bài test</th>
                                    <th>Số câu cho bài test</th>
                                    <th>Thêm lĩnh vực</th>
                                    <th>Trạng thái</a></th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($query as $key => $value) {
                                    ?>
                                    <tr data-key="<?= $value->id ?>">
                                        <td><input type="checkbox" name="idc[]" class="case" value="<?= $value->id ?>"></td>
                                        <td><?= $value->name ?></td>
                                        <td>-</td>
                                        <td><?= $value->icon ?></td>
                                        <td><?= $value->test_time ?></td>
                                        <td><?= $value->test_number ?></td>
                                        <td>Thêm</td>
                                        <td>
                                            <?php
                                            switch ($value->status) {
                                                case Category::STATUS_NOACTIVE:
                                                    $status = 'Không hiển thị';
                                                    break;
                                                case Category::STATUS_ACTIVE:
                                                    $status = 'Hiện thị';
                                                    break;
                                            }
                                            echo $status
                                            ?>
                                        </td>
                                        <td>
                                            <a href="/jobcategory/view/<?= $value->id ?>" title="View"><span class="glyphicon glyphicon-eye-open"></span></a>
                                            <a href="/jobcategory/update/<?= $value->id ?>" title="Update"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <a href="#" class="act-delete"><span class="glyphicon glyphicon-trash"></span></a>
                                        </td>
                                    </tr>
                                    <?php
                                    foreach ($value->sectors as $sector) {
                                        ?>
                                        <tr data-key="<?= $sector->id ?>">
                                            <td><input type="checkbox" name="ids[]" class="case" value="<?= $sector->id ?>"></td>
                                            <td>-</td>
                                            <td><?= $sector->name ?></td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>
                                                Hiển thị
                                            </td>
                                            <td>
                                                <a href="/sector/view/<?= $sector->id ?>" title="Xem"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                <a href="/sector/update/<?= $sector->id ?>" title="Cập nật"><span class="glyphicon glyphicon-pencil"></span></a>
                                                <a href="#" class="act-delete"><span class="glyphicon glyphicon-trash"></span></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                    <?php
//                    GridView::widget([
//                        'id' => 'gridCategories',
//                        'dataProvider' => $dataProvider,
//                        'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
//                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
//                        'columns' => [
//                            [
//                                'class' => 'yii\grid\CheckboxColumn',
//                                'multiple' => true,
//                            ],
//                            ['class' => 'yii\grid\SerialColumn'],
//                            [
//                                'attribute' => 'name',
//                                'format' => 'html',
//                                'value' => function($data) use ($id) {
////                        if($data->id == $id)
////                            $html = $data->name;
////                        else 
//                                    $html = $data->name . '<br><a class="act-sector" href="#"><small>Hiển thị lĩnh vực</small></a>';
////                                    if ($data->id == $id) {
//                                    $html .= '<ul class="nav cat-' . $data->id . '">';
//                                    if (!empty($data->sectors)) {
//                                        foreach ($data->sectors as $key => $value) {
//
//                                            $html .= '<li class="' . $value->id . '"><a hre="' . $value->id . '">- <span class="sector-name">' . $value->name . '</span><span class="glyphicon glyphicon-trash pull-right delete"></span><span class="glyphicon glyphicon-pencil pull-right update">&nbsp;</span></a></li>';
//                                        }
//                                    }
//                                    $html .= '</ul>';
////                                    }
//                                    return $html;
//                                },
//                                'headerOptions' => ['style' => 'width:25%'],
//                            ],
//                            [
//                                'attribute' => 'icon',
//                                'format' => 'html',
//                                'value' => function ($data) {
//                                    return $data->icon;
//                                },
////                                'headerOptions' => ['class' => 'sorting'],
//                            ],
//                            [
//                                'attribute' => 'test_time',
//                                'format' => 'html',
//                                'value' => function ($data) {
//                                    return $data->test_time;
//                                },
////                                'headerOptions' => ['class' => 'sorting'],
//                            ],
//                            [
//                                'attribute' => 'test_number',
//                                'format' => 'html',
//                                'value' => function ($data) {
//                                    return $data->test_number;
//                                },
////                                'headerOptions' => ['class' => 'sorting'],
//                            ],
//                            [
//                                'label' => 'Trạng thái',
//                                'attribute' => 'status',
//                                'format' => 'html',
//                                'value' => function ($data) {
//                                    switch ($data->status) {
//                                        case Category::STATUS_NOACTIVE:
//                                            $status = 'Không hiển thị';
//                                            break;
//                                        case Category::STATUS_ACTIVE:
//                                            $status = 'Hiện thị';
//                                            break;
//                                    }
//                                    return '<a href="#" class="act-status">' . $status . '</a>';
//                                }
//                            ],
//                            [
//                                'class' => 'yii\grid\ActionColumn',
//                                'template' => '{view}{update}{delete}',
//                                'buttons' => [
//                                    'delete' => function () {
//                                        return '<a href="#" class="act-delete"><span class="glyphicon glyphicon-trash"></span></a>';
//                                    },
//                                ],
//                            ],
//                        ],
////                        'options' => ['class' => 'grid-view gridview-newclass'],
//                        'tableOptions' => ['class' => 'table table-striped responsive-utilities jambo_table bulk_action'],
//                    ]);
                    ?>
                    <?= Html::a("Xóa", "javascript:void(0)", ["class" => "btn_delete_multiple btn btn-danger"]) ?> 
                    <?= Html::a("Không hiển thị", "javascript:void(0)", ["class" => "btn_close_multiple btn btn-primary"]) ?> 
                    <?= Html::a("Hiển thị", "javascript:void(0)", ["class" => "btn_open_multiple btn btn-success"]) ?> 
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->registerJs('
    $("tr td ul").hide();
    $(".btn_close_multiple").click(function () {
    var keys = $("form#job-category").serialize();
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn khóa các danh mục này không (s)");
        }
    if (msg == true) {
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["jobcategory/statusall?act=2"]) . '", data: keys, success: function (data) {
            if(data=="ok"){
          window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
              }
            }, });
    }
    return false;
});
    $(".btn_open_multiple").click(function () {
       var keys = $("form#job-category").serialize();
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn hiện thị các danh mục này không (s)");
        }
    if (msg == true) {
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["jobcategory/statusall?act=1"]) . '", data: keys, success: function (data) {
            if(data=="ok"){
          window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
              }
            }, });
    }
    return false;
});
    $(".btn_delete_multiple").click(function () {
        var keys = $("form#job-category").serialize();
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn xóa các mẫu tin này không (s)");
        }
    if (msg == true) {
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["jobcategory/deleteall"]) . '", data:  keys, success: function (data) {
            if(data=="ok"){
          window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
              }
            }, });
    }
    return false;
});
    $(document).on("click", ".act-status", function (event){
    var key = $(this).parent().parent("tr").attr("data-key");
    var msg = confirm("Bạn có chắc chắn muốn khóa hay hiển thị mẫu tin này không ");
    if (msg == true) {
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["jobcategory/status"]) . '", data: {id: key}, success: function (data) {
           if(data.messages=="ok"){
          window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
              }
            }, });
    }
    return false;
});
    $(document).on("click", ".act-delete", function (event){
    var key = $(this).parent().parent("tr").attr("data-key");
    var msg = confirm("Bạn có chắc chắn muốn xóa mẫu tin này không ");
    if (msg == true) {
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["jobcategory/delete"]) . '", data: {id: key}, success: function (data) {
           if(data.messages=="ok"){
          window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
              }
            }, });
    }
    return false;
});

    $(document).on("click", ".act-sector", function (event){
    var key = $(this).parent().parent("tr").attr("data-key");
    $(".cat-"+key).removeClass("hide");
    $(".cat-"+key).toggle();
    return false;
});
    $(document).on("click", ".update", function (event){
    var key = $(this).parent().parent("li").attr("class");
    var name =$("."+key+" a span.sector-name").text();
    $(this).parent("a").hide();
    $(this).parent().parent("li").append("<div class=\'input-group\'><input type=text id=\'sector-"+key+"\' value=\'"+name+"\' class=\"form-control\"><span class=\"input-group-btn\"><button type=\"button\" class=\"btn btn-primary ajax-update\">Sửa</button></span></div>");
    return false;
});

    $(document).on("click", ".ajax-update", function (event){
    var key = $(this).parent().parent().parent("li").attr("class");
    var name = $("#sector-"+key).val();
            $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["jobcategory/editsector"]) . '", data: {id: key,name:name}, success: function (data) {
           if(data.messages=="ok"){
                $("."+key+" a span.sector-name")
              }
            }, });
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