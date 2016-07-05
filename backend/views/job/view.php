<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use common\models\User;
use common\models\Job;
use common\models\Assignment;
use common\models\AssignmentStep;

/* @var $this yii\web\View */
/* @var $model common\models\job */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Công việc', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                <?= Html::encode($this->title) ?>
            </h3>
            <p><i class="fa fa-folder-o"></i> <?= $model->category->name ?> / <?= $model->sector->name ?></p>
        </div>
        <div class="title_right"></div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Quản lý chi tiết công việc</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <div class="row">
                        <div class="col-md-9 col-sm-12 col-xs-12">
                            <ul class="stats-overview">
                                <li>
                                    <span class="name"> Ngân sách công việc </span>
                                    <span class="value text-success">
                                        <?php
                                        if (!empty($assignment))
                                        {
                                            echo number_format($assignment->bid->price, 0, '', '.');
                                        }
                                        else
                                        {
                                            echo '...';
                                        }
                                        ?>
                                    </span>
                                </li>
                                <li>

                                    <span class="name">Ngân sách: </span>
                                    <span class="value text-success"><?= $model->budget ?></span> 

                                </li>
                                <li class="hidden-phone">
                                    <span class="name">Số lượt book việc</span>
                                    <span class="value text-success">
                                        <?= count($model->getBid((string) $model->_id)) ?>/<?= $model->num_bid ?>
                                    </span>
                                </li>
                            </ul>
                            <br>
                            <?php
                            if (!empty($assignment))
                            {
                                ?>
                                <?php
                                if ($assignment->status_boss == Assignment::STATUS_REQUEST)
                                {
                                    ?> 
                                    <!-- duyet cong viec -->
                                    <div class="tab-pane fade in active ">
                                        <div class="alert alert-success text-center">
                                            <h3 class="text-center">Công việc đã được hoàn thành</h3>
                                            <p>Chờ khách hàng thanh toán và nghiệm thu</p>
                                        </div>    
                                        <strong>File bàn giao: </strong> <a href="#"><strong>File 1</strong></a>
                                        <hr>
                                    </div>
                                    <?php
                                }
                                elseif ($assignment->status_boss == Assignment::STATUS_PAYMENT)
                                {
                                    ?> 
                                    <!-- boss thanh toán -->
                                    <div class="tab-pane fade in active ">
                                        <div class="alert alert-warning">
                                            <h3 class="text-center">Khách hàng đã thanh toán, kiểm tra nghiệm thu và kết thúc dự án</h3>
                                        </div>    
                                        <strong>File bàn giao: </strong> <a href="#"><strong>File 1</strong></a>
                                        <hr>
                                    </div>
                                    <?php
                                }
                                elseif ($assignment->status_boss == Assignment::STATUS_COMPLETE)
                                {
                                    ?> 
                                    <!-- kết thúc dự án -->
                                    <div class="tab-pane fade in active ">
                                        <div class="alert alert-success">
                                            <h3 class="text-center text-blue">Công việc đã được nghiệm thu và kết thúc</h3>
                                        </div>    
                                        <strong>File bàn giao: </strong> <a href="#"><strong>File 1</strong></a>
                                        <hr>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                            <!-- chi tiết công việc -->
                            <div class="description-job">
                                <div class="x_panel tile">
                                    <div class="x_title">
                                        <h2>Mô tả công việc</h2>
                                        <ul class="nav navbar-right panel_toolbox text-right">
                                            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content" style="display: block;">
                                        <h3 class="green">Yêu cầu công việc</h3>
                                        <?php
                                        foreach ($model->options as $option)
                                        {
                                            if (!empty($option['other']))
                                                $other = ',' . $option['other'];
                                            else
                                                $other = '';
                                            echo '<p><b>' . $option['name'] . ':</b> ' . trim($option['option'] . $other, ',') . '</p>';
                                        }
                                        ?>
                                        <p><b>Yêu cầu khác:</b></p>
                                        <p><?= nl2br($model->description) ?></p>
                                        <br>
                                        <div class="row">
                                            <?php
                                            if (!empty($model->file))
                                            {
                                                ?>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <h5 class="tit-item">Files đính kèm:</h5>
                                                    <ul class="list-unstyled project_files">
                                                        <?php
                                                        foreach ($model->file as $key => $value)
                                                        {
                                                            echo '<li><a href="' . $value . '"><i class="fa fa-file-word-o"></i>' . substr($value, 30) . '</a></li>';
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            <?php } ?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <h5 class="tit-item">Địa điểm làm việc:</h5>
                                                <p><i class="fa fa-map-marker"></i> <?php
                                                    if ($model->work_location == 1)
                                                    {
                                                        echo 'Toàn quốc';
                                                    }
                                                    else
                                                    {
                                                        echo $model->address . ', ' . $model->local->name . ', ' . $model->local->city->name;
                                                    }
                                                    ?></p>
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <h5 class="tit-item">Cấp bậc nhân viên làm việc:</h5>
                                                <?php
                                                if (!empty($model->findlevel))
                                                {
                                                    foreach ($model->findlevel as $value)
                                                    {
                                                        ?>
                                                        <p><i class="fa fa-user"></i> <?= $value['name']; ?></p>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <p class="title">Khách Hàng</p>
                                                <div class="profile-item">
                                                    <div class="profile pull-left">
                                                        <img width="100" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($model->user->avatar) ? '150-' . $model->user->avatar : "avatar.png" ?>">
                                                    </div>
                                                    <div class="profile-content">
                                                        <ul class="list-unstyled">
                                                            <li><?= Html::a('<b>' . $model->user->name . '</b>', ['member/view', 'id' => $model->user->_id]); ?></li>
                                                            <li>Đánh giá: 
                                                                <span class="star text-blue">
                                                                    <?= $model->user->getRating($model->user->_id); ?>
                                                                </span> 
                                                            </li>
                                                            <li><i class="fa fa-map-marker"></i> <b><?= $model->user->location->name; ?>, <?= $model->user->location->city->name; ?></b></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            if (!empty($assignment))
                                            {
                                                ?>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <p class="title">Nhân viên làm việc</p>
                                                    <div class="profile-item">
                                                        <div class="profile pull-left">
                                                            <img width="100" src="http://files.giaonhanviec.com//thumbnails/150-1448450039.png">
                                                        </div>
                                                        <div class="profile-content">
                                                            <ul class="list-unstyled">
                                                                <li><?= Html::a('<b>' . $assignment->user->name . '</b>', ['member/view', 'id' => $assignment->user->_id]); ?></li>
                                                                <li><?= $assignment->user->findlevel->name ?></li>
                                                                <li>Đánh giá: 
                                                                    <span class="star text-blue">
                                                                        <?= $assignment->user->getRating($model->user->_id); ?>
                                                                    </span> 
                                                                </li>
                                                                <li><i class="fa fa-map-marker"></i> <b><?= $assignment->user->location->name; ?>, <?= $assignment->user->location->city->name; ?></b></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <!-- End / chi tiết công việc -->
                            <!-- danh sách nhân viên book việc -->
                            <div class="book-list">
                                <div class="x_panel tile">
                                    <div class="x_title">
                                        <h2>Danh sách nhân viên book việc</h2>
                                        <ul class="nav navbar-right panel_toolbox text-right">
                                            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content" style="display: block;">
                                        <div class="table-responsive">
                                            <?php
                                            if (!empty($book))
                                            {
                                                ?>
                                                <table class="table">
                                                    <thead>
                                                        <tr style="background-color:#47C0FC;color:#fff;"><th>Nhân viên</th><th></th><th class="text-right">Thành tựu</th><th class="text-right">Thời gian book</th></tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($book as $value)
                                                        {
                                                            ?>
                                                            <tr>
                                                                <td style="width: 15%">
                                                                    <div class="info">
                                                                        <div class="profile">
                                                                            <img width="100" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($value->user->avatar) ? '150-' . $value->user->avatar : "avatar.png" ?>">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 30%">
                                                                    <div class="info">
                                                                        <div class="info">
                                                                            <p><?= Html::a('<b>' . $value->user->name . '</b>', ['member/view', 'id' => $value->user->_id]); ?></p>
                                                                            <p><b><?= $value->user->findcategory->name ?></b></p>
                                                                            <p><i class="fa fa-map-marker"></i> <b><?= $value->user->location->name ?>, <?= $value->user->location->city->name ?></b></p>
                                                                            <p><span class="text-gray">Test năng lực: 6</span></p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 30%" class="text-right">
                                                                    <p><b><?= $value->user->findlevel->name ?></b></p>
                                                                    <p>
                                                                        Đánh giá:  
                                                                        <span class="star text-blue">
                                                                            <?= $model->user->getRating($value->user->_id); ?>
                                                                        </span> 
                                                                    </p>
                                                                </td>
                                                                <td style="width: 25%" class="text-right">
                                                                    <p class="text-gray"><?= $value->period ?> ngày</p>
                                                                    <h3 class="text-blue"><?= number_format($value->price, 0, '', '.') ?></h3>
                                                                    <?php
                                                                    if (!empty($assignment))
                                                                    {
                                                                        if ($value->user->_id == $assignment->actor)
                                                                        {
                                                                            echo '<button class="btn btn-danger">Đã giao việc</button>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                            }
                                            else
                                            {
                                                echo 'Chưa có lượt book việc nào';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- messages -->
                                <div class="col-md-6 col-sm-6 col-xs-12 message-box">
                                    <div class="x_panel tile">
                                        <div class="x_title">
                                            <h2>Tin nhắn trao đổi</h2>
                                            <ul class="nav navbar-right panel_toolbox text-right">
                                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content" style="display: block;">
                                            <ul class="messages list-unstyled">
                                                <?php
                                                if (!empty($conversation))
                                                {
                                                    foreach ($conversation as $key => $message)
                                                    {
                                                        ?>
                                                        <li>
                                                            <img alt="Avatar" class="avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($message->owners->avatar) ? '60-' . $message->owners->avatar : "avatar.png" ?>">
                                                            <div class="message_wrapper">
                                                                <?= Html::a('<b>' . $message->owners->name . '</b>', ['member/view', 'id' => $message->owners->_id]); ?>
                                                                <small class="pull-right"><?= date('H:i d-m-Y', $message->created_at) ?></small>
                                                                <p><?= $message->content ?></p>
                                                            </div>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>  
                                <!-- messages --> 
                                <div class="col-md-6 col-sm-6 col-xs-12 activity-box message-box"> 
                                    <div class="x_panel tile">
                                        <div class="x_title">
                                            <h2>Hoạt động gần đây</h2>
                                            <ul class="nav navbar-right panel_toolbox text-right">
                                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content" style="display: block;">
                                            <ul class="messages list-unstyled">
                                                <?php
                                                if (!empty($assignment->asigmentstep))
                                                {
                                                    $temp = 0;
                                                    $tamp = 0;
                                                    $timp = 0;
                                                    foreach ($assignment->asigmentstep as $key => $asigmentstep)
                                                    {
                                                        $status_owner = $asigmentstep->status_owner;
                                                        $status_actor = $asigmentstep->status_actor;


                                                        if (($status_owner == Assignment::STATUS_GIVE) && ($status_actor == Assignment::STATUS_GIVE) && $temp == 0)
                                                        {
                                                            $temp == 0;
                                                            ?>

                                                            <!-- boss giao viec cho nhan vien -->
                                                            <li>
                                                                <img alt="Avatar" class="avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($model->user->avatar) ? '60-' . $model->user->avatar : "avatar.png" ?>">
                                                                <div class="message_wrapper">
                                                                    <p><?= Html::a('<b>' . $model->user->name . '</b>', ['member/view', 'id' => $model->user->_id]); ?> đã giao việc này cho  <?= Html::a('<b>' . $assignment->user->name . '</b>', ['member/view', 'id' => $assignment->user->_id]); ?><br><small><?= date('H:i d-m-Y', $asigmentstep->created_at) ?></small></p>
                                                                </div>
                                                            </li>
                                                            <?php
                                                        }
                                                        elseif (($status_owner == Assignment::STATUS_GIVE) && ($status_actor == Assignment::STATUS_GIVE) && $temp == 1)
                                                        {
                                                            $temp = 0;
                                                            ?>  
                                                            <!-- admin huy dat coc -->
                                                            <li>
                                                                <img alt="Avatar" class="avatar" src="<?= Yii::$app->params['url_file'] ?>/images/icon/favicon.png">
                                                                <div class="message_wrapper">
                                                                    <p>Đã hủy đặt cọc<br><small><?= date('H:i d-m-Y', $asigmentstep->created_at) ?></small></p>
                                                                </div>
                                                            </li>
                                                            <?php
                                                        }
                                                        elseif (($status_owner == Assignment::STATUS_GIVE) && ($status_actor == Assignment::STATUS_DEPOSIT) && $temp == 0)
                                                        {
                                                            $temp = 1;
                                                            ?>
                                                            <!-- boss dat coc cong viec -->
                                                            <li>
                                                                <img alt="Avatar" class="avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($model->user->avatar) ? '60-' . $model->user->avatar : "avatar.png" ?>">
                                                                <div class="message_wrapper">
                                                                    <p><?= Html::a('<b>' . $model->user->name . '</b>', ['member/view', 'id' => $model->user->_id]); ?> đã đặt cọc<br><small><?= date('H:i d-m-Y', $asigmentstep->created_at) ?></small></p>
                                                                </div>
                                                            </li>              
                                                            <?php
                                                        }
                                                        elseif (($status_owner == Assignment::STATUS_GIVE) && ($status_actor == Assignment::STATUS_COMMITMENT))
                                                        {
                                                            ?>
                                                            <!-- boss cam ket làm viec -->
                                                            <?= $asigmentstep->_id ?>
                                                            <li>
                                                                <img alt="Avatar" class="avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($model->user->avatar) ? '60-' . $model->user->avatar : "avatar.png" ?>">
                                                                <div class="message_wrapper">
                                                                    <p><?= Html::a('<b>' . $model->user->name . '</b>', ['member/view', 'id' => $model->user->_id]); ?> đã cam kết làm việc<br><small><?= date('H:i d-m-Y', $asigmentstep->created_at) ?></small></p>
                                                                </div>
                                                            </li>
                                                            <?php
                                                        }
                                                        elseif (($status_owner == Assignment::STATUS_COMMITMENT) && ($status_actor == Assignment::STATUS_COMMITMENT) && $tamp == 0 && $timp == 0)
                                                        {
                                                            $tamp = 0;
                                                            $timp = 1;
                                                            ?>
                                                            <!-- nhan vien cam ket lam viec -->
                                                            <li>
                                                                <img alt="Avatar" class="avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($assignment->user->avatar) ? '60-' . $assignment->user->avatar : "avatar.png" ?>">
                                                                <div class="message_wrapper">
                                                                    <p><?= Html::a('<b>' . $assignment->user->name . '</b>', ['member/view', 'id' => $assignment->user->_id]); ?> Đã cam kết làm việc<br><small><?= date('H:i d-m-Y', $asigmentstep->created_at) ?></small></p>
                                                                </div>
                                                            </li>  
                                                            <?php
                                                        }
                                                        elseif (($status_owner == Assignment::STATUS_REQUEST) && ($status_actor == Assignment::STATUS_COMMITMENT) && $tamp == 0 && $timp == 1)
                                                        {
                                                            $tamp = 1;
                                                            $timp = 1;
                                                            ?>
                                                            <!-- nhan vien gui yeu cau hoan thanh -->
                                                            <li>
                                                                <img alt="Avatar" class="avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($assignment->user->avatar) ? '60-' . $assignment->user->avatar : "avatar.png" ?>">
                                                                <div class="message_wrapper">
                                                                    <p><?= Html::a('<b>' . $assignment->user->name . '</b>', ['member/view', 'id' => $assignment->user->_id]); ?> đã gửi yêu cầu hoàn thành công việc<br><small><?= date('H:i d-m-Y', $asigmentstep->created_at) ?></small></p>
                                                                </div>
                                                            </li> 
                                                            <?php
                                                        }
                                                        elseif (($status_owner == Assignment::STATUS_COMMITMENT) && ($status_actor == Assignment::STATUS_COMMITMENT) && $tamp == 1 && $timp == 1)
                                                        {
                                                            $tamp = 0;
                                                            $timp = 1;
                                                            ?>
                                                            <!-- boss tu choi hoan thanh -->
                                                            <li>
                                                                <img alt="Avatar" class="avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($model->user->avatar) ? '60-' . $model->user->avatar : "avatar.png" ?>">
                                                                <div class="message_wrapper">
                                                                    <p><?= Html::a('<b>' . $model->user->name . '</b>', ['member/view', 'id' => $model->user->_id]); ?> Từ chối hoàn thành công việc<br><small><?= date('H:i d-m-Y', $asigmentstep->created_at) ?></small></p>
                                                                </div>
                                                            </li>                                                
                                                            <?php
                                                        }
                                                        elseif (($status_owner == Assignment::STATUS_REQUEST) && ($status_actor == Assignment::STATUS_REQUEST) && $tamp == 1)
                                                        {
                                                            $tamp = 0;
                                                            ?>
                                                            <!-- boss chap nhan hoan thanh cong viec -->
                                                            <li>
                                                                <img alt="Avatar" class="avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($model->user->avatar) ? '60-' . $model->user->avatar : "avatar.png" ?>">
                                                                <div class="message_wrapper">
                                                                    <p><?= Html::a('<b>' . $model->user->name . '</b>', ['member/view', 'id' => $model->user->_id]); ?> Chấp nhận hoàn thành công việc<br><small><?= date('H:i d-m-Y', $asigmentstep->created_at) ?></small></p>
                                                                </div>
                                                            </li>
                                                            <?php
                                                        }
                                                        elseif (($status_owner == Assignment::STATUS_REQUEST) && ($status_actor == Assignment::STATUS_PAYMENT))
                                                        {
                                                            ?>
                                                            <!-- boss thanh toan -->
                                                            <li>
                                                                <img alt="Avatar" class="avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($model->user->avatar) ? '60-' . $model->user->avatar : "avatar.png" ?>">
                                                                <div class="message_wrapper">
                                                                    <p><?= Html::a('<b>' . $model->user->name . '</b>', ['member/view', 'id' => $model->user->_id]); ?> Đã thanh toán<br><small><?= date('H:i d-m-Y', $asigmentstep->created_at) ?></small></p>
                                                                </div>
                                                            </li>   
                                                            <?php
                                                        }
                                                        elseif (($status_owner == Assignment::STATUS_COMPLETE) && ($status_actor == Assignment::STATUS_COMPLETE))
                                                        {
                                                            ?>
                                                            <!-- ket thuc cong viec -->
                                                            <li>
                                                                <img alt="Avatar" class="avatar" src="<?= Yii::$app->params['url_file'] ?>/images/icon/favicon.png">
                                                                <div class="message_wrapper">
                                                                    <p>Kết thúc công việc<br><small><?= date('H:i d-m-Y', $asigmentstep->created_at) ?></small></p>
                                                                </div>
                                                            </li>                
                                                            <?php
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    ?>
                                                    <li>
                                                        <p>Chưa có hoạt động nào</p>
                                                    </li>
                                                <?php } ?>    
                                            </ul>
                                        </div>
                                    </div> 
                                </div>  
                            </div>
                        </div>

                        <!-- start project-detail sidebar -->
                        <div class="col-md-3 col-sm-12 col-xs-12 tool-box">
                            <div class="x_panel tile">
                                <div class="x_title">
                                    <h2>Thông tin công việc</h2>
                                    <ul class="nav navbar-right panel_toolbox text-right">
                                        <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" style="display: block;">
                                    <ul class="list-unstyled">
                                        <li class="row">
                                            <div class="col-sm-5 col-xs-5">ID công việc</div>
                                            <div class="col-sm-7 col-xs-7"><?= $model->job_code; ?></div>
                                        </li>
                                        <li class="row">
                                            <div class="col-sm-5 col-xs-5">Ngày đăng</div>
                                            <div class="col-sm-7 col-xs-7"><?= date('d/m/y H:i', $model->created_at); ?></div>
                                        </li>
                                        <li class="row">
                                            <div class="col-sm-5 col-xs-5">Hạn chào giá</div>
                                            <div class="col-sm-7 col-xs-7"><?= date('d/m/y', $model->deadline); ?></div>
                                        </li>
                                        <li class="row">
                                            <div class="col-sm-5 col-xs-5">Địa điểm</div>
                                            <div class="col-sm-7 col-xs-7"><?php
                                                if ($model->work_location == 1)
                                                {
                                                    echo 'Toàn quốc';
                                                }
                                                else
                                                {
                                                    echo $model->address . ', ' . $model->local->name . ', ' . $model->local->city->name;
                                                }
                                                ?></div>
                                        </li>
                                        <li class="row">
                                            <div class="col-sm-5 col-xs-5">Ngân sách</div>
                                            <div class="col-sm-7 col-xs-7">
                                                <?php
                                                if (!empty($assignment))
                                                {
                                                    echo number_format($assignment->bid->price, 0, '', '.');
                                                }
                                                else
                                                {
                                                    echo $model->budget;
                                                }
                                                ?></div>
                                        </li>
                                        <?php
                                        if (!empty($assignment))
                                        {
                                            $deposit = $model->category->deposit;
                                            if (!empty($deposit) || $deposit > 0)
                                            {
                                                ?>
                                                <li class="row">
                                                    <div class="col-sm-5 col-xs-5">Đặt cọc</div>
                                                    <div class="col-sm-7 col-xs-7">
                                                        <?php
                                                        if ($assignment->status_boss < Assignment::STATUS_DEPOSIT)
                                                        {
                                                            echo number_format($assignment->bid->price * $assignment->bid->job->category->deposit / 100, 0, '', '.') . 'VNĐ (' . $assignment->bid->job->category->deposit . '%)';
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($assignment->status_boss >= Assignment::STATUS_DEPOSIT)
                                                        {
                                                            echo number_format($assignment->deposit->value, 0, '', '.') . 'VNĐ';
                                                        }
                                                        ?>

                                                        <p>
                                                            <?php
                                                            if ($assignment->status_boss < Assignment::STATUS_DEPOSIT)
                                                            {
                                                                echo '<b>(Chưa đặt cọc</b>)';
                                                            }
                                                            ?>
                                                            <?php
                                                            if ($assignment->status_boss >= Assignment::STATUS_DEPOSIT)
                                                            {
                                                                echo '<b>(Đã đặt cọc)</b>';
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>
                                                </li>
                                                <li class="row">
                                                    <div class="col-sm-5 col-xs-5">Thanh toán</div>
                                                    <div class="col-sm-7 col-xs-7">
                                                        <?php
                                                        if ($assignment->status_boss < Assignment::STATUS_DEPOSIT)
                                                        {
                                                            ?>
                                                            <?= number_format($assignment->bid->price * (100 - ($assignment->bid->job->category->deposit)) / 100, 0, '', '.') ?>VNĐ (<?= 100 - $assignment->bid->job->category->deposit ?>%)
                                                            <?php
                                                        }if ($assignment->status_boss >= Assignment::STATUS_DEPOSIT)
                                                        {
                                                            ?>
                                                            <?= number_format($assignment->bid->price - $assignment->deposit->value, 0, '', '.') ?>VNĐ (<?= 100 - ($assignment->deposit->value / $assignment->bid->price * 100) ?>%)
                                                        <?php } ?>

                                                        <p>
                                                            <?php
                                                            if ($assignment->status_boss < Assignment::STATUS_PAYMENT)
                                                            {
                                                                echo '<b>(Chưa thanh toán</b>)';
                                                            }
                                                            ?>
                                                            <?php
                                                            if ($assignment->status_boss >= Assignment::STATUS_PAYMENT)
                                                            {
                                                                echo '<b>(Đã thanh toán)</b>';
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                            else
                                            {
                                                
                                            }
                                        }
                                        ?>

                                        <li class="row">
                                            <div class="col-sm-5 col-xs-5">Trạng thái</div>
                                            <div class="col-sm-7 col-xs-7"><?= $model->getStatus($model->_id); ?></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="x_panel tile">
                                <div class="x_title">
                                    <h2>Thao tác</h2>
                                    <ul class="nav navbar-right panel_toolbox text-right">
                                        <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" style="display: block;">
                                    <ul class="list-unstyled">
                                        <li>
                                            <div>
                                                <i class="fa fa-pencil-square-o"></i> Nổi bật: <b class="rs-featured"><?= ($model->featured == Job::FEATURED_OPEN) ? "Mở" : "Đóng" ?></b> <a href="javascript:;" class="featured click-js">Chỉnh sửa</a>
                                            </div>
                                            <div class="edit-featured" style="display:none">
                                                <?php $form = ActiveForm::begin(['id' => 'formJob']); ?>
                                                <p class="alert-featured"></p>
                                                <?= $form->field($model, 'id')->hiddenInput()->label(FALSE); ?>
                                                <?= $form->field($model, 'featured')->dropDownList($model->featureds)->label(FALSE); ?>
                                                <?php ActiveForm::end(); ?>
                                            </div>
                                        </li>
                                        <?php
                                        if (empty($assignment))
                                        {
                                            ?>
                                            <li class="row">
                                                <div class="col-sm-12 col-xs-12">
                                                    <div>
                                                        <i class="fa fa-credit-card"></i> Trạng thái: 
                                                        <?php
                                                        if ($model->publish == Job::PUBLISH_NOACTIVE)
                                                        {
                                                            echo '<b>Chưa duyệt</b>';
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($model->publish == Job::PUBLISH_ACTIVE)
                                                        {
                                                            echo '<b>Đã duyệt</b>';
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($model->publish == Job::PUBLISH_VIEW)
                                                        {
                                                            echo '<b>Lưu nháp</b>';
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($model->publish == Job::PUBLISH_CLOSE)
                                                        {
                                                            echo '<b>Đóng việc</b>';
                                                        }
                                                        ?>
                                                        <a href="javascript:;" class="edit-status click-js" data="publish">Chỉnh sửa</a>
                                                    </div>
                                                    <div class="select-status" id="tabpublish">
                                                        <select class="form-control txt_publish">
                                                            <option value="<?= Job::PUBLISH_NOACTIVE ?>" <?php
                                                            if ($model->publish == Job::PUBLISH_NOACTIVE)
                                                            {
                                                                echo "selected = selected";
                                                            }
                                                            ?>>Chưa duyệt</option>
                                                            <option value="<?= Job::PUBLISH_ACTIVE ?>" <?php
                                                            if ($model->publish == Job::PUBLISH_ACTIVE)
                                                            {
                                                                echo "selected = selected";
                                                            }
                                                            ?>>Đã duyệt</option>
                                                            <option value="<?= Job::PUBLISH_VIEW ?>" <?php
                                                            if ($model->publish == Job::PUBLISH_VIEW)
                                                            {
                                                                echo "selected = selected";
                                                            }
                                                            ?>>Lưu nháp</option>
                                                            <option value="<?= Job::PUBLISH_CLOSE ?>" <?php
                                                            if ($model->publish == Job::PUBLISH_CLOSE)
                                                            {
                                                                echo "selected = selected";
                                                            }
                                                            ?>>Đóng việc</option>
                                                        </select>
                                                        <a href="javascript:;" id="publish" class="btn btn-default" data-id="<?= $model->_id ?>" data-val="">OK</a>
                                                        <a href="javascript:;" class="click-js click-cancel">Hủy</a>
                                                        <div class="clear-fix"></div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } ?>

                                        <?php
                                        if (!empty($assignment))
                                        {

                                            //check assignment step
                                            //đặt cọc 
                                            $deposit = $model->category->deposit;
                                            if (!empty($deposit) && $deposit == 100)
                                            {
                                                ?>
                                                <li class="row">
                                                    <div class="col-sm-12 col-xs-12">
                                                        <div>
                                                            <i class="fa fa-credit-card"></i> Đặt cọc: 
                                                            <?php
                                                            if ($assignment->status_boss == Assignment::STATUS_GIVE)
                                                            {
                                                                echo '<b>Chưa đặt cọc</b>';
                                                            }
                                                            ?>
                                                            <?php
                                                            if ($assignment->status_boss == Assignment::STATUS_DEPOSIT)
                                                            {
                                                                echo '<b>Đã đặt cọc</b>';
                                                            }
                                                            ?>
                                                            <a href="javascript:;" class="edit-status click-js" data="deposit">Chỉnh sửa</a>
                                                        </div>
                                                        <div class="select-status" id="tabdeposit">
                                                            <p>Số tiền đặt cọc:</p>
                                                            <input class="form-control txt_deposit" value='' name="txt_deposit">
                                                            <a href="javascript:;" id="deposit" class="btn btn-default" data-id="<?= $assignment->job_id ?>" data-val="<?= number_format($bid->price * $bid->job->category->deposit / 100, 0, '', '') ?>">OK</a>
                                                            <a href="javascript:;" class="click-js click-cancel">Hủy</a>
                                                            <div class="clear-fix"></div>
                                                            <div class="row">
                                                                <div class="deposit-alert text-red col-xs-12"></div>
                                                            </div>
                                                            <?php
                                                            if ($assignment->status_boss == Assignment::STATUS_DEPOSIT)
                                                            {
                                                                ?>
                                                                <div class="row">
                                                                    <div class="col-xs-12">
                                                                        <p></p>
                                                                        <?= Html::a('Hủy đặt cọc', ['job/undeposit', 'id' => $model->_id], ['class' => 'text-red', 'data' => ['confirm' => 'Hủy xác nhận đặt cọc?']]); ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>  
                                                        </div>
                                                    </div>
                                                </li>    
                                                <?php
                                            }
                                            if (empty($deposit) || $deposit == 0)
                                            {
                                                ?>
                                                <li class="row">
                                                    <div class="col-sm-12 col-xs-12">
                                                        <div>
                                                            <i class="fa fa-credit-card"></i> Thanh toán: 
                                                            <?php
                                                            if ($assignment->status_boss == Assignment::STATUS_REQUEST)
                                                            {
                                                                echo '<b>Chưa thanh toán</b>';
                                                            }
                                                            ?>
                                                            <?php
                                                            if ($assignment->status_boss == Assignment::STATUS_PAYMENT)
                                                            {
                                                                echo '<b>Đã thanh toán</b>';
                                                            }
                                                            ?>
                                                            <a href="javascript:;" class="edit-status click-js" data="payment">Chỉnh sửa</a>
                                                        </div>
                                                        <div class="select-status" id="tabpayment">
                                                            <p>Số tiền thanh toán:</p>
                                                            <input class="form-control txt_payment" value='' name="txt_payment">
                                                            <a href="javascript:;" id="payment" class="btn btn-default" data-id="<?= $assignment->job_id ?>" data-val="<?= number_format($assignment->bid->price, 0, '', '') ?>">OK</a>
                                                            <a href="javascript:;" class="click-js click-cancel">Hủy</a>
                                                            <div class="clear-fix"></div>
                                                            <div class="row">
                                                                <div class="payment-alert text-red col-xs-12"></div>
                                                            </div>
                                                            <?php
                                                            if ($assignment->status_boss == Assignment::STATUS_PAYMENT)
                                                            {
                                                                ?>
                                                                <div class="row">
                                                                    <div class="col-xs-12">
                                                                        <p></p>
                                                                        <?= Html::a('Hủy thanh toán', ['job/unpayment', 'id' => $model->_id], ['class' => 'text-red', 'data' => ['confirm' => 'Hủy xác nhận thanh toán?']]); ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>  
                                                        </div>
                                                    </div>
                                                </li> 
                                                <?php
                                            }
                                            if (!empty($deposit) && (0 < $deposit && 100 > $deposit))
                                            {
                                                if (!empty($assignment))
                                                {
                                                    if ($assignment->status_boss < Assignment::STATUS_REQUEST)
                                                    {
                                                        ?> 
                                                        <li class="row">
                                                            <div class="col-sm-12 col-xs-12">
                                                                <div>
                                                                    <i class="fa fa-credit-card"></i> Đặt cọc: 
                                                                    <?php
                                                                    if ($assignment->status_boss == Assignment::STATUS_GIVE)
                                                                    {
                                                                        echo '<b>Chưa đặt cọc</b>';
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    if ($assignment->status_boss == Assignment::STATUS_DEPOSIT)
                                                                    {
                                                                        echo '<b>Đã đặt cọc</b>';
                                                                    }
                                                                    ?>
                                                                    <a href="javascript:;" class="edit-status click-js" data="deposit">Chỉnh sửa</a>
                                                                </div>
                                                                <div class="select-status" id="tabdeposit">
                                                                    <p>Số tiền đặt cọc:</p>
                                                                    <input class="form-control txt_deposit" value='' name="txt_deposit">
                                                                    <a href="javascript:;" id="deposit" class="btn btn-default" data-id="<?= $assignment->job_id ?>" data-val="<?= number_format($bid->price * $bid->job->category->deposit / 100, 0, '', '') ?>">OK</a>
                                                                    <a href="javascript:;" class="click-js click-cancel">Hủy</a>
                                                                    <div class="clear-fix"></div>
                                                                    <div class="row">
                                                                        <div class="deposit-alert text-red col-xs-12"></div>
                                                                    </div>
                                                                    <?php
                                                                    if ($assignment->status_boss == Assignment::STATUS_DEPOSIT)
                                                                    {
                                                                        ?>
                                                                        <div class="row">
                                                                            <div class="col-xs-12">
                                                                                <p></p>
                                                                                <?= Html::a('Hủy đặt cọc', ['job/undeposit', 'id' => $model->_id], ['class' => 'text-red', 'data' => ['confirm' => 'Hủy xác nhận đặt cọc?']]); ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>  
                                                                </div>
                                                            </div>
                                                        </li>    
                                                        <?php
                                                    }
                                                    elseif ($assignment->status_boss == Assignment::STATUS_REQUEST)
                                                    {
                                                        ?> 
                                                        <li class="row">
                                                            <div class="col-sm-12 col-xs-12">
                                                                <div>
                                                                    <i class="fa fa-credit-card"></i> Thanh toán: 
                                                                    <?php
                                                                    if ($assignment->status_boss == Assignment::STATUS_REQUEST)
                                                                    {
                                                                        echo '<b>Chưa thanh toán</b>';
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    if ($assignment->status_boss == Assignment::STATUS_PAYMENT)
                                                                    {
                                                                        echo '<b>Đã thanh toán</b>';
                                                                    }
                                                                    ?>
                                                                    <a href="javascript:;" class="edit-status click-js" data="payment">Chỉnh sửa</a>
                                                                </div>
                                                                <div class="select-status" id="tabpayment">
                                                                    <p>Số tiền thanh toán:</p>
                                                                    <input class="form-control txt_payment" value='' name="txt_payment">
                                                                    <a href="javascript:;" id="payment" class="btn btn-default" data-id="<?= $assignment->job_id ?>" data-val="<?= number_format($assignment->bid->price - $assignment->deposit->value, 0, '', '') ?>">OK</a>
                                                                    <a href="javascript:;" class="click-js click-cancel">Hủy</a>
                                                                    <div class="clear-fix"></div>
                                                                    <div class="row">
                                                                        <div class="payment-alert text-red col-xs-12"></div>
                                                                    </div>
                                                                    <?php
                                                                    if ($assignment->status_boss == Assignment::STATUS_PAYMENT)
                                                                    {
                                                                        ?>
                                                                        <div class="row">
                                                                            <div class="col-xs-12">
                                                                                <p></p>
                                                                                <?= Html::a('Hủy thanh toán', ['job/unpayment', 'id' => $model->_id], ['class' => 'text-red', 'data' => ['confirm' => 'Hủy xác nhận thanh toán?']]); ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>  
                                                                </div>
                                                            </div>
                                                        </li>    
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <!-- End / button control admin -->
                                            <?php } ?>

                                            <?php
                                            if (($assignment->status_boss == Assignment::STATUS_PAYMENT) && ($model->status == Job::PROJECT_COMPLETED))
                                            {
                                                echo '<li class="row bottom"><div class="col-sm-12 col-xs-12">';
                                                echo Html::a('KẾT THÚC CÔNG VIỆC', ['complete', 'id' => (string) $model->_id], ['class' => 'btn btn-primary']);
                                                echo '</div></li>';
                                            }
                                            ?>

                                            <?php
                                        }
                                        else
                                        {
                                            
                                        }
                                        ?> 
                                        <?php
                                        if ($model->status < Job::PROJECT_COMPLETED)
                                        {
                                            ?>
                                            <li class="row bottom">
                                                <div class="col-sm-6 col-xs-6 text-left">
                                                    <?php
                                                    if ($model->block == Job::JOB_UNBLOCK)
                                                    {
                                                        echo Html::a('Khóa việc', ['job/block', 'id' => $model->_id], ['class' => '', 'data' => ['confirm' => 'Bạn có chắc chắn muốn khóa công việc này?']]);
                                                    }
                                                    if ($model->block == Job::JOB_BLOCK)
                                                    {
                                                        echo Html::a('Mở khóa', ['job/unblock', 'id' => $model->_id], ['class' => '', 'data' => ['confirm' => 'Bạn có chắc chắn muốn mở khóa công việc này?']]);
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-sm-6 col-xs-6 text-right"><?= Html::a('Chỉnh sửa', ['update', 'id' => (string) $model->_id], ['class' => 'btn btn-primary']) ?></div>
                                            </li>
                                        <?php } ?>

                                    </ul>
                                </div>
                            </div>

                        </div>
                        <!-- end project-detail sidebar -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->registerJs('$("#DateCountdown").TimeCircles();') ?>

<?= $this->registerJs('$(".edit-status").click(function(){
        var data = $(this).attr("data");
        $("#tab"+data).fadeIn();
    });
    $(".click-cancel").click(function(){
        $(this).parent().fadeOut();
    })
') ?>
<!-- duyet cong viec -->
<?= $this->registerJs("$('#publish').change(function() {
    var value = $(this).val();
    alert(value);
});") ?>
<!-- xac nhan thanh toán -->
<?= $this->registerJs("$('#payment').click(function() {
    var txt_payment = $('.txt_payment').val();
    var txt_value = $(this).attr('data-val');
    var id = $(this).attr('data-id');
    if(!txt_payment){
        $('.payment-alert').html('Nhập số tiền thanh toán!');
        $('.txt_payment').focus();
    }
    else if(parseInt(txt_payment) < parseInt(txt_value)){
        $('.payment-alert').html('Tiền thanh toán không đủ!');
        $('.txt_payment').focus();
    }else{
        $.ajax({
        url: '/job/payment',
            type: 'post',
            data: {'id':id, 'payment':txt_payment},
            success: function(data) {
                location.reload();
            }
        });
    }  
});") ?>
<!-- xac nhan dat coc -->
<?= $this->registerJs("$('#deposit').click(function() {
    var txt_deposit = $('.txt_deposit').val();
    var txt_value = $(this).attr('data-val');
    var id = $(this).attr('data-id');
    if(!txt_deposit){
        $('.deposit-alert').html('Nhập số tiền đặt cọc!');
        $('.txt_deposit').focus();
    }
    else if(parseInt(txt_deposit) < parseInt(txt_value)){
        $('.deposit-alert').html('Tiền đặt cọc không đủ!');
        $('.txt_deposit').focus();
    }else{
        $.ajax({
        url: '/job/deposit',
            type: 'post',
            data: {'id':id, 'deposit':txt_deposit},
            success: function(data) {
                location.reload();
            }
        });
    }  
});") ?>
<!-- thay doi trang thai cong viec -->
<?= $this->registerJs("$('#publish').click(function() {
    var txt_publish = $('.txt_publish').val();
    var id = $(this).attr('data-id');
    $.ajax({
    url: '/job/publish',
        type: 'post',
        data: {'id':id, 'publish':txt_publish},
        success: function(data) {
            location.reload();
        }
    }); 
});") ?>


<?= $this->registerJs('
$("#job-featured").on("change",function(){    
    $.ajax({
        url:"' . Yii::$app->urlManager->createUrl(["job/featured"]) . '",
        type:"POST",            
        data:$("form#formJob").serialize(),
        dataType:"json",
        success:function(data){     
            if(data==1){
            $(".alert-featured").html("Đã cập nhật thành công!");
            $(".rs-featured").html($("#job-featured option:selected").text());
            } 
            window.setTimeout(function () {
                $(".alert-featured").html("");
            }, 1000);
        }
    });
});

$(".featured").click(function() {
   if( $(".edit-featured").is(":hidden") ) {
    $(".edit-featured").show();
    $(".featured").html("Hủy");
   }else{
    $(".edit-featured").hide();
    $(".featured").html("Chỉnh sửa");
   }
   });

'); ?>
