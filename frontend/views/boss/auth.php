<?php

use yii\helpers\Html;

$this->title = 'Chúc mừng bạn đã kích hoạt thành công!';
?>
<section>
    <div class="introduce">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="boss-finish-left">
                        <h4>
                            <?= $this->title ?>
                        </h4>
                        <p>Chào mừng bạn đã đến với hệ thống làm việc trực tuyến Giaonhanviec. Hãy bắt đầu đăng việc và tìm kiếm nhân viên phù hợp với công việc của bạn!</p>
                        <div class="boss-finish-img">
                            <?= Html::img('/images/bg_active.png', ['class' => 'img-responsive']) ?>
                        </div>
                        <div class="boss-finish-footer">
                            <?= Html::a('Đăng việc', ['job/create'], ['class' => 'btn btn-blue']) ?> hoặc 
                            <?= Html::a('Tìm kiếm', ['job/search'], ['class' => 'btn btn-blue']) ?>
                        </div>
                    </div>
                </div> 
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="boss-finish-right">
                        <h4>Câu hỏi thường gặp</h4>
                        <ul>
                            <li><a href="#">Tôi có thể hoàn tất việc gì ở trên Giaonhanviec.com?</a></li>
                            <li><a href="#">Làm thế nào tôi biết việc của mình đã được hoàn tất</a></li>
                            <li><a href="#">Tôi trả tiền cho nhân viên như thế nào</a></li>
                            <li><a href="#">Làm thế nào để bắt đầu thuê nhân viên làm viêc?</a></li>
                        </ul>
                        <a href="">Thêm &raquo;</a>
                    </div>
                    <div class="boss-finish-right-help">
                        <ul class="nav nav-pills">
                            <li>
                                <div class="row">
                                    <div class="col-md-3 col-sm-4 col-xs-3">
                                        <i class="icon icon-support"></i>
                                    </div>
                                    <div class="col-md-9 col-sm-8 col-xs-9">
                                        <h4>Bạn cần hỗ trợ để sử dụng Giaonhanviec.com?</h4>
                                        <p>Hãy truy cập vào trung tâm trợ giúp xem các hướng dẫn và các câu hỏi</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-md-3 col-sm-4 col-xs-3">
                                        <i class="icon icon-call24"></i>
                                    </div>
                                    <div class="col-md-9 col-sm-8 col-xs-9">
                                        <h4>Bạn có câu hỏi? Gọi chúng tôi</h4>
                                        <p>Tổng đài hỗ trợ: <b>1900 2314</b></p>
                                    </div>
                                </div>

                            </li>
                        </ul>
                    </div> 
                </div>
            </div>
        </div>
</section>
