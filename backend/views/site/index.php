<?php
/* @var $this yii\web\View */

use common\widgets\CounterWidget;

$this->title = 'Giao nhận việc';
?>
<div class="row tile_count">
    <?= CounterWidget::widget() ?>
</div>
<hr>
<!-- /top tiles -->
<div class="row tile_count">
    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
        <div class="left"></div>
        <div class="right">
            <a href="<?= Yii::$app->urlManager->createUrl(["member/index?step=cd"]) ?>"><span class="count_top"><i class="fa fa-user"></i> Nhân viên chưa duyệt</span></a>
            <div class="count"><?= count($member) ?></div>
        </div>
    </div>
    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
        <div class="left"></div>
        <div class="right">
            <a href="<?= Yii::$app->urlManager->createUrl(["boss/index?step=cd"]) ?>"><span class="count_top"><i class="fa fa-user"></i> Người đăng việc chưa duyệt</span></a>
            <div class="count"><?= count($boss) ?></div>
        </div>
    </div>
    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
        <div class="left"></div>
        <div class="right">
            <a href="<?= Yii::$app->urlManager->createUrl(["job/index?publish=1"]) ?>"><span class="count_top"><i class="fa fa-pencil-square-o"></i> Công việc chưa duyệt</span></a>
            <div class="count"><?= count($jobs) ?></div>
        </div>
    </div>
    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
        <div class="left"></div>
        <div class="right">
            <a href="<?= Yii::$app->urlManager->createUrl(["job/index?publish=deposit"]) ?>"><span class="count_top"><i class="fa fa-pencil-square-o"></i> Công việc chưa đặt cọc</span></a>
            <div class="count"><?= count($deposit) ?></div>
        </div>
    </div>
    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
        <div class="left"></div>
        <div class="right">
            <a href="<?= Yii::$app->urlManager->createUrl(["job/index?publish=payment"]) ?>"><span class="count_top"><i class="fa fa-pencil-square-o"></i> Công việc chưa thanh toán</span></a>
            <div class="count"><?= count($payment) ?></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph">

            <div class="row x_title">
                <div class="col-md-6">
                    <h3>Lượt truy cập trên hệ thống</h3>
                </div>
                <div class="col-md-6">
                </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <form method="get" accept-charset="utf-8">
                            <div id="reportrange_job" class="pull-left" style="background: #fff; cursor: pointer; padding: 6.5px 10px; border: 1px solid #ccc">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                <span></span> <b class="caret"></b>
                                <input id="datefrom" value="" type="hidden" name="datefrom">
                                <input id="dateto" value="" type="hidden" name="dateto">
                            </div>
                            <button type="submit" class="btn btn-success" style="border-radius:0">Xem</button>
                        </form>    
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <ul class="list-unstyled" style="margin-top:5px;">
                            <li class="pull-left"><button class="btn btn-success" style="margin:0 5px;background-color:#faef6b; border-color:#faef6b"></button><span>Tổng lượt truy cập</span></li>
                            <li class="pull-left"><button class="btn btn-success" style="margin:0 5px;background-color:#f5497f; border-color:#f5497f"></button><span>Người đăng việc</span></li>
                            <li class="pull-left"><button class="btn btn-success" style="margin:0 5px;background-color:#6ac5ed; border-color:#6ac5ed"></button><span>Nhân viên</span></li>
                        </ul>
                    </div>
                </div>

                <div id="placeholder33" style="height: 260px; display: none" class="demo-placeholder"></div>
                <div style="width: 100%;">
                    <canvas id="onlinedaily" style="width:100%; "></canvas>
                    <!-- <div id="canvas_dahs" class="demo-placeholder" style="width: 100%; height:270px;"></div> -->
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<br />

<div class="row">


    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel tile fixed_height_320">
            <div class="x_title">
                <h2>Nhân viên chưa duyệt (<?= count($member) ?>)</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                if (!empty($member))
                {
                    if (count($member) > 10)
                        $count = 10;
                    else
                        $count = count($member);
                    for ($i = 0; $i < $count; $i++)
                    {
                        $value = $member[$i];
                        if (!empty($value->avatar))
                            $avatar = '60-' . $value->avatar;
                        else
                            $avatar = 'avatar.png';
                        ?>
                        <div class="media">
                            <div class="media-left">
                                <a href="<?= Yii::$app->urlManager->createUrl(["member/view", 'id' => $value->id]) ?>">
                                    <img class="media-object" width="50" src="<?= Yii::$app->params['url_file'] . 'thumbnails/' . $avatar ?>">
                                </a>
                            </div>
                            <div class="media-body">
                                <a href="<?= Yii::$app->urlManager->createUrl(["member/view", 'id' => $value->id]) ?>"><h5 class="media-heading"><?= $value->name ?></h5></a>
                                <?= date('h:i:s d/m/Y', $value->created_at) ?>
                            </div>
                        </div>

                        <?php
                    }
                }
                if (count($member) > 9)
                {
                    ?>
                    <a class="pull-right" href="<?= Yii::$app->urlManager->createUrl(["member/index?step=cd"]) ?>">Xem tất cả</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel tile fixed_height_320">
            <div class="x_title">
                <h2>Người đăng việc chưa duyệt (<?= count($boss) ?>)</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                if (!empty($boss))
                {
                    foreach ($boss as $value)
                    {
                        if (!empty($value->avatar))
                            $avatar = '60-' . $value->avatar;
                        else
                            $avatar = 'avatar.png';
                        ?>
                        <div class="media">
                            <div class="media-left">
                                <a href="<?= Yii::$app->urlManager->createUrl(["member/view", 'id' => $value->id]) ?>">
                                    <img class="media-object" width="50" src="<?= Yii::$app->params['url_file'] . 'thumbnails/' . $avatar ?>">
                                </a>
                            </div>
                            <div class="media-body">
                                <a href="<?= Yii::$app->urlManager->createUrl(["member/view", 'id' => $value->id]) ?>"><h5 class="media-heading"><?= $value->name ?></h5></a>
                                <?= date('h:i:s d/m/Y', $value->created_at) ?>
                            </div>
                        </div>

                        <?php
                    }
                }
                if (count($boss) > 9)
                {
                    ?>
                    <a class="pull-right" href="<?= Yii::$app->urlManager->createUrl(["boss/index?step=cd"]) ?>">Xem tất cả</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel tile fixed_height_320">
            <div class="x_title">
                <h2>Công việc chưa duyệt (<?= count($jobs) ?>)</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                if (!empty($jobs))
                {
                    foreach ($jobs as $key => $value)
                    {
                        ?>
                        <div class="media">
                            <div class="media-left"><i class="fa fa-pencil-square-o fa-4x"></i></div>
                            <div class="media-body">
                                <a href="<?= Yii::$app->urlManager->createUrl(["job/view", 'id' => $value->id]) ?>"><h5 class="media-heading"><?= $value->name ?></h5></a>
                                <?= date('h:i:s d/m/Y', $value->created_at) ?> <a href="<?= Yii::$app->urlManager->createUrl(["boss/view", 'id' => $value->user->id]) ?>"><?= $value->user->name ?></a>
                            </div>
                        </div>

                        <?php
                    }
                }
                if (count($jobs) > 9)
                {
                    ?>
                    <a class="pull-right" href="<?= Yii::$app->urlManager->createUrl(["job/index?step=cd"]) ?>">Xem tất cả</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel tile fixed_height_320">
            <div class="x_title">
                <h2>Công việc chưa đặt cọc (<?= count($deposit) ?>)</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                if (!empty($deposit))
                {
                    foreach ($deposit as $key => $value)
                    {
                        ?>
                        <div class="media">
                            <div class="media-left"><i class="fa fa-pencil-square-o fa-4x"></i></div>
                            <div class="media-body">
                                <a href="<?= Yii::$app->urlManager->createUrl(["job/view", 'id' => $value->job->id]) ?>"><h5 class="media-heading"><?= $value->job->name ?></h5></a>
                                <?= date('h:i:s d/m/Y', $value->created_at) ?> <a href="<?= Yii::$app->urlManager->createUrl(["boss/view", 'id' => $value->job->user->id]) ?>"><?= $value->job->user->name ?></a>
                            </div>
                        </div>

                        <?php
                    }
                }
                else
                {
                    echo '<p>Chưa có công việc nào</p>';
                }
                if (count($deposit) > 9)
                {
                    ?>
                    <a class="pull-right" href="<?= Yii::$app->urlManager->createUrl(["job/index?publish=deposit"]) ?>">Xem tất cả</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel tile fixed_height_320">
            <div class="x_title">
                <h2>Công việc chưa thanh toán (<?= count($payment) ?>)</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                if (!empty($payment))
                {
                    foreach ($payment as $key => $value)
                    {
                        ?>
                        <div class="media">
                            <div class="media-left"><i class="fa fa-pencil-square-o fa-4x"></i></div>
                            <div class="media-body">
                                <a href="<?= Yii::$app->urlManager->createUrl(["job/view", 'id' => $value->job->id]) ?>"><h5 class="media-heading"><?= $value->job->name ?></h5></a>
                                <?= date('h:i:s d/m/Y', $value->created_at) ?> <a href="<?= Yii::$app->urlManager->createUrl(["boss/view", 'id' => $value->job->user->id]) ?>"><?= $value->job->user->name ?></a>
                            </div>
                        </div>

                        <?php
                    }
                }
                else
                {
                    echo '<p>Chưa có công việc nào</p>';
                }
                if (count($payment) > 9)
                {
                    ?>
                    <a class="pull-right" href="<?= Yii::$app->urlManager->createUrl(["job/index?publish=payment"]) ?>">Xem tất cả</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>



<?php
//echo '<pre>'; print_r($onlinedaily); echo '</pre>';
$day = '';
$boss = '';
$member = '';
$counter = '';
krsort($onlinedaily);
foreach ($onlinedaily as $key => $value)
{
    $day .= '"' . date('d-m', $value->created_at) . '",';
    $counter .= $value->counter . ',';
    $boss .= $value->boss . ',';
    $member .= $value->member . ',';
}
?>
<?= $this->registerJs('
var lineChartData = {
    labels: [' . $day . '],
    datasets: [
        {
            label: "Tổng lượt truy cập",
            fillColor: "rgba(251, 239, 96, 0.2)", //rgba(151,187,205,0.2)
            strokeColor: "rgba(251, 239, 96, 0.70)", //rgba(151,187,205,1)
            pointColor: "rgba(251, 239, 96, 0.70)", //rgba(151,187,205,1)
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: [' . $counter . ']
        },
        {
            label: "Nhân viên",
            fillColor: "rgba(90, 191, 239, 0.2)", //rgba(151,187,205,0.2)
            strokeColor: "rgba(90, 191, 239, 0.70)", //rgba(151,187,205,1)
            pointColor: "rgba(90, 191, 239, 0.70)", //rgba(151,187,205,1)
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: [' . $member . ']
        },
        {
            label: "Người đăng việc",
            fillColor: "rgba(244, 57, 118, 0.21)", //rgba(220,220,220,0.2)
            strokeColor: "rgba(244, 57, 118, 0.7)", //rgba(220,220,220,1)
            pointColor: "rgba(244, 57, 118, 0.7)", //rgba(220,220,220,1)
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [' . $boss . ']
        },
    ]
}

$(document).ready(function () {
    new Chart(document.getElementById("onlinedaily").getContext("2d")).Line(lineChartData, {
        responsive: true,
        scaleShowGridLines : true,
        pointDot : true,
        datasetStroke : true,
        tooltipFillColor: "rgba(51, 51, 51, 0.55)"
    });
});'); ?>

<?php
if (!empty($_GET['datefrom']) && !empty($_GET['dateto']))
{
    $dateto = DateTime::createFromFormat('m/d/Y', $_GET['dateto'])->format('d/m/Y');
    $datefrom = DateTime::createFromFormat('m/d/Y', $_GET['datefrom'])->format('d/m/Y');
    echo $this->registerJs('
        $("#reportrange_job span").html("' . $datefrom . ' - ' . $dateto . '");
        $("#reportrange_job #datefrom").val("' . $_GET['datefrom'] . '");
        $("#reportrange_job #dateto").val("' . $_GET['dateto'] . '");
    ');
}
else
{
    echo $this->registerJs('
        $("#reportrange_job span").html("' . date("d/m/Y", time() - 2592000) . ' - ' . date("d/m/Y", time()) . '");
        $("#reportrange_job #datefrom").val("' . date("m/d/Y", time() - 2592000) . '");
        $("#reportrange_job #dateto").val("' . date("m/d/Y", time()) . '");
    ');
}
?>

