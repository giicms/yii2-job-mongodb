<?php

use yii\helpers\Html;

$this->title = 'Tài khoản của tôi'
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
                                        <?= Html::a('Chi tiết', ['boss/profile']); ?>
                                    </h4>
                                </div>
                                <div class="box-content">
                                    <div class="info">
                                        <div class="profile">

                                            <img src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($user->avatar) ? '150-' . $user->avatar : "avatar.png" ?>" style="width:100px" class="fa avatar-16 img-circle">
                                        </div>
                                        <div class="profile-content">
                                            <div class="text-left">
                                                <h5><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['boss/profile']) ?>"><b><?= $user->name ?></b></a></h5>
                                                <p>
                                                    Đánh giá: 
                                                    <span class="star text-blue">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </span> 5.0
                                                </p>
                                                <p>
                                                    <i class="fa fa-map-marker"></i>
                                                    <?php 
                                                    if(!empty($user->location->name)){echo $user->location->name.', ';}
                                                    if(!empty($user->location->city->name)){echo $user->location->city->name;}else{echo 'Chưa cập nhật';}
                                                    ?>
                                                </p> 
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php
                                    if (!empty($user->company_name)) {
                                        ?>
                                        <h4>Thông tin công ty </h4>
                                        <p><b>Tên công ty: </b><?= $user->company_name ?></p>
                                        <p><b>Địa chỉ: </b><?= $user->address . ', ' . $user->location->name . ', ' . $user->location->city->name ?></p>
                                        <p><b>Số đăng ký kinh doanh: </b><?= $user->company_code ?></p>
                                    <?php } ?>
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
                                        <a href="#">Chi tiết </a>
                                    </h4>
                                </div>
                                <ul class="list-unstyled">
                                    <li>
                                        Dự án chờ đặt cọc <br> <b>4.000.000 VND  </b>
                                    </li>
                                    <li>
                                        Đề nghị thanh toán <br> <b>3.000.000 VND</b>
                                    </li>
                                    <li class="last-child">
                                        Lịch sử thanh toán <br> <b>23.000.000 VND</b>
                                    </li>
                                    <div class="clear-fix"></div>
                                </ul>       
                                <div class="box-content select-item">
                                    <b>Lịch sử công việc đã hoàn thành </b>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <?php
                                                if (!empty($completed)) {
                                                    foreach ($completed as $value) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $value->slug . '/' . (string) $value->_id) ?>"><b><?= $value->name ?></b></a>
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
                                        Dự án đang làm
                                        <?= Html::a('Chi tiết', ['bossmanage/jobmanage' . '#du-an-dang-lam']); ?>
                                    </h4>
                                </div>
                                <div class="box-content">
                                    <ul class="list-unstyled list-project">
                                        <?php
                                        if (!empty($making)) {
                                            foreach ($making as $value) {
                                                ?>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-sm-8 col-xs-12">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $value->slug . '/' . (string) $value->_id) ?>"><b><?= $value->name ?></b></a>
                                                            <p class="text-gray"><?= $value->category->name ?></p>
                                                        </div>
                                                        <div class="col-sm-4 col-sx-12 progress-tast">
                                                            <div class="progress">
                                                                <?php
                                                                $progress = ((time() - $value->assignment->startday) / (($value->assignment->startday + (86400 * $value->assignment->bid->period)) - $value->assignment->startday)) * 100;
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
                                        } else {
                                            ?>
                                            <li>
                                                <p>Bạn chưa có công việc nào đang được tiến hành trên hệ thống, Hãy tìm kiếm nhân viên tốt nhất dành cho các công việc của bạn. </p>
                                                <strong><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['membership/index']) ?>" class="text-blue" title="tìm nhân viên">Tìm kiếm nhân viên </a></strong>
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
                                        Dự án đang chờ
                                        <?= Html::a('Chi tiết', ['bossmanage/jobmanage' . '#du-an-dang-cho']); ?>
                                    </h4>
                                </div>
                                <div class="box-content">
                                    <ul class="list-unstyled list-project">
                                        <?php
                                        if (!empty($pending)) {
                                            foreach ($pending as $job) {
                                                ?>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-6 text-right">
                                                            <p><?= count($job->bid) ?> lượt book</p>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-6 text-right">
                                                            <p>Chờ giao việc</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <li>
                                                <p>Bạn chưa có công việc nào cần thuê trên hệ thống, Đăng việc để nhân viên của chúng tôi giúp bạn hoàn thành công việc</p>
                                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/create']) ?>" class="btn btn-blue" title="Đăng việc">Đăng việc</a>
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
                                        <?= Html::a('Chi tiết', ['messages/index']); ?>
                                    </h4>
                                </div>
                                <div class="box-content select-item">
                                    <ul class="scroll scrollTo">

                                        <?php
                                        if (!empty($conversation)) {
                                            foreach ($conversation as $value) {
                                                ?>
                                                <li class="media">
                                                    <a  href="<?= Yii::$app->urlManager->createAbsoluteUrl('tin-nhan/' . $value->owners->slug) ?>">
                                                        <div class="media-left">
                                                            <img class="img-circle avatar" width="50" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($value->owners->avatar) ? '150-' . $value->owners->avatar : "avatar.png" ?>">

                                                        </div>
                                                        <div class="media-body">
                                                            <h4 class="media-heading"><?= $value->owners->name ?></h4>
                                                            <small>
                                                                <?php
                                                                echo $value->content;
                                                                ?>
                                                            </small>
                                                        </div>
                                                    </a>
                                                </li>
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
                                        Lưu nhân viên 
                                        <?= Html::a('Chi tiết', ['bossmanage/member']); ?>
                                    </h4>
                                </div>
                                <div class="box-content select-item ">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <?php
                                                if (!empty($model)) {
                                                    foreach ($model as $key => $value) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <img class="img-circle avatar pull-left" width="40" src="images/customer/3.jpg">
                                                                <a href="/Bo_chi_tiet_cong_viec.html"><b>Thiết kế logo cho Công ty BDS</b></a>
                                                                <p class="text-gray">Thiết kế đồ họa</p>
                                                            </td>
                                                            <td class="text-right">
                                                                <a class="btn btn-blue" href="/Bo_dat_coc.html">Liên hệ</a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td colspan="2">
                                                            <p>Chưa có nhân viên nào được lưu, hãy tìm kiếm nhân viên tốt nhất dành cho các công việc của bạn. </p>
                                                            <strong><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['membership/index']) ?>" class="text-blue" title="tìm nhân viên">Tìm kiếm nhân viên </a></strong>
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
