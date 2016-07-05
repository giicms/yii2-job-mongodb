<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Xem hồ sơ cá nhân';
?>
<section>
    <div class="introduce profile-edit profile-member">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="title-container">
                        <h3>Hồ sơ cá nhân </h3>
                    </div>
                    <h4 class="title-box">
                        Thông tin cá nhân 
                        <?= Html::a('<i class="fa fa-pencil"></i> Chỉnh sửa', ['membership/changeinfo'], ['class' => 'edit-bar']) ?>
                    </h4>
                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Họ và tên</b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <p><?= $model->name ?> </p>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Ảnh đại diện</b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <div class="profile-item no-border">
                                <div class="profile">
                                    <img src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($model->avatar) ? '150-' . $model->avatar : "avatar.png" ?>" style="width:150px" class="fa avatar-16 img-circle">
                                </div>
                                <div class="profile-content">
                                    <ul>
                                        <li><b>Ảnh đại diện của bạn</b></li>
                                        <li>Hãy tạo cảm giác thân thiện và gần gũi với khách hàng <br> bằng ảnh đại diện của bạn.</li>
                                        <!--                                        <li>
                                                                                    <a href="#" class="uploadFile"><i class="icon icon-add"></i> <span class="fix">Thay ảnh đại diện</span></a>
                                                                                </li>-->

                                    </ul>

                                </div>


                            </div>


                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Số cmnd</b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <p><?= !empty($model->cmnd)?$model->cmnd:"Chưa có" ?></p>
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
                            <b>Tài khoản ngân hàng </b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <p><?= !empty($model->bankaccount) ? $model->bankaccount : "Chưa có" ?></p>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Địa chỉ </b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <p><?= !empty($model->city) ? $model->address . ' - ' . $model->location->name . ' - ' . $model->location->city->name : "Chưa có" ?></p>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Mô tả tả bản thân</b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <p><?= $model->description ?></p>
                        </div>
                        
                    </div> 

                    <h4 class="title-box">
                        Cấp độ nhân viên - Đánh giá của khách hàng 
                    </h4>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <p><b>Cấp độ nhân viên hiện tại của bạn</b></p>
                            <p><a href="#">Xem cách tăng cấp độ nhân viên</a></p>
                            <div class="level-item active">
                                <i class="icon <?= $model->findlevel->icon ?>"></i>
                                <div class="line-gray"></div>
                                <div class="title-job">
                                    <h4><?= $model->findlevel->name ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-offset-2 col-sm-offset-2 col-md-4 col-sm-4 col-xs-12">
                            <p><b>Đánh giá của khách hàng </b></p>
                            <ul class="list-unstyled" style="padding-top:15px;">
                                <?php foreach ($model->getProgress($model->_id) as $key => $value) {
                                    if(($model->getCountReview($model->_id)) >0){
                                        $percent = round(($value/$model->getCountReview($model->_id))*100, 2);
                                    }else{
                                        $percent = 0;
                                    }
                                echo '<li>
                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3"><i class="fa fa-star text-blue"></i>'.$key.'</div>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-9 review">
                                        <div class="progress-review">
                                            <div class="progress lev-'.$key.'">
                                                <div style="width: '.$percent.'%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="'.$percent.'" role="progressbar" class="progress-bar bg-success">
                                                    <span class="sr-only">'.number_format($value, 0, '', ',').'</span>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <b>'.number_format($value, 0, '', ',').'</b>
                                        </div>
                                    </div>    
                                    <div class="clear-fix"></div>
                                </li>';
                            };?>
                            </ul>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12" style="padding-top:15px;">
                            <div class="review-point">
                                <h4 class="color"></h4>
                                <span><?=$model->getPoint($model->_id);?></span>
                            </div>
                            <div class="rating-star text-center">
                                <span class="star text-yellow">
                                    <?=$model->getRating($model->_id);?>
                                </span>
                            </div>
                            <div class="total text-center">
                                <i class="fa fa-user"></i> <?=$model->getCountReview($model->_id);?> Lượt đánh giá 
                            </div>
                        </div>
                    </div>
					<h4 class="title-box ">Tài khoản ngân hàng </h4>
                    <div class="">
                        <?= $this->render('_bankaccount', [ 'bankaccount' => $bankaccount, 'newbankaccount' => $newbankaccount, 'city'=>$city]) ?>
                    </div>
                    <h4 class="title-box">
                        Trình độ học vấn 
                    </h4>
                    <?= $this->render('_workeducation', [ 'education' => $education, 'model' => $model]) ?>
                    <h4 class="title-box">
                        Quá trình làm việc   
                    </h4>
                    <?= $this->render('_workprogress', ['work' => $work, 'model' => $model]) ?>
                    <h4 class="title-box">
                        Kinh nghiệm làm việc 
                    </h4>
                    <?= $this->render('_workproject', [ 'workdone' => $workdone, 'newworkdone' => $newworkdone]) ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End introduce -->
<?= $this->render('_cropimage') ?>
