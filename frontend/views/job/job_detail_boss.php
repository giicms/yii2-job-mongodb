<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\AssignmentStep;
use common\models\PaymentHistory;
use common\models\Assignment;
use common\models\Job;

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    textarea.auto-height {
        min-height: 38px !important;
        overflow-x: hidden
    }
</style>
<section>
    <div class="introduce job-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12">

                    <h2 class="job-title text-blue"><?= $this->title ?></h2>
                    <p><label class="button"><?= $model->category->name ?></label> <?= $model->getStatus($model->_id); ?> Đăng cách đây <?= Yii::$app->convert->time($model->created_at) ?></p>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p>Hạn nhận chào giá: <br><b><?= date('d/m/Y', $model->deadline) ?></b></p>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p>
                                Ngân sách dự kiến: <br>
                                <b><?= $model->budget; ?></b>
                            </p>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p>Nhân viên book việc:<br><b><?= count($model->getBId()) ?> </b> </p>
                        </div>
                    </div>
                </div> 


                <!-- button book -->
                <div class="col-md-4 col-sm-12 col-xs-12 profile-member">
                    <div class="profile-content">
                        <div>
                            <!-- Single button -->
                            <?php
                            if ($model->owner == \Yii::$app->user->identity->id)
                            {
                                if (empty($assignment))
                                {
                                    ?>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-square dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Chỉnh sửa<span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><?= Html::a('<i class="fa fa-pencil"></i>  Sửa việc', ['job/update', 'id' => (string) $model->_id]) ?></li>
                                            <li><?= Html::a('<i class="fa fa-trash-o"></i>  Đóng việc', 'javascript:void(0)', ['class' => 'job-close']) ?></li>
                                            <div class="clear-fix"></div>
                                        </ul>
                                    </div>
                                    <?= Html::a('Đăng việc', ['job/create'], ['class' => 'btn btn-blue']) ?>
                                    <?php
                                }
                                else
                                {
                                    
                                }
                            }
                            ?>
                            <div class="clear-fix"></div>
                        </div>
                    </div>
                </div>
                <!-- End button book -->


                <div class="col-md-8 col-sm-12 col-xs-12">   

                    <!-- Thông tin thanh toán -->
                    <?php
                    if ($model->owner == \Yii::$app->user->identity->id)
                    {
                        if (!empty($assignment))
                        {
                            $deposit = $model->category->deposit;  //% đặt cọc
                            if ($deposit == 0 || empty($deposit))
                            { //nếu không vần đặt cọc, thanh toán 100% khi công việc kết thúc
                                if ($assignment->status_boss >= Assignment::STATUS_REQUEST)
                                { //nếu công việc đã được xác nhận hoàn thành
                                    echo $this->render('_payment', [ 'model' => $model]);
                                }
                            }
                            if ($deposit > 0 && $deposit < 100)
                            { // nếu công việc cần đặt cọc trước khi làm việc
                                if ($assignment->status_boss == Assignment::STATUS_GIVE)
                                { //nếu công việc đã được xác nhận hoàn thành
                                    echo $this->render('_deposit', [ 'model' => $model]);
                                }
                            }
                            if ($deposit == 100)
                            { // nếu công việc phải thanh toán trươc khi làm việcs
                                if ($assignment->status_boss == Assignment::STATUS_GIVE)
                                { //nếu công việc đã được giao cho nhân viên
                                    echo $this->render('_deposit', [ 'model' => $model]);
                                }
                            }
                        }
                    }
                    ?>
                    <!-- End / thông tin thanh toán -->

                    <!-- mo ta cong viec -->
                    <div class="x_panel tile">
                        <div class="x_title">
                            <h2>Mô tả công việc</h2>
                            <ul class="nav navbar-right panel_toolbox text-right">
                                <li class="pull-right"><a class="collapse-link"  ><i data-toggle="collapse" data-target="#jobcontent" class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div id="jobcontent" class="x_content collapse in">
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
                            <?= nl2br($model->description) ?>
                            <p>
                                <?php
                                if (!empty($model->file))
                                {
                                    ?>
                                    <i class="fa fa-paperclip fa-2x"></i> 
                                    <a href="<?= $model->file[0] ?>"><strong>Mở file đính kèm</strong></a>
                                    <?php
                                }
                                ?>
                            </p>
                        </div>
                    </div> 
                    <!-- END / mo ta cong viec -->

                    <div class="list-project book-forboss">

                        <ul class="nav nav-tabs">
                            <li class="active" id="tab1"><a data-toggle="tab" href="#tab-1">Nhân viên book việc  (<?= count($model->bid) ?>)</a></li>
                            <li id="tab1"><a data-toggle="tab" href="#tab-2">Nhân viên được mời  (<?= !empty($userInvited) ? count($userInvited) : "0" ?>)</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane fade in active">
                                <?php
                                $user_bid = $model->getBid();
                                if (!empty($user_bid))
                                {
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr><th>Nhân viên</th><th></th><th class="text-right" >Thành tựu</th><th class="text-right" >Giá nhận việc (VND)</th></tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($user_bid as $value)
                                                {
                                                    ?>
                                                    <tr class="bid_<?= (string) $value->_id ?>">
                                                        <td style="width: 15%">
                                                            <div class="info">
                                                                <div class="profile">
                                                                    <img class="img-circle avatar" width="100" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($value->user->avatar) ? '150-' . $value->user->avatar : "avatar.png" ?>">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="width: 25%">
                                                            <div class="info">
                                                                <p><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . (string) $value->user->slug) ?>" title="<?= $value->user->name ?>"><b><?= $value->user->name ?></a></b></a></p>
                                                                <p><b><?= !empty($value->user->category->name) ? $value->user->category->name : "" ?></b></p>

                                                                <p><span class="text-gray">Test năng lực: 6</span></p>
                                                            </div>
                                                        </td>
                                                        <td class="text-right" style="width: 35%">
                                                            <p><b><?= !empty($value->user->findlevel->name) ? $value->user->findlevel->name : "" ?></b></p>
                                                            <p><b>56</b> việc làm đã nhận</p>
                                                            <p><b>100%</b> công việc hoàn thành</p>
                                                            <p>
                                                                Đánh giá:  
                                                                <span class="star text-blue">
                                                                    <?= $value->user->getRating($value->user->_id); ?>
                                                                </span>
                                                            </p>

                                                        </td>
                                                        <td class="text-right" style="width: 25%">
                                                            <?php
                                                            if (\Yii::$app->info->isboss() && ($model->owner == \Yii::$app->user->identity->id))
                                                            {
                                                                ?>
                                                                <h3 class="text-blue"><?= number_format($value->price, 0, '', '.') ?></h3>
                                                                <p class="text-gray"><?= Yii::$app->convert->time($value->created_at) ?></p>
                                                                <p>
                                                                    <!-- neu nhan vien da duoc giao viec -->
                                                                    <?php
                                                                    if (!empty($assignment) && ($assignment->actor == $value->user->_id))
                                                                    {
                                                                        echo '<button style="width:100%;" type="button" class="btn btn-red btn-blue">Đã giao việc</button>';
                                                                        echo '<a class="btn btn-square" href="' . Yii::$app->urlManager->createAbsoluteUrl('tin-nhan/' . $value->user->slug) . '" target="_blank">Trao đổi </a>';
                                                                    }
                                                                    else if (!empty($assignment) && ($assignment->actor != $value->user->_id))
                                                                    {
                                                                        ?>
                                                                        <span class="button">Thuê</span>
                                                                        <span class="button">Từ chối</span>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <?= Html::a('Thuê', ['assignment/committed', 'id' => (string) $value->_id], ['class' => 'btn btn-blue']) ?>
                                                                        <a title="Từ chối" class="btn btn-blue"  data-id="<?= (string) $value->_id ?>" data-toggle="modal" data-target="#deny">Từ chối</a>

                                                                        <a class="btn btn-square" href="<?= Yii::$app->urlManager->createAbsoluteUrl('tin-nhan/' . $value->user->slug) ?>" target="_blank">Trao đổi </a>
                                                                    <?php } ?>
                                                                </p>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <p class="text-gray"><?= Yii::$app->convert->time($value->created_at) ?></p>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    if (\Yii::$app->info->isboss() && ($model->owner == \Yii::$app->user->identity->id))
                                                    {
                                                        ?>
                                                        <tr><?= $value->content; ?></tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    echo 'Chưa có nhân viên book việc nào';
                                }
                                ?>
                            </div>
                            <div id="tab-2" class="tab-pane fade in">
                                <?php
                                if (!empty($userInvited))
                                {
                                    foreach ($userInvited as $invited)
                                    {
                                        $value = $invited->user;
                                        ?>
                                        <div class="profile-item user-<?= (string) $value->_id ?>">
                                            <input type="hidden" id="user_id" value="<?= (string) $value->_id ?>">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="profile">
                                                        <img class="avatar img-circle" width="100" src="<?= Yii::$app->params['url_file'] ?>thumbnails/<?= !empty($value->avatar) ? '150-' . $value->avatar : "avatar.png" ?>">
                                                        <div class="num-review">
                                                            <h5>Đánh giá: </h5> <span>5.0</span>
                                                        </div>
                                                    </div>
                                                    <div class="profile-content">
                                                        <ul class="list-unstyled text-left">
                                                            <li>
                                                                <h5>
                                                                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $value->slug) ?>" class="name"><b><?php echo $value->name ?></b></a>
                                                                    <small> - Hoạt động cách đây <?= Yii::$app->convert->time($value->created_at) ?></small>
                                                                </h5>
                                                            </li>
                                                            <li><b><?= !empty($value->findcategory->name) ? $value->findcategory->name : "" ?></b></li>
                                                            <li>Cấp độ: <b><?= !empty($value->findlevel->name) ? $value->findlevel->name : "" ?></b></li>
                                                            <li>
                                                                <i class="fa fa-map-marker"></i> 
                                                                <b><?= $value->location->name ?>, <?= $value->location->city->name ?></b> - <small>Test năng lực: <?= $value->getTestpoint($value->id) ?></small>
                                                            </li>
                                                            <li class="skill-pro">
                                                                <ul class="list-unstyled">
                                                                    <?php
                                                                    if (!empty($value->skills))
                                                                    {
                                                                        foreach ($value->skills as $k => $skill)
                                                                        {
                                                                            if ($k > 5)
                                                                                $dis = 'none';
                                                                            else
                                                                                $dis = 'block';
                                                                            $getskill = $value->getSkills($skill);
                                                                            echo '<li class="pull-left" style="display:' . $dis . '"><span class="label label-default">' . $getskill['name'] . '</span></li> ';
                                                                        }
                                                                        echo '<li class="pull-left"><a href="#"><strong>Xem thêm</strong></a></li>';
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </li>
                                                        </ul>

                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="profile-content">
                                                        <ul class="list-unstyled">
                                                            <?php
                                                            if (!\Yii::$app->user->isGuest)
                                                            {
                                                                if (\Yii::$app->info->isboss())
                                                                {
                                                                    ?>
                                                                    <li class="options">
                                                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('/tin-nhan/' . $value->slug) ?>" class="btn btn-blue">Liên hệ</a> 
                                                                    </li>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <li><b>31</b> đánh giá</li>
                                                            <li><b>56</b> việc làm đã nhận</li>
                                                            <li><b>100%</b> công việc đã hoàn thành</li>

                                                        </ul>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- profile boss -->
                <div class="col-md-4 col-sm-12 col-xs-12 members-request profile-member ">
                    <div class="profile-content"> 
                        <?php
                        if (!empty($assignment))
                        {
                            ?>  
                            <div class="well profile-member">
                                <h4 class="title-box"><strong>Thông tin công việc</strong></h4>
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
                                        <div class="col-sm-7 col-xs-7"><?php
                                            if (!empty($assignment))
                                            {
                                                echo number_format($assignment->bid->price, 0, '', '.');
                                            }
                                            else
                                            {
                                                echo '...';
                                            }
                                            ?> VNĐ</div>
                                    </li>
                                    <?php
                                    if ($assignment->status_boss < Assignment::STATUS_COMPLETE)
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
                                                        <?= number_format($assignment->bid->price - $assignment->deposit->value, 0, '', '.') ?>VNĐ
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
                                    <?php
                                    if ($assignment->status_boss >= Assignment::STATUS_COMMITMENT)
                                    {
                                        ?>
                                        <li class="row">
                                            <div class="col-sm-5 col-xs-5">Ngày bắt đầu</div>
                                            <div class="col-sm-7 col-xs-7"><?= date('d/m/Y', $assignment->startday); ?></div>
                                        </li>
                                    <?php } ?>
                                    <?php
                                    if (($assignment->status_boss == Assignment::STATUS_COMPLETE) && ($assignment->status_boss == Assignment::STATUS_REVIEW))
                                    {
                                        ?>
                                        <li class="row">
                                            <div class="col-sm-5 col-xs-5">Ngày kết thúc</div>
                                            <div class="col-sm-7 col-xs-7"><?= date('d/m/Y', $assignment->endday); ?></div>
                                        </li>
                                    <?php } ?>
                                    <li class="row">
                                        <div class="col-sm-5 col-xs-5">Trạng thái</div>
                                        <div class="col-sm-7 col-xs-7"><?= $model->getStatus($model->_id); ?></div>
                                    </li>
                                </ul>
                            </div>
                            <?php
                        }
                        else
                        {
                            ?>    
                            <h4 class="title-box"><strong>Gợi ý nhân viên phù hợp với dự án </strong></h4>
                            <div class="well">
                                <!-- member item -->
                                <?php
                                if (!empty($users))
                                {
                                    foreach ($users as $value)
                                    {
                                        $checkInvited = $value->jobinvited((string) $value->_id, (string) $model->_id);
                                        if (empty($checkInvited))
                                        {
                                            ?>
                                            <div class="member-request profile-item item-<?= (string) $value->_id ?>">
                                                <div class="profile">
                                                    <img width="100" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($value->avatar) ? '150-' . $value->avatar : "avatar.png" ?>" class="img-circle avatar">
                                                </div>
                                                <div class="profile-content">
                                                    <ul class="list-unstyled">
                                                        <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $value->slug) ?>" title="<?= $value->name ?>"><b><?= $value->name ?></b></a>
                                                            <input type="hidden" id="<?= (string) $value->_id ?>-name" value="<?= $value->name ?>"/>
                                                        </li>
                                                        <li><?= !empty($value->findlevel->name) ? $value->findlevel->name : "" ?> </li>
                                                        <li>100% công việc hoàn thành </li>
                                                        <li>Đánh giá: 
                                                            <span class="star text-blue">
                                                                <?= $value->getRating($value->_id); ?>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-sm-12 button-box">
                                                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('tin-nhan/' . $value->slug) ?>" class="btn btn-square" target="_blank">Trao đổi</a>
                                                    <a href="#" class="btn btn-blue invited" data-toggle="modal" data-target="#modal" data-user="<?= (string) $value->_id ?>" title="Mời nhân viên">Mời</a> 
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>

                                <!-- End member item -->

                                <!-- member item -->

                            </div>
                        <?php } ?>    
                    </div>  
                </div>
                <!-- End profile boss -->


            </div>
        </div>
    </div>
    <input type="hidden" id="job_id" value="<?= (string) $model->_id ?>">
</section>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Mời nhân viên</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['id' => 'formInvited', 'options' => ['class' => 'form-horizontal']]); ?>  
                <div class="form-group">
                    <label class="col-md-4 col-sm-4 col-xs-12">Tiêu đề công việc</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <strong class="job-name"><?= $model['name'] ?></strong>
                        <input type="hidden" name="JobInvited[job_id]" value="<?= (string) $model['_id'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 col-sm-4 col-xs-12">Nhân viên</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <strong class="modal-user-name"></strong>
                        <input type="hidden" id="jobinvited-actor" name="JobInvited[actor]"/>
                    </div>
                </div>
                <?= $form->field($invited, 'message', ['template' => '<label class="col-md-4 col-sm-4 col-xs-12">' . $invited->getAttributeLabel('message') . '</label><div  class="col-md-8 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textarea() ?>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <div class="success"></div>
                        <button id="submitInvited" type="submit" class="btn btn-default btn-boss">Mời nhận việc</button>
                        <a href="#"  data-dismiss="modal" class="alert"><strong>Hủy</strong></a>
                    </div>
                </div>
                <input type="hidden" id="count-user" value="<?= count($users) ?>">
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deny" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Từ chối</h4>
            </div>
            <div class="modal-body">
                <p>Bạn có muốn từ chối nhân viên này không!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Không từ chối</button>
                <a class="btn btn-danger btn-ok" href="javascript:void(0)">Từ chối</a>
            </div>
        </div>
    </div>
</div>
<?php
if ($countjobclose <= Yii::$app->setting->value("job_close"))
    $comf = 'Bạn đã hủy việc lần ' . Yii::$app->setting->value("job_close") . '. Tài khoản của bạn sẽ bị block?';
else
    $comf = '';
?>
<?=
$this->registerJs('$(document).ready(function ()
{
    $(document).on("click", ".job-close", function () {
        var comfirm = confirm("Bạn có chắc muốn đóng công việc này không. ' . $comf . '");
        if(comfirm){ 
            var id = "' . $model->_id . '";
                 $.ajax({
                type: "POST", 
                url:"' . Yii::$app->urlManager->createUrl(["job/jobclose"]) . '", 
                data: { id : id}, 
                success: function (data) {
                    if(data=="ok"){
                        window.location.href = "' . Yii::$app->urlManager->createUrl(["bossmanage/jobclose"]) . '";        
                    }
                },    
            });
        }
    });

});
');

$this->registerJs('$("#modal").on("show.bs.modal", function (event) {
  var button = $(event.relatedTarget) ;
  var user = button.data("user");
  var name = $("#"+user+"-name").val();
  var modal = $(this);
  modal.find(".modal-body .modal-user-name").text(name);
  modal.find(".modal-body input#jobinvited-actor").val(user);
  $(".success").html("");
});

');
?>



<?= $this->registerJs("$(document).on('submit', '#formInvited', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["job/jobinvited"]) . "',
            type: 'post',
            data: $('form#formInvited').serialize(),
            success: function(data, status) {
            if(data){
                $('.success').html('<p class=\"alert alert-success\" role=\'alert\'>Bạn đã mời thành công</p>');
                          window.setTimeout(function () {
                           $('#modal').modal('hide');
            }, 1000);
             window.location.href = '" . $_SERVER['REQUEST_URI'] . "';    
                }
            }
        });

});") ?>

<?= $this->registerJs("$(document).on('click', '.square', function (event){
        document.getElementById('tab2').classList.add('active');
        document.getElementById('tab1').classList.remove('active');
        var id = $(this).attr('data-bind');
 
            $.ajax({
            url: '/messages/square?user_id='+id+'&job_id=" . (string) $model->_id . "',
            type: 'get',
            success: function(data) {
            $('.comment-list').html('');
            $('.messages-header').html('');
            $('.comment-list').attr('id','setInterval-'+id);
            $('#message-id').val(data.message.message_id);
            $('#user-2').val(id);
            $('#messages-header').tmpl(data.message).appendTo('.messages-header');
            var content = data.content;
           for (i=0; i< data.content.length; i++){
            var item = data.content[i];
              $('#list-messages').tmpl(item).appendTo('.comment-list');
             }
                setInterval(function(){
             $('#setInterval-'+id).load( '/messages/item?user_id='+id+'&job_id=" . (string) $model->_id . "');
           },500);
           
            }
          
        });

        event.preventDefault();

});") ?>


<?= $this->registerJs("$(document).on('keypress', '#commentMessage', function (event) {
    var code = (event.keyCode ? event.keyCode : event.which);
    if (code == '13' && !event.shiftKey)
    {
            $.ajax({
                type: 'POST',
                        url: '" . Yii::$app->urlManager->createUrl(["messages/create"]) . "',
                      data: $('form#formMessages').serialize(),
                cache: false,
                success: function (data) {
             $('#commentMessage').val('');
                }
            });
     
    }
    //return false;
});") ?>

<?= $this->registerJs("$(document).on('click', '.item-message', function (event){
        var id = $(this).attr('data-bind');
        $('.comment .mCustomScrollBox .mCSB_container').html('');
            $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/listmessage"]) . "',
            type: 'post',
            data: {'id':id},
            success: function(result) {
            $('#message-id').val(result.message_id);
                $('#user-2').val(result.user_2);
                $.template( 'movieTemplate', markup );
                $.tmpl( 'movieTemplate', result.data ).appendTo('.comment .mCustomScrollBox .mCSB_container');
            }
});
        event.preventDefault();

});
$('textarea.auto-height').textareaAutoSize();
$('#deny').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('data-id', $(e.relatedTarget).data('id'));
});
") ?>
<?= $this->registerJs("$('.btn-ok').click(function() {
     var id = $(this).attr('data-id');
       $.ajax({
        url: '/bid/deny',
            type: 'post',
            data: {'id':id},
            success: function(data) {
            if(data == 'ok'){
                $('tr.bid_'+id).remove();
                $('#deny').modal('hide');
                }
            }
        });
});") ?>
<?= $this->registerJs("$(document).ready(function(){
    $('.tab-payment .methodpayment').click(function() {
        var div = $(this).attr('id');
        $('.selected').removeClass( 'selected' );
        $( this ).parent().addClass( 'selected' );
    });
});") ?>
