<?php 
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;
    use yii\grid\GridView;
    use yii\widgets\Pjax;
    use common\models\Job;
    use kartik\export\ExportMenu;
?>
<?= Html::csrfMetaTags() ?>


<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Công việc trên hệ thống</h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content1">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
                    <div class="row">
                        <form method="get" accept-charset="utf-8">
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 text-left">
                                <div id="reportrange_job" class="form-control" style="line-height: 20px; cursor: pointer;">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                    <input id="datefrom" value="" type="hidden" name="datefrom">
                                    <input id="dateto" value="" type="hidden" name="dateto">
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4 col-xs-12 text-left">
                                <input type="submit" class="btn btn-success" value="Xem">
                            </div>
                        </form>    
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 pull-right chart-info">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="pull-left">Việc đã đăng</span><button class="btn btn-success"></button>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="pull-left">Việc được giao</span><button class="btn btn-warning"></button>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="pull-left">Việc thất bại</span><button class="btn btn-danger"></button>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="pull-left">Việc thành công</span><button class="btn btn-primary"></button>
                        </div>
                    </div>
                </div>
            </div>    
            <div id="graph_bar_job" style="width:100%; height:280px;"></div>
        </div>
    </div>

    <!-- table job -->
    <div class="x_panel table-report">
        <div class="x_title">
            <h2>Danh sách công việc trên hệ thống</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content1">
            <div class="row fillter-report">
                <div class="col-md-9 col-sm-12 col-xs-12">
                    <div class="row">
                        <form method="get" accept-charset="utf-8">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label>Công việc</label>
                                <select name="txt_jobtype" class="form-control select">
                                    <option value="<?=Job::PROJECT_PUBLISH;?>">Việc đã đăng</option>
                                    <option value="<?=Job::PROJECT_PENDING;?>">Việc được giao</option>
                                    <option value="<?=Job::PROJECT_DEPOSIT?>">Việc việc thất bại</option>
                                    <option value="<?=Job::PROJECT_OVER?>">Việc hoàn thành</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label>Từ ngày</label>
                                <input name="txt_from" class="date-picker form-control" value="<?php if(!empty($_GET['txt_from'])){ echo $_GET['txt_from'];}?>" required>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label>Đến ngày</label>
                                <input name="txt_to" class="date-picker form-control" value="<?php if(!empty($_GET['txt_to'])){ echo $_GET['txt_to'];}?>" required>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label></label>
                                <input type="submit" class="btn btn-success" value="Lọc">
                            </div>
                        </form>
                    </div>    
                </div> 
                <div class="col-md-3 col-sm-12 col-xs-12 export-report"> 
                <?php 
                    if(!empty($dataProvider)){
                        $gridColumns = [
                            ['class' => 'yii\grid\SerialColumn'],
                                'id',
                                'name',
                                'color',
                                'publish_date',
                                'status',
                                ['class' => 'yii\grid\ActionColumn'],
                            ];

                        // Renders a export dropdown menu
                        /*echo ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'dropdownOptions' => [
                                'label' => 'Xuất file',
                                'class' => 'btn btn-warning btn-export'
                            ]
                        ]);*/
                    }  
                ?>  
                </div>
                
            </div>
            <?php
            if(!empty($dataProvider)){
                Pjax::begin([
                    'id' => 'pjax_gridview_boss',
                ])
            ?>
            <?=
                GridView::widget([
                        'id' => 'gridBoss',
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'columns' => [
                            [   
                                'class' => 'yii\grid\SerialColumn'
                            ],
                            [
                                'label' => 'Ngày đăng',
                                'attribute' => 'created_at',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return date('d-m-Y', $data->created_at);
                                }
                            ],
                            [
                                'attribute' => 'name',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return Html::a($data->name, ['job/view', 'id'=>$data->_id]);
                                }
                            ],
                            [
                                'attribute' => 'owner',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return Html::a($data->user->name, ['boss/view', 'id'=>$data->owner]);
                                }
                            ],
                            [
                                'label' => 'Trạng thái',
                                'attribute' => 'status',
                                'format' => 'html',
                                'value' => function ($data) {
                                    if($data->status == Job::PROJECT_PUBLISH){
                                        $status = 'Chờ giao việc';
                                    }elseif($data->status == Job::PROJECT_PENDING){
                                        $status = 'Đã giao việc';
                                    }elseif($data->status == Job::PROJECT_MAKING){
                                        $status = 'Đang làm việc';
                                    }elseif($data->status == Job::PROJECT_COMPLETED){
                                        $status = 'Đã hoàn thành';
                                    }else{
                                        $status = 'Đã kết thúc';
                                    }
                                    return $status;
                                }
                            ],  
                        ],
                        'tableOptions' => ['class' => 'table table-striped responsive-utilities jambo_table bulk_action', 'id' => ''],
                    ]);
                    ?>
                    <?php Pjax::end(); } ?> 

        </div>
    </div>    
</div>
<div class="clearfix"></div>
<?php
    $array = '';
    foreach ($model as $key => $value) {
        $array .= '{"period": "'.date("d-m-Y", $key).'", "jobview": '.$value['jobview'].', "jobinvite": '.$value['jobinvite'].', "jobfalse": '.$value['jobfalse'].', "jobcomplete": '.$value['jobcomplete'].'},';
    }
?>
<?= $this->registerJs('
var day_data = ['.$array.'
    ];
    Morris.Bar({
        element: "graph_bar_job",
        data: day_data,
        xkey: "period",
        barColors: ["#26B99A", "#ff8c00", "#ff0000", "#3498DB"],
        ykeys: ["jobview", "jobinvite", "jobfalse", "jobcomplete"],
        labels: ["Việc đã đăng", "Việc đã giao", "Việc hỏng", "Việc hoàn thành"],
        hideHover: "auto",
        xLabelAngle: 60
    });     
'); ?>                       