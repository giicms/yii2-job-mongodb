<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
use common\models\Job;
use common\models\Assignment;
use common\models\Asigmentstep;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý công việc';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                DANH SÁCH CÔNG VIỆC
                <!-- <small>
                    Some examples to get you started
                </small> -->
            </h3>
        </div>

        <div class="title_right"></div>
    </div>
    <div class="clearfix"></div>


    <div class="x_panel">
        <div class="x_content">

            <form>
                <div class="row fillter">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12"><label>Tên</label><input type="text" class="form-control" name="name"></div>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12"><label>Ngành nghề</label>
                        <select class="form-control" name="category" id ="category">
                            <option value="">Tất cả</option>
                            <?php
                            if (!empty($category))
                            {
                                foreach ($category as $value)
                                {
                                    $select = '';
                                    if (!empty($_GET["category"]) && $_GET["category"] == $value->id)
                                    {
                                        $select = 'selected';
                                    }
                                    echo '<option value="' . $value->id . '" ' . $select . '>' . $value->name . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12"><label>Lĩnh vực </label>
                        <select class="form-control" name="sector" id="sector">
                            <option value="">Tất cả</option>
                            <?php
                            if (!empty($sector))
                            {
                                foreach ($sector as $value)
                                {
                                    $select = '';
                                    if (($_GET["sector"] == $value->id))
                                    {
                                        $select = 'selected';
                                    }
                                    echo '<option value="' . $value->id . '" ' . $select . '>' . $value->name . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12"><label>Tỉnh/Thành phố </label>
                        <select class="form-control" name="city">
                            <option value="">Toàn quốc</option>
                            <?php
                            if (!empty($city))
                            {
                                foreach ($city as $value)
                                {
                                    $select = '';
                                    if (!empty($_GET["city"]) && $_GET["city"] == $value->id)
                                    {
                                        $select = 'selected';
                                    }
                                    echo '<option value="' . $value->id . '"  ' . $select . '>' . $value->name . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12"><label>Quận/Huyện</label>
                        <select class="form-control" name="district">
                            <option value="">Tất cả</option>
                            <?php
                            if (!empty($district))
                            {
                                foreach ($district as $val)
                                {
                                    $select = '';
                                    if (($_GET["district"] == $val->_id))
                                    {
                                        $select = 'selected';
                                    }
                                    echo '<option value="' . $val->_id . '" ' . $select . '>' . $val->name . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>


                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12"><label>Trạng thái</label>
                        <select class="form-control" name="publish">
                            <option value="">Tất cả</option>
                            <option value="<?= Job::PUBLISH_CLOSE ?>" <?php
                            if (!empty($_GET['publish']))
                            {
                                if ($_GET['publish'] == Job::PUBLISH_CLOSE)
                                {
                                    echo 'selected';
                                }
                            }
                            ?>>Việc đã ẩn</option>
                            <option value="block" <?php
                            if (!empty($_GET['publish']))
                            {
                                if ($_GET['publish'] == 'block')
                                {
                                    echo 'selected';
                                }
                            }
                            ?>>Việc bị khóa</option>
                            <option value="<?= Job::PUBLISH_NOACTIVE ?>" <?php
                            if (!empty($_GET['publish']))
                            {
                                if ($_GET['publish'] == Job::PUBLISH_NOACTIVE)
                                {
                                    echo 'selected';
                                }
                            }
                            ?>>Chờ duyệt</option>
                            <option value="<?= Job::PUBLISH_VIEW ?>" <?php
                            if (!empty($_GET['publish']))
                            {
                                if ($_GET['publish'] == Job::PUBLISH_VIEW)
                                {
                                    echo 'selected';
                                }
                            }
                            ?>>Lưu nháp</option>
                            <option value="<?= Job::PUBLISH_ACTIVE ?>" <?php
                            if (!empty($_GET['publish']))
                            {
                                if ($_GET['publish'] == Job::PUBLISH_ACTIVE)
                                {
                                    echo 'selected';
                                }
                            }
                            ?>>Mới đăng</option>
                            <option value="invite" <?php
                            if (!empty($_GET['publish']))
                            {
                                if ($_GET['publish'] == 'invite')
                                {
                                    echo 'selected';
                                }
                            }
                            ?>>Đã giao việc</option>
                            <option value="deposit" <?php
                            if (!empty($_GET['publish']))
                            {
                                if ($_GET['publish'] == 'deposit')
                                {
                                    echo 'selected';
                                }
                            }
                            ?>>Chờ xác nhận đặt cọc</option>
                            <option value="doing" <?php
                            if (!empty($_GET['publish']))
                            {
                                if ($_GET['publish'] == 'doing')
                                {
                                    echo 'selected';
                                }
                            }
                            ?>>Đang làm</option>
                            <option value="payment" <?php
                            if (!empty($_GET['publish']))
                            {
                                if ($_GET['publish'] == 'payment')
                                {
                                    echo 'selected';
                                }
                            }
                            ?>>Chờ xác nhận thanh toán</option>
                            <option value="finish" <?php
                            if (!empty($_GET['publish']))
                            {
                                if ($_GET['publish'] == 'finish')
                                {
                                    echo 'selected';
                                }
                            }
                            ?>>Đã kết thúc</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <label>Ngày đăng từ</label>
                        <div id="reportrange_right" class="form-control" style="line-height: 20px; cursor: pointer;">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                            <input id="datefrom" value="" type="hidden" name="datefrom">
                            <input id="dateto" value="" type="hidden" name="dateto">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                        <button type="submit" class="btn btn-primary" style="width:100%; margin-top:23px;">Lọc</button>
                    </div>
                </div>
            </form>
            <div class="result-search">
                <?php
                if (!empty($_GET['name']) || !empty($_GET['datefrom']) || !empty($_GET['dateto']) || !empty($_GET['protype']))
                {
                    echo '<strong>LỌC CÔNG VIỆC</strong>';
                    if (!empty($_GET['name']))
                    {
                        echo ' - Tên: ' . $_GET['name'];
                    }
                    if (!empty($_GET['datefrom']))
                    {
                        if ($_GET['datefrom'] == $_GET['dateto'])
                        {
                            echo ' - Ngày đăng:' . date('H:i m-d-Y', strtotime($_GET['datefrom']));
                        }
                        else
                        {
                            echo ' - Ngày đăng: từ ' . date('H:i m-d-Y', strtotime($_GET['datefrom'])) . ' đến ' . date('H:i m-d-Y', strtotime($_GET['dateto']));
                        }
                    }
                }
                ?>
            </div>
            <?php
            Pjax::begin([
                'id' => 'pjax_gridview_job'
            ]);
            ?>
            <?=
            GridView::widget([
                'id' => 'gridJob',
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => ' table table-striped responsive-utilities jambo_table bulk_action'],
                'rowOptions' => function ($model, $key, $index, $grid)
        {
            $class = $index % 2 ? 'odd' : 'even';
            return array('index' => $index, 'class' => $class . ' pointer');
        },
                'options' => ['class' => 'grid-view table-responsive'],
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'multiple' => true,
                    ],
                    [
                        'class' => 'yii\grid\SerialColumn'
                    ],
                    [
                        'label' => 'Code',
                        'attribute' => 'job_code',
                        'format' => 'html',
                        'value' => function ($data)
                        {
                            return $data->job_code;
                        },
                        'headerOptions' => ['class' => 'sorting'],
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'html',
                        'value' => function ($data)
                        {
                            return Html::a($data->name, ['job/view', 'id' => $data->_id]);
                        },
                            //'headerOptions' => ['class' => 'sorting'],
                            ],
                            // [
                            //     'attribute' => 'sector_id',
                            //     'format' => 'html',
                            //     'value' => function ($data) {
                            //         return $data->sector->name.'<br><i class="fa fa-folder-o"></i> '.$data->sector->category->name;
                            //     },
                            //     //'headerOptions' => ['class' => 'sorting'],
                            // ],
                            [
                                'label' => 'Ngân sách',
                                'attribute' => 'project_type',
                                'format' => 'html',
                                'value' => function ($data)
                                {
                                    return $data->budget;
                                },
                            //'headerOptions' => ['class' => 'sorting'],
                            ],
                            [
                                'attribute' => 'owner',
                                'format' => 'html',
                                'value' => function ($data)
                                {
                                    return Html::a($data->user->name, ['member/view', 'id' => $data->user->_id]);
                                },
                                    //'headerOptions' => ['class' => 'sorting'],
                                    ],
                                    [
                                        'attribute' => 'Trạng thái',
                                        'format' => 'html',
                                        'value' => function ($data)
                                        {
                                            return $data->getStatus($data->_id);
                                        },
                                    ],
                                    // [
                                    //     'label' => 'Tiến trình',
                                    //     'attribute' => 'created_at',
                                    //     'format' => 'html',
                                    //     'value' => function ($data) {
                                    //         $status ='Chưa giao việc';
                                    //         $asign = $data->assignment;
                                    //         if(!empty($asign)){
                                    //             $status = 'Đã giao việc cho '.Html::a('<b>'.$asign->user->name.'</b>', ['member/view', 'id'=>$asign->user->_id]);
                                    //             if(($asign->status_boss >= (string)Assignment::STATUS_PROGRESS)&&($asign->status_boss <= (string)Assignment::STATUS_PAYMENT)){
                                    //                 $progress = ((time() - $asign->created_at) / (($asign->created_at + (86400 * $asign->bid->period)) - $asign->created_at)) * 100;
                                    //                 $status .= '<div class="progress"><div class="progress-bar bg-success" role="progressbar" aria-valuenow="'.$progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$progress.'%;">'.number_format($progress, 2, '.', '').'% </div></div><b>From</b> '.date('H:i d-m-Y',$asign->created_at).'  <b>To</b> '.date('H:i d-m-Y',$asign->created_at + (86400 * $asign->bid->period));
                                    //             }
                                    //             if($asign->status_boss == (string)Assignment::STATUS_OVER){
                                    //                 $asign2 = $asign->getOverasigmentstep((string)$asign->_id);
                                    //                 $status .= '<div>Đã kết thúc: '.date('H:i d-m-Y', $asign2->created_at).'</div>';
                                    //             }
                                    //         }
                                    //         return $status;
                                    //     },
                                    //    // 'headerOptions' => ['class' => 'sorting'],
                                    // ],
                                    // 'sector_id',
                                    // 'description',
                                    // 'file',
                                    // 'project_type',
                                    // 'budget_type',
                                    // 'price',
                                    // 'deadline',
                                    // 'address',
                                    // 'district_id',
                                    // 'city_id',
                                    // 'skills',
                                    // 'level',
                                    // 'publish',
                                    // 'more_resquest',
                                    // 'job_application',
                                    // 'num_bid',
                                    // 'block_list',
                                    // 'owner',
                                    // 'count',
                                    // 'status',
                                    // 'work_location',
                                    // 'created_at',
                                    ['class' => 'yii\grid\ActionColumn'],
                                ],
                            ]);
                            ?>
                            <?php
                            Pjax::end();
                            ?>
                            <div class="">
                                <?= Html::a("Khóa", "javascript:void(0)", ["class" => "btn_close_multiple btn btn-danger"]) ?> 
                                <?= Html::a("Mở khóa", "javascript:void(0)", ["class" => "btn_open_multiple btn btn-success"]) ?> 
                            </div>
                        </div>
                    </div>
                </div>

                <?= $this->registerJs('
$("#category").on("change",function(){    
    $.ajax({
        url:"' . Yii::$app->urlManager->createUrl(["member/sector"]) . '",
        type:"POST",            
        data:"id="+$("#category option:selected").val(),
        dataType:"json",
        success:function(data){    
            if(data){
            var html;
            for (index = 0; index < data.length; ++index) {
                html += "<option value="+data[index].id+">"+data[index].name+"</option>";
            }    
            } else{
                html += "<option>Chuyên mục này chưa có</option>";
            }
            $("#sector").html(html);
        } 
    });
});
');
                ?>

                <!-- khóa việc -->
                <?= $this->registerJs('
    $(".btn_close_multiple").click(function () {
        var keys = $("#gridJob").yiiGridView("getSelectedRows");
        if(keys==""){
            var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
        var msg = confirm("Bạn có chắc chắn muốn khóa những công việc này không (s)");
        }
        if (msg == true) {
            $.ajax({
                type: "POST", url:"' . Yii::$app->urlManager->createUrl(["job/blockjob"]) . '", data: {ids: keys}, success: function (data) {
                    if(data=="ok"){
                        window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
                    }
                },    
            });
    }
    return false;
    });
'); ?>

                <!-- mở khóa -->
                <?= $this->registerJs('
    $(".btn_open_multiple").click(function () {
        var keys = $("#gridJob").yiiGridView("getSelectedRows");
        if(keys==""){
            var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
        var msg = confirm("Bạn có chắc chắn muốn mở khóa những công việc này không (s)");
        }
        if (msg == true) {
            $.ajax({
                type: "POST", url:"' . Yii::$app->urlManager->createUrl(["job/unblockjob"]) . '", data: {ids: keys}, success: function (data) {
                    if(data=="ok"){
                        window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
                    }
                },    
            });
    }
    return false;
    });
'); ?>

                <!-- /**Datatables **/ -->
                <?= $this->registerJs('
$(document).ready(function () {
    var oTable = $("#example").dataTable({
        "bLengthChange" : false, //thought this line could hide the LengthMenu
        "bFilter" : false,         
        "bPaginate": false,
        "ordering": false,
        "bInfo": false,
        "dom": "T<clear>lfrtip",
        "bDestroy": true,
        "tableTools": {
            "aButtons": [
                {
                    "sExtends": "pdf",
                    "sCharSet": "UTF-8",
                    "sSwfPath": "js/datatables/tools/TableTools-master/swf/copy_csv_xls_pdf.swf",
                }
            ]
        },
        "aoColumnDefs": [{
        "bSortable": false, 
        "aTargets": [-1, -2, -3, 1, 0]
        }]
    }).fnDestroy();   
}); '); ?>
