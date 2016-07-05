<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Xem hồ sơ cá nhân';
?>
<section>
    <div class="introduce profile-edit">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="title-container">
                        <h3>Hồ sơ cá nhân </h3>
                    </div>
                    <h4 class="title-box">
                        Thông tin cá nhân 
                        <?= Html::a('<i class="fa fa-pencil"></i> Chỉnh sửa', ['boss/changeinfo'], ['class' => 'edit-bar']) ?>
                    </h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Họ và tên</b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <p><?= $model->name ?></p>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Ảnh đại diện</b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <div class="profile-item no-border">
                                <div class="profile">
                                    <img src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($model->avatar) ? '150-' . $model->avatar : "avatar.png" ?>" style="width:150px" class="fa avatar-16 img-circle">
                                </div>
                                <div class="profile-content" style="text-align: left">
                                    <ul>
                                        <li><b>Ảnh đại diện của bạn</b></li>
                                        <li>Hãy tạo cảm giác thân thiện và gần gũi với khách hàng <br> bằng ảnh đại diện của bạn.</li>
                                    </ul>

                                </div>


                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Số điện thoại</b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <p><?= $model->phone ?></p>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Email</b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <p><?= $model->email ?> </p>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Địa chỉ</b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <?php
                                if(!empty($model->location->city->name)){
                            ?>
                            <p><?= $model->address . ', ' . $model->location->name . ', ' . $model->location->city->name ?></p>
                            <?php }else{echo '<p>Chưa cập nhật.</p>';}?>

                        </div> 
                    </div> 

                    <?php
                    if($model->boss_type == 2){
                    ?>
                    <h4 class="title-box">Thông tin công ty</h4>
                    <hr>
                    <?php
                    if (!empty($model->company_name)) {
                        ?>
                         
                        <div class="row">
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <b>Tên công ty</b>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <p><?= $model->company_name ?></p>
                            </div> 

                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <b>Mã số đăng ký kinh doanh </b>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <p><?= $model->company_code ?></p>
                            </div>   
                        </div>  
                        <?php
                    }else{
                    ?>
                        <div class="row">
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <b>Tên công ty</b>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <p>Chưa cập nhật.</p>
                            </div> 

                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <b>Mã số đăng ký kinh doanh </b>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <p>Chưa cập nhật</p>
                            </div>   
                        </div>  
                    <?php }}?>    

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End introduce -->
