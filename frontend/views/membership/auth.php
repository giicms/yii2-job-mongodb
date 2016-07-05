<?php

use yii\helpers\Html;

$this->title = 'Chúc mừng bạn đã kích hoạt thành công!';
?> <section>
    <div class="introduce complete-profile">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="title-container">
                        <h3>Tạo hồ sơ năng lực của bạn</h3>
                    </div>
                    <p>
                        Etiam adipiscing elementum duis vel lacus risus etiam est. Etiam, porta enim, ultrices pulvinar eros adipiscing in penatibus in integer, pid etiam nunc rhoncus tempor vel? Pid. Parturient ultricies ultricies, dis turpis? Rhoncus arcu lectus penatibus nec etiam integer arcu tortor, ut, tempor facilisis, nascetur, turpis sit, porta porta sagittis.
                    </p>
                    <p>
                        <a href="#"><strong>Xem thêm cách tạo Hồ sơ năng lực</strong></a>
                    </p>
                    <div class="col-sm-12 text-center">
                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['membership/jobcategories'])?>" class="btn btn-blue">Hoàn thành Hồ sơ năng lực</a>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-sm-12 col-xs-12">
                    <hr>
                    <div class="title-container">
                        <h4>Tham khảo các hồ sơ mẫu của các nhân viên tiêu biểu</h4>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="user-item">
                        <?=Html::img('/images/customer/3.jpg', ['class' => 'avatar img-circle', 'style' => 'width:80px;']);?>
                        <div class="user-content">
                            <a href="#">Nguễn Hoàng Liên Sơn</a>
                            <p>
                                Grapic Design
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="user-item">
                        <?=Html::img('/images/customer/2.jpg', ['class' => 'avatar img-circle', 'style' => 'width:80px;']);?>
                        <div class="user-content">
                            <a href="#">Nguễn Hoàng Liên Sơn</a>
                            <p>
                                Grapic Design
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="user-item">
                        <?=Html::img('/images/customer/1.jpg', ['class' => 'avatar img-circle', 'style' => 'width:80px;']);?>
                        <div class="user-content">
                            <a href="#">Nguễn Hoàng Liên Sơn</a>
                            <p>
                                Grapic Design
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End introduce -->
