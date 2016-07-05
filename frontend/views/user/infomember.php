<?php

use yii\helpers\Html;

$this->title = 'Tài khoản của tôi';
?>
<!-- introduce -->
<section>
    <div class="introduce profile-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="title-container">
                        <h3>Trang cá nhân </h3>
                    </div>

                    <div class="row">
                        <!-- box-profile -->
                        <div class="col-md-6 col-sm-6 col-xs-12 ">
                            <div class="box-profile">
                                <div class="title-head">
                                    <h4>
                                        Hồ sơ cá nhân
                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['membership/profile']) ?>">Chi tiết </a>
                                    </h4>
                                </div>
                                <div class="box-content">
                                    <div class="info">
                                        <div class="profile">
                                            <?php
                                            if (!empty($user->avatar))
                                                $avatar = Yii::$app->setting->value('url_file') . 'thumbnails/150-' . $user->avatar;
                                            else if (!empty($user->fbid))
                                                $avatar = '//graph.facebook.com/' . $user->fbid . '/picture?type=large';
                                            else
                                                $avatar = Yii::$app->setting->value('url_file') . 'avatar.png';
                                            ?>
                                            <img src="<?= $avatar; ?>" style="width:100px" class="fa avatar-16 img-circle">
                                        </div>
                                        <div class="profile-content text-left">
                                            <div class="text-left">
                                                <h5>
                                                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['membership/profile']) ?>"><b><?= $user->name ?></b></a>
                                                    <span class="pull-right">Đánh giá: <i class="btn btn-blue"><?= $user->getPoint($user->id); ?></i></span>
                                                </h5>
                                                <p><b><?= !empty($user->findcategory->name) ? $user->findcategory->name : "Ngành nghề: Chưa cập nhật." ?></b></p>
                                                <p>Cấp độ: <b><?= $user->findlevel->name ?></b></p>
                                                <p>
                                                    <i class="fa fa-map-marker"></i> 
                                                    <b>
                                                        <?php
                                                        if (!empty($user->location->name))
                                                        {
                                                            echo $user->location->name . ', ';
                                                        }
                                                        if (!empty($user->location->city->name))
                                                        {
                                                            echo $user->location->city->name;
                                                        }
                                                        else
                                                        {
                                                            echo 'Chưa cập nhật';
                                                        }
                                                        ?>
                                                    </b> - <small>Test năng lực: <?= $user->getTestpoint($user->id); ?></small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <h4>Kinh nghiệm làm việc</h4>
                                            <div class="profile-content">
                                                <ul class="list-unstyled text-left">
                                                    <li><b><?= $user->getCountReview($user->id); ?></b> đánh giá</li>
                                                    <li><b><?= $user->countReview ?></b> đánh giá</li>
                                                    <li><b><?= $user->countjobdone ?></b> việc đã hoàn thành</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <h4>Test năng lực </h4>
                                            <div class="profile-content">
                                                <ul class="list-unstyled text-left">
                                                    <?php
                                                    if (!empty($test))
                                                    {
                                                        foreach ($test as $value)
                                                        {
                                                            $point = number_format($value->point * (10 / $value->category->test_number), 1, '.', '');
                                                            if ($point < 5)
                                                                $rank = '<span class="label label-danger">Yếu</span>';
                                                            elseif ($point >= 5 || $point < 6.5)
                                                                $rank = '<span class="label label-info">Trung bình</span>';
                                                            elseif ($point >= 6.5 || $point < 8)
                                                                $rank = '<span class="label label-success">Khá</span>';
                                                            else
                                                                $rank = '<span class="label label-warning">Tốt</span>';

                                                            $time = $value->category->test_time - number_format(str_replace(':', '.', $value->count_time), 2, '.', '');
                                                            ?>
                                                            <li><b><?= $value->category->name ?></b> <?= $rank ?></li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>

                                </div>  
                            </div> 
                        </div>
                        <!-- End box-profile -->

                        <!-- box-profile -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="box-profile salary">      
                                <div class="title-head">
                                    <h4>
                                        Bảng lương 
                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['paymenthistory/salarytable']) ?>">Chi tiết </a>
                                    </h4>
                                </div>
                                <ul class="list-unstyled">
                                    <li>
                                        Dự án đang làm  <br> 
                                        <b>
                                            <?php
                                            if (!empty($making))
                                            {
                                                $total = 0;
                                                foreach ($making as $paymt)
                                                {
                                                    $total += $paymt->bid->price;
                                                }
                                                echo number_format($total, 0, '', '.') . 'VNĐ';
                                            }
                                            ?>
                                        </b>
                                    </li>
                                    <li>
                                        Lương tháng này  <br> 
                                        <b>
                                            <?php
                                            if (!empty($job_thismonth))
                                            {
                                                $total = 0;
                                                foreach ($job_thismonth as $paymt)
                                                {
                                                    $total += $paymt->bid->price;
                                                }
                                                echo number_format($total, 0, '', '.') . 'VNĐ';
                                            }
                                            ?>
                                        </b>
                                    </li>
                                    <li class="last-child">
                                        Tổng lương đã nhận  <br> 
                                        <b>
                                            <?php
                                            if (!empty($completed))
                                            {
                                                $total = 0;
                                                foreach ($completed as $paymt)
                                                {
                                                    $total += $paymt->bid->price;
                                                }
                                                echo number_format($total, 0, '', '.') . 'VNĐ';
                                            }
                                            ?>
                                        </b>
                                    </li>
                                    <div class="clear-fix"></div>
                                </ul>       
                                <div class="box-content select-item">
                                    <b>Lịch sử công việc đã hoàn thành </b>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <?php
                                                if (!empty($completed))
                                                {
                                                    foreach ($completed as $value)
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $value->job->slug . '-' . (string) $value->job->_id) ?>"><b><?= $value->job->name ?></b></a>
                                                            </td>
                                                            <td class="text-right">
                                                                30.000.000 VNĐ
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>    
                            </div>            
                        </div>
                        <!-- End box-profile -->
                    </div>    


                    <div class="row">
                        <!-- box-profile -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="box-profile">
                                <div class="title-head">
                                    <h4>
                                        Công việc đang làm
                                        <?= Html::a('Chi tiết', ['membermanage/index']); ?>
                                    </h4>
                                </div>
                                <div class="box-content">
                                    <ul class="list-unstyled list-project">
                                        <?php
                                        if (!empty($making))
                                        {
                                            foreach ($making as $value)
                                            {
                                                $job = $value->job;
                                                ?>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-sm-8 col-xs-12">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </div>
                                                        <div class="col-sm-4 col-sx-12 progress-tast">
                                                            <div class="progress">
                                                                <?php
                                                                $progress = ((time() - $job->assignment->startday) / (($job->assignment->startday + (86400 * $job->assignment->bid->period)) - $job->assignment->startday)) * 100;
                                                                ?>
                                                                <div style="width: <?= $progress ?>%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?= $progress ?>" role="progressbar" class="progress-bar">
                                                                </div> 
                                                            </div>
                                                            <p class="text-gray"><?= number_format($progress, 0, '.', '') ?>%  hoàn thành</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <li>
                                                <p>Bạn chưa có công việc nào đã book  trên hệ thống, hãy tìm kiếm công việc phù hợp với bạn . </p>
                                                <strong><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/index']) ?>" class="text-blue" title="tìm công việc">Tìm kiếm công việc</a></strong>
                                            </li>
                                        <?php } ?>
                                        <div class="clear-fix"></div>
                                    </ul>
                                </div>  
                            </div>          
                        </div>
                        <!-- End box-profile -->

                        <!-- box-profile -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="box-profile">
                                <div class="title-head">
                                    <h4>
                                        Công việc đã book
                                        <?= Html::a('Chi tiết', ['membermanage/index']); ?>
                                    </h4>
                                </div>
                                <div class="box-content">
                                    <ul class="list-unstyled list-project">
                                        <?php
                                        if (!empty($jobbid))
                                        {
                                            foreach ($jobbid as $job)
                                            {
                                                ?>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->job->slug . '-' . $job->job->id) ?>"><b><?= $job->job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->job->category->name ?></p>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-6 text-right">
                                                            <p><?= $job->job->budget ?></p>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-6 text-right">
                                                            <p>Đã book </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <li>
                                                <p>Bạn chưa có công việc nào đã book  trên hệ thống, hãy tìm kiếm công việc phù hợp với bạn . </p>
                                                <strong><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/index']) ?>" class="text-blue" title="tìm công việc">Tìm kiếm công việc</a></strong>
                                            </li>
                                        <?php } ?>
                                        <div class="clear-fix"></div>
                                    </ul>
                                </div> 
                            </div>    
                        </div>
                        <!-- End box-profile -->
                    </div>    

                    <div class="row">
                        <!-- box-profile -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="box-profile message">      
                                <div class="title-head">
                                    <h4>
                                        Tin nhắn 
                                        <a  href="<?= Yii::$app->urlManager->createAbsoluteUrl('tin-nhan/' . $user->slug) ?>">Chi tiết</a>
                                    </h4>
                                </div>
                                <div class="box-content select-item">
                                    <ul class="scroll scrollTo">
                                        <?php
                                        foreach ($messages as $value)
                                        {

                                            if ($value->owner == (string) \Yii::$app->user->identity->id)
                                                $user = $value->useractor;
                                            else
                                                $user = $value->userowner;
                                            if ((string) $user->_id != (string) \Yii::$app->user->identity->id)
                                            {
                                                ?>

                                                <div class="media" id="idm-<?= (string) $value->_id ?>">
                                                    <a  href="<?= Yii::$app->urlManager->createAbsoluteUrl('tin-nhan/' . $user->slug) ?>">
                                                        <div class="media-left">
                                                            <img class=" avatar" width="50" src="<?= Yii::$app->setting->value('url_file') ?>/thumbnails/<?= !empty($user->avatar) ? '150-' . $user->avatar : "avatar.png" ?>">

                                                        </div>
                                                        <div class="media-body">
                                                            <h4 class="media-heading"><?= $user->name ?></h4>
                                                            <small>
                                                                <?php
                                                                $content = $value->conversation((string) $value->_id);
                                                                if (!empty($content))
                                                                    echo $content[count($content) - 1]->content;
                                                                ?>
                                                            </small>
                                                        </div>
                                                    </a>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>


                                    </ul>
                                </div>    
                            </div>            
                        </div>
                        <!-- End box-profile -->

                        <!-- box-profile -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="box-profile salary">      
                                <div class="title-head">
                                    <h4>
                                        Lưu việc 
                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['membermanage/savejob']) ?>">Chi tiết </a>
                                    </h4>
                                </div>
                                <div class="box-content select-item ">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <?php
                                                if (!empty($jobsave))
                                                {
                                                    foreach ($jobsave as $value)
                                                    {
                                                        $job = $value->job;
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '-' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a>
                                                                <p class="text-gray"><?= $job->category->name ?></p>
                                                            </td>
                                                            <td class="text-right">
                                                                <a class="btn btn-blue book" href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '-' . (string) $job->_id) ?>">Chi tiết</a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                else
                                                {
                                                    ?>
                                                    <tr>
                                                        <td colspan="2">
                                                            <p>Bạn chưa có công việc nào đã lưu trên hệ thống, hãy tìm kiếm công việc phù hợp với bạn . </p>
                                                            <strong><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/index']) ?>" class="text-blue" title="tìm công việc">Tìm kiếm công việc</a></strong>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>    
                            </div>            
                        </div>
                        <!-- End box-profile -->
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>
<!-- End introduce -->
