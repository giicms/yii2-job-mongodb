<?php

use yii\helpers\Html;

$this->title = 'Xác nhận địa chỉ Email của bạn để sử dụng Giaonhanviec.com';
?>
<section>
    <div class="introduce">
        <div class="container">
            <div class="row">
                <div class="email_confirmation">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <h3 class="title"><?= $this->title ?></h3>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row active_content">
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <div class="img">
                                    <?= Html::img('/images/active_email.png', ['class' => 'img-responsive']) ?>
                                </div>
                            </div> 
                            <div class="col-md-9 col-sm-9 col-xs-9">
                                <h4>Chúng tôi đã gởi tới địa chỉ: <?= $model->email ?></h4>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <p>Vui lòng kiểm tra email và click vào link để xác thực tài khoản của bạn. <a href="#">Thay đổi email</a></p>
                                <ul>
                                    <li><a href="/Bo_dang_ky_boss_thanh_cong.html">Tôi cần giúp đỡ để xác thực email</a></li>
                                    <li><a href="/Bo_dang_ky_boss_thanh_cong.html">Vui lòng gởi lại cho tôi email xác thực</a></li>
                                </ul>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>