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
                                        <div class="profile-content">
                                            <div class="text-left">
                                                <h5><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['boss/profile']) ?>"><b><?= $user->name ?></b></a></h5>
                                                <p>
                                                    Đánh giá: 
                                                    <span class="star text-blue">
                                                        <?= $user->getStar($user->rating); ?>
                                                    </span> <?= $user->getCountReview($user->_id); ?><i class="fa fa-user"></i>
                                                </p>
                                                <p>
                                                    <i class="fa fa-map-marker"></i> 
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
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php
                                    if (!empty($user->company_name))
                                    {
                                        ?>
                                        <h4>Thông tin công ty </h4>
                                        <p><b>Tên công ty: </b><?= $user->company_name ?></p>
                                        <p>
                                            <b>Địa chỉ: </b>
                                            <?php
                                            if (!empty($user->address))
                                            {
                                                echo $user->address . ', ';
                                            }
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
                                        </p>
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
                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['paymenthistory/paymenthistory']) ?>">Chi tiết</a>
                                    </h4>
                                </div>
                                <ul class="list-unstyled">
                                    <li>
                                        Dự án chờ đặt cọc <br> 
                                        <b>
                                            <?php
                                            if (!empty($deposit))
                                            {
                                                $total = 0;
                                                foreach ($deposit as $depos)
                                                {
                                                    $deposit_price = $depos->category->deposit;
                                                    if ($deposit_price > 0 && $deposit_price < 100)
                                                    {
                                                        $price = $depos->assignment->bid->price * $deposit_price / 100;
                                                    }
                                                    else
                                                    {
                                                        $price = $depos->assignment->bid->price;
                                                    }
                                                    $total += $price;
                                                }
                                                echo number_format($total, 0, '', '.') . 'VNĐ';
                                            }
                                            ?>
                                        </b>
                                    </li>
                                    <li>
                                        Đề nghị thanh toán <br> 
                                        <b>
                                            <?php
                                            if (!empty($payment))
                                            {
                                                $total = 0;
                                                foreach ($payment as $paymt)
                                                {
                                                    $deposit_price = $paymt->category->deposit;
                                                    if (($deposit_price > 0) && ($deposit_price < 100))
                                                    {
                                                        $price = $paymt->assignment->bid->price - $paymt->assignment->deposit->value;
                                                    }
                                                    if (($deposit_price == 0) && (empty($deposit_price)))
                                                    {
                                                        $price = $paymt->assignment->bid->price;
                                                    }
                                                    $total += $price;
                                                }
                                                echo number_format($total, 0, '', '.') . 'VNĐ';
                                            }
                                            ?>
                                        </b>
                                    </li>
                                    <li class="last-child">
                                        Lịch sử thanh toán <br> 
                                        <b>
                                            <?php
                                            if (!empty($payment_history))
                                            {
                                                $total = 0;
                                                foreach ($payment_history as $val)
                                                {
                                                    $total += $val->value;
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
                                                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $value->slug . '-' . (string) $value->_id) ?>"><b><?= $value->name ?></b></a>
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
                                        if (!empty($making))
                                        {
                                            foreach ($making as $value)
                                            {
                                                ?>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $value->slug . '-' . (string) $value->_id) ?>"><b><?= $value->name ?></b></a>
                                                            <p class="text-gray"><?= $value->category->name ?></p>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-6 text-right">
                                                            <p><?= $job->budget ?></p>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-6 text-right">
                                                            <p>Đang làm</p>
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
                                        if (!empty($pending))
                                        {
                                            foreach ($pending as $job)
                                            {
                                                ?>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '-' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-6 text-right">
                                                            <p><?= $job->budget ?></p>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-6 text-right">
                                                            <p>Chờ giao việc</p>
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
                                                            <img class=" avatar" width="50" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($user->avatar) ? '150-' . $user->avatar : "avatar.png" ?>">

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
                                        Lưu nhân viên 
                                        <?= Html::a('Chi tiết', ['bossmanage/member']); ?>
                                    </h4>
                                </div>
                                <div class="box-content select-item ">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <?php
                                                if (!empty($listing))
                                                {
                                                    var_dump($listing);
                                                    exit;
                                                    foreach ($listing as $key => $value)
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <img width="40" src="<?= Yii::$app->params['url_file'] ?>thumbnails/<?= !empty($value->findactor->avatar) ? '150-' . $value->findactor->avatar : "avatar.png" ?>" class="avatar img-circle pull-left">
                                                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['user/' . $value->findactor->slug]) ?>"  class="name"><b><?= $value->findactor->name ?></b></a>
                                                                <p class="text-gray"><?= $value->findactor->findcategory->name ?></p>
                                                            </td>
                                                            <td class="text-right">
                                                                <a class="btn btn-blue" href="<?= Yii::$app->urlManager->createAbsoluteUrl('/tin-nhan/' . $value->findactor->slug) ?>">Liên hệ</a>
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
