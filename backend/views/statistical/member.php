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
            <h2>Số lượng tài khoản nhân viên đăng ký trên hệ thống</h2>
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
                
            </div>    
            <div id="graph_line" style="width:100%; height:300px;"></div>
        </div>
    </div>
    <!-- table job -->
    <div class="x_panel table-report">
        <div class="x_title">
            <h2>Danh sách nhân viên trên hệ thống</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content1">
            <div class="row fillter-report">
                <div class="col-md-9 col-sm-12 col-xs-12">
                    <div class="row">
                        <form method="get" accept-charset="utf-8">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label>Nhân viên</label>
                                <select name="txt_membertype" class="form-control select">
                                    <option value="1" <?php if(!empty($_GET['txt_membertype'])){ if($_GET['txt_membertype'] ==1) { echo 'selected="selected"';}}?>>Đã đăng ký</option>
                                    <option value="2" <?php if(!empty($_GET['txt_membertype'])){ if($_GET['txt_membertype'] ==2) { echo 'selected="selected"';}}?>>Đã bị khóa</option>
                                    <option value="3" <?php if(!empty($_GET['txt_membertype'])){ if($_GET['txt_membertype'] ==3) { echo 'selected="selected"';}}?>>Làm việc nhiều nhất</option>
                                    <option value="4" <?php if(!empty($_GET['txt_membertype'])){ if($_GET['txt_membertype'] ==4) { echo 'selected="selected"';}}?>>Đánh giá nhiều nhất</option>
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
                       /* echo ExportMenu::widget([
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
                                    return Html::a($data->name, ['boss/view', 'id'=>$data->_id]);
                                }
                            ],
                            [
                                'attribute' => 'phone',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return $data->phone;
                                }
                            ], 
							[
                                'attribute' => 'email',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return $data->email;
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
        $array .= '{date: "'.date('Y-m-d', $key).'", value: '.$value["user"].'},';
    }
?>

<?= $this->registerJs('
    new Morris.Line({
    element: "graph_line",
        data: ['.$array.'],
        xkey: "date",
        xLabelFormat: function(date) {
            d = new Date(date);
            return d.getDate()+"/"+(d.getMonth()+1)+"/"+d.getFullYear(); 
        },
        xLabels: "day",
        ykeys: ["value"],
        labels: ["Value"],
        hideHover: "auto",
        lineColors: ["#26B99A", "#34495E", "#ACADAC", "#3498DB"],
        dateFormat: function(date) {
            d = new Date(date);
            return d.getDate()+"/"+(d.getMonth()+1)+"/"+d.getFullYear(); 
        },
    });    
'); ?>                       