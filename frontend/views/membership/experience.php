<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Kinh nghiệm và học vấn';
?>
<section>
    <div class="introduce profile-edit commitments">
        <div class="container">

            <div class="row">
                <!-- introduce item -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php if (Yii::$app->session->hasFlash('success')) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?= Yii::$app->session->getFlash('success') ?>
                        </div>
                    <?php } ?>
                    <div class="title-container">
                        <h3>Tạo hồ sơ năng lực của bạn</h3>
                        <p>
                            Việc đầu tiên là bạn cần phải hoàn thiện hồ sơ năng lực của mình. Nó có vai trò rất quan trọng để khách hàng có thể đánh giá được khả năng của bạn, và nó là một công cụ marketing cho bạn để nổi bật trước hàng ngàn ứng viên khác.
                        </p>
                    </div>    

                    <div class="step-profile">
                        <ul class="list-unstyled">
                            <li class="step_1 step-done"><span>1</span><div>Giới thiệu bản thân</div></li>
                            <li class="step_2 step-done text-center"><span>2</span><div class="text-center">Kinh nghiệm và học vấn</div></li>
                            <li class="step_3 text-right"><span>3</span><div class="text-right">Hoàn thành hồ sơ</div></li>
                        </ul>
                    </div>
                    <h4 class="title-box ">Cấp độ nhân viên </h4>
                    <div class="content">
                        <p><b>Cấp độ nhân viên hiện tại của bạn </b></p>
                        <p>Cấp độ nhân viên sẽ tăng lên khi bạn hoàn thành các bài test năng lực và hoàn thành các dự án được giao. <a href="#"><b>Xem thêm cách tăng cấp độ nhân viên</b></a></p>
                    </div>

                    <div class="job">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="#" title="">
                                    <div class="level-item active">
                                        <div class="level-active"></div>
                                        <i class="icon icon-avatar-active"></i>
                                        <div class="line-gray"></div>
                                        <div class="title-job">
                                            <h4>nhân viên thử việc</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="#" title="">
                                    <div class="level-item">
                                        <div class="level-active"></div>
                                        <i class="icon icon-avatar-1"></i>
                                        <div class="line-gray"></div>
                                        <div class="title-job">
                                            <h4>nhân viên</h4>
                                            <p>
                                                <span class="star">
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="#" title="">
                                    <div class="level-item">
                                        <div class="level-active"></div>
                                        <i class="icon icon-avatar-2"></i>
                                        <div class="line-gray"></div>
                                        <div class="title-job">
                                            <h4>nhân viên chuyên nghiệp</h4>
                                            <p>
                                                <span class="star">
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="#" title="">
                                    <div class="level-item">
                                        <div class="level-active"></div>
                                        <i class="icon icon-avatar-3"></i>
                                        <div class="line-gray"></div>
                                        <div class="title-job">
                                            <h4>nhân viên cao cấp</h4>
                                            <p>
                                                <span class="star">
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>      
                    </div>
					
					
					<h4 class="title-box ">Tài khoản ngân hàng </h4>
                    <div class="well">
                        <?= $this->render('_bankaccount', [ 'bankaccount' => $bankaccount, 'newbankaccount' => $newbankaccount, 'city'=>$city]) ?>
                    </div>
                    <h4 class="title-box ">Quá trình làm việc </h4>
                    <div class="well">
                        <?= $this->render('_workprogress', [ 'work' => $work]) ?>
                    </div>

                    <h4 class="title-box">Trình độ học vấn</h4>
                    <div class="well">
                        <?= $this->render('_workeducation', [ 'education' => $education]) ?>
                    </div>
                    <h4 class="title-box">Các dự án của bạn</h4>
                    <div class="well">
                        <?= $this->render('_workproject', [ 'workdone' => $workdone, 'newworkdone' => $newworkdone]) ?>
                    </div>
                    <div>
                        <?php $form = ActiveForm::begin(); ?>    
                        <button class="btn btn-blue">Lưu hồ sơ </button>
                        <?= Html::a('<strong>Quay lại</strong>', [ 'membership/about'], ['class' => 'btn call-back']) ?>    
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>    
            </div>

        </div>
    </div>
</section>