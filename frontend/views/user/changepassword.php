<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Thay đổi mật khẩu';
?>
<section>
    <div class="introduce profile-container">
        <div class="container">
            <div class="title-container">
                <h3>Thay đổi mật khẩu đăng nhập</h3>
            </div>
            <div class="col-md-12 col-xs-12">
                <div class="box-profile">
                    <div class="box-content">
                        <div class="info">
                            <div class="profile">
                                <img class="fa avatar-16 img-circle" style="width:100px" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/150-<?= $user->avatar ?>">
                            </div>
                            <div class="profile-content text-left">
                                <div class="text-left">
                                    <h5>
                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $user->slug) ?>"><b><?= $user->name ?></b></a>
                                    </h5>
                                    <p><b><?= !empty($user->findcategory->name) ? $user->findcategory->name : "" ?></b></p>
                                    <?php
                                    if (!empty($user->findlevel->name)) {
                                        ?>
                                        <p>Cấp độ: <b><?= $user->findlevel->name ?></b></p>
                                    <?php } ?>
                                    <p>
                                        <i class="fa fa-map-marker"></i> 
                                        <b><?= $user->location->name ?>, <?= $user->location->city->name ?></b>
                                        <?php
                                        if (!empty($user->findlevel->name)) {
                                            ?>
                                            - <small>Test năng lực: 6 - Portfolior: 5</small>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                            <label class="col-md-12 col-sm-12 col-xs-12">Mật khẩu hiện tại</label>
                            <?= $form->field($model, 'password', ['template' => '<div  class="col-md-4 col-sm-6 col-xs-12">{input}{hint}{error}</div>'])->passwordInput(['class' => 'form-control']) ?>
                            <label class="col-md-12 col-sm-12 col-xs-12">Mật khẩu hiện mới</label>
                            <?= $form->field($model, 'password_new', ['template' => '<div  class="col-md-4 col-sm-6 col-xs-12">{input}{hint}{error}</div>'])->passwordInput(['class' => 'form-control']) ?>
                            <label class="col-md-12 col-sm-12 col-xs-12">Xác nhận mật khẩu mới</label>
                            <?= $form->field($model, 'password_rep', ['template' => '<div  class="col-md-4 col-sm-6 col-xs-12">{input}{hint}{error}</div>'])->passwordInput(['class' => 'form-control']) ?>
                            <div class="col-md-12 col-xs-12">
                                <button type="submit" class="btn btn-blue">Thay đổi mật khẩu</button>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</section>