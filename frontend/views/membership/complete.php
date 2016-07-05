<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Hoàn thành hồ sơ';
?>
<section>
    <div class="introduce complete-profile">
        <?php $form = ActiveForm::begin(); ?>    
        <div class="container">
            <?php if (Yii::$app->session->hasFlash('success')) { ?>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="alert alert-danger" role="alert">
                            <?= Yii::$app->session->getFlash('success') ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="step-profile">
                        <ul class="list-unstyled">
                            <li class="step_1 step-done"><span>1</span><div>Giới thiệu bản thân</div></li>
                            <li class="step_2 step-done text-center"><span>2</span><div class="text-center">Kinh nghiệm và học vấn</div></li>
                            <li class="step_3 step-done text-right"><span>3</span><div class="text-right">Hoàn thành hồ sơ</div></li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <h3>Xin chúc mừng, bạn đã hoàn tất hồ sơ!</h4>
                        <p>
                            Hồ sơ của bạn sẽ được kiểm tra và duyệt bởi Giaonhanviec.com trước khi bạn nhận việc từ khách hàng.
                        </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="user-item">
                        <img class="avatar img-circle" style="width:80px;" src="<?= Yii::$app->params['url_file'] . 'thumbnails/150-' . $user->avatar ?>">
                        <div class="user-content">
                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['membership/profile']) ?>"><?= $user->name ?></a>
                            <p>
                                <?= $user->findcategory->name ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-blue">Gởi duyệt hồ sơ </button>
                    <?= Html::a('<strong>Xem hồ sơ cá nhân</strong>', [ 'membership/profile'], ['class' => 'btn call-back']) ?>          
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</section>