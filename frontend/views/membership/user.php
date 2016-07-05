<?php

use yii\helpers\Html;

$this->title = 'Hồ sơ của ' . $model->name . '!';
?>
<section>
    <div class="introduce profile-member user-<?= (string) $model->_id ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-8 col-xs-12">
                    <div class="profile-item ">
                        <div class="profile">
                            <img class="img-circle avatar" width="150" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($model->avatar) ? '150-' . $model->avatar : "avatar.png" ?>">
                            <div class="num-review">
                                <h5>Đánh giá: </h5> <span>5.0</span>
                            </div>
                        </div>
                        <div class="profile-content">
                            <ul class="list-unstyled text-left">
                                <li>          
                                    <h5>
                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['membership/user', 'id' => (string) $model->_id]) ?>" class="name"><b><?php echo $model->name ?></b></a>
                                        <small> - Hoạt động cách đây <?= Yii::$app->convert->time($model->created_at) ?></small>
                                    </h5>
                                </li>
                                <li><b><?= !empty($model->findcategory->name) ? $model->findcategory->name : "" ?></b></li>
                                <li>Cấp độ: <b><?= !empty($model->findlevel->name) ? $model->findlevel->name : "" ?></b></li>
                   
                                <li><i class="fa fa-map-marker"></i> <b>Đà Nẵng, Việt Nam</b> - <small>Test năng lực: 6 - Portfolior: 5</small></li>
                                <li>
                                    <ul class="list-unstyled">
                                        <?php
                                        if (!empty($model->skills)) {
                                            foreach ($model->skills as $k => $skill) {
                                                if ($k > 5)
                                                    $dis = 'none';
                                                else
                                                    $dis = 'block';
                                                $getskill = $model->getSkills($skill);
                                                echo '<li class="pull-left" style="display:' . $dis . '"><span class="label label-default">' . $getskill['name'] . '</span></li> ';
                                            }
                                        }
                                        ?>
                                        <li class="pull-left">     <a href="#"><strong>Xem thêm</strong></a></li>
                                    </ul>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>  

                <div class="col-md-3 col-sm-4 col-xs-12 sidebar-profile ">
                    <div class="profile-item no-border">
                        <div class="profile-content">
			    <?php if (!\Yii::$app->user->isGuest) {?>
                            <?php if (\Yii::$app->info->isboss()) { ?>
                                <ul class="list-unstyled">
                                    <li class="options">
                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['messages/index']) ?>" class="btn btn-blue">Liên hệ</a> 
                                        <a class="btn btn-square invited" data-id="<?= (string) $model->_id ?>">Mời nhận việc</a>
                                    </li>
                                    <li><a href="javascript:void(0)" data-id="<?= (string) $model->_id ?>" class="saved"><i class="fa <?= !$model->saveexits((string) $model->_id) ? 'fa-heart-o' : 'fa-heart' ?>"></i></a> Lưu lại nhân viên này</li>

                                </ul>
                            <?php } }?>
                            <h4 class="title-box">Kinh nghiệm làm việc</h4>
                            <ul class="list-unstyled">
                                <li><b>31</b> đánh giá</li>
                                <li><b>56</b> việc làm đã nhận</li>
                                <li><b>100%</b> công việc đã hoàn thành</li>

                            </ul>
                            <h4 class="title-box">Thời gian có thể làm việc</h4>
                            <ul class="list-unstyled">
                                <li><i>✔</i> <b>Sẵng sàng làm việc</b></li>
                                <li><i>✔</i> <b>Toàn thời gian cố định</b></li>
                                <li><i>✔</i> <b>Phản hồi trong 24h</b></li>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 col-sm-8 col-xs-12">    
                    <div class="profile-item">
                        <div class="profile-content">
                            <h4 class="title-box">Giới thiệu</h4>
                            <p class="text">
                                <?= $model->description ?>
                            </p>
                            <h4 class="title-box">Các công việc đã làm và đánh giá (25)</h4>
                            <div class="review-item">
                                <div class="row">
                                    <div class="col-md-9 col-sm-8 col-xs-12">
                                        <h4 class="text-blue">Thiết kế logo cho Công ty bất động sản</h4>
                                        <p>
                                            “ nteger scelerisque turpis urna magna habitasse? Duis pellentesque, rhoncus a, eros, placerat integer augue ac montes cras lacus turpis augue, nisi porta! Ac magna? Nunc tempor. Tristique vel, vel aliquet, odio lectus et? Montes, mus! Facilisis turpis duis pellentesque eu, tincidunt nisi vel magna porta vut tempor scelerisque! Nec turpis.”
                                            nteger scelerisque turpis urna magna habitasse? Duis pellentesque, rhoncus a, eros, placerat integer augue ac montes cras lacus turpis augue, nisi porta! Ac magna? Nunc tempor. Tristique vel, vel aliquet, odio lectus et? Montes, mus! Facilisis turpis duis pellentesque eu, tincidunt nisi vel magna porta vut tempor scelerisque! Nec turpis.
                                        </p>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <ul class="text-right list-unstyled">
                                            <li class="review">
                                                <div class="progress-review">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                            <span class="sr-only">60% Complete</span>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <b>4.0</b>
                                            </li>
                                            <li><b>15.000.000 VNĐ</b></li>
                                            <li>Giá cố định</li>
                                            <li>12/2014</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="review-item">
                                <div class="row">
                                    <div class="col-md-9 col-sm-8 col-xs-12">
                                        <h4 class="text-blue">Thiết kế logo cho Công ty bất động sản</h4>
                                        <p>
                                            “ nteger scelerisque turpis urna magna habitasse? Duis pellentesque, rhoncus a, eros, placerat integer augue ac montes cras lacus turpis augue, nisi porta! Ac magna? Nunc tempor. Tristique vel, vel aliquet, odio lectus et? Montes, mus! Facilisis turpis duis pellentesque eu, tincidunt nisi vel magna porta vut tempor scelerisque! Nec turpis.”
                                            nteger scelerisque turpis urna magna habitasse? Duis pellentesque, rhoncus a, eros, placerat integer augue ac montes cras lacus turpis augue, nisi porta! Ac magna? Nunc tempor. Tristique vel, vel aliquet.
                                        </p>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <ul class="text-right list-unstyled">
                                            <li class="review">
                                                <div class="progress-review">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                            <span class="sr-only">60% Complete</span>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <b>4.0</b>
                                            </li>
                                            <li><b>15.000.000 VNĐ</b></li>
                                            <li>Giá cố định</li>
                                            <li>12/2014</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <h4 class="title-box">Đánh giá nhân viên</h4>
                            <div class="row">
                                <div class="col-md-8 col-sm-7 col-xs-12">
                                    <ul>
                                        <li class="row">
                                            <div class="col-lg-5"><h4>Tiêu chí đánh giá</h4></div>
                                            <div class="col-lg-7"><h4>0......................5........................10</h4></div>
                                        </li>
                                        <li class="row">
                                            <div class="col-lg-5">Đăng giá tiền</div>
                                            <div class="col-lg-7 review">
                                                <div class="progress-review">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                            <span class="sr-only">60% Complete</span>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="pull-right">
                                                    <b>7.0</b>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="row">
                                            <div class="col-lg-5">Vị trí</div>
                                            <div class="col-lg-7 review">
                                                <div class="progress-review">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                            <span class="sr-only">60% Complete</span>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="pull-right">
                                                    <b>7.0</b>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="row">
                                            <div class="col-lg-5">Thái độ phục vụ</div>
                                            <div class="col-lg-7 review">
                                                <div class="progress-review">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                            <span class="sr-only">60% Complete</span>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="pull-right">
                                                    <b>7.0</b>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="row">
                                            <div class="col-lg-5">Điều kiện vệ sinh khách sạn</div>
                                            <div class="col-lg-7 review">
                                                <div class="progress-review">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                            <span class="sr-only">60% Complete</span>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="pull-right">
                                                    <b>7.0</b>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="row">
                                            <div class="col-lg-5">Tiêu chuẩn / chất lượng phòng</div>
                                            <div class="col-lg-7 review">
                                                <div class="progress-review">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                            <span class="sr-only">60% Complete</span>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="pull-right">
                                                    <b>7.0</b>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="row">
                                            <div class="col-lg-5">Thức ăn / Bữa ăn</div>
                                            <div class="col-lg-7 review">
                                                <div class="progress-review">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                            <span class="sr-only">60% Complete</span>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="pull-right">
                                                    <b>7.0</b>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <div class="col-md-4 col-sm-5 col-xs-12">
                                    <div class="review-point">
                                        <h4 class="color">HÀI LÒNG</h4>
                                        <span>7.0</span>
                                    </div>
                                </div>
                            </div>
                            <h4 class="title-box">Kinh nghiệm làm việc</h4>
                            <div class="exp">
                                <div class="row">
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <div class="exp-item">
                                            <img class="img-responsive" src="images/logo-user.png">
                                            <h5>Logo công ty</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <div class="exp-item">
                                            <img class="img-responsive" src="images/logo-user.png">
                                            <h5>Logo công ty</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <div class="exp-item">
                                            <img class="img-responsive" src="images/logo-user.png">
                                            <h5>Logo công ty</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <div class="exp-item">
                                            <img class="img-responsive" src="images/logo-user.png">
                                            <h5>Logo công ty</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12  nav-pagination">
                                        <nav>
                                            <ul class="pagination pull-right">
                                                <li><a href="#">Trang trước</a></li>
                                                <li><a href="#">1</a></li>
                                                <li><a href="#">2</a></li>
                                                <li><a href="#">3</a></li>
                                                <li><a href="#">Trang sau</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <h4 class="title-box">Kiểm tra năng lực chuyên môn</h4>
                            <div class="tests">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr><th>Tên bài kiểm tra</th><th>Điểm tối đa (10)</th><th>Thời gian hoàn tất</th></tr>
                                        </thead>
                                        <tbody>
                                            <tr><td>Adobe Photoshop</td><td><span class="point">8.25 </span><span class="label label-success">Khá</span></td><td>20 phút</td></tr>
                                            <tr><td>Adobe Photoshop</td><td><span class="point">6.25 </span><span class="label label-info">Trung bình</span></td><td>20 phút</td></tr>
                                            <tr><td>Adobe Photoshop</td><td><span class="point">8.25 </span><span class="label label-warning">Tốt</span></td><td>20 phút</td></tr>
                                            <tr><td>Adobe Photoshop</td><td><span class="point">8.25 </span><span class="label label-danger">Yếu</span></td><td>20 phút</td></tr>
                                            <tr><td>Adobe Photoshop</td><td><span class="point">8.25 </span><span class="label label-success">Khá</span></td><td>20 phút</td></tr>
                                            <tr><td>Adobe Photoshop</td><td><span class="point">8.25 </span><span class="label label-info">Trung bình</span></td><td>20 phút</td></tr>
                                            <tr><td>Adobe Photoshop</td><td><span class="point">8.25 </span><span class="label label-warning">Tốt</span></td><td>20 phút</td></tr>
                                            <tr><td>Adobe Photoshop</td><td><span class="point">8.25 </span><span class="label label-danger">Yếu</span></td><td>20 phút</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <h4 class="title-box">Quá trình làm việc</h4>
                            <h5><b>Graphic Design</b> | Network Media</h5>
                            <small>Tháng 09/2014 - 09/2015</small>
                            <h4 class="title-box">Trình độ học vấn</h4>
                            <h5><b>Graphic Design</b> | Network Media</h5>
                            Tháng 09/2014 - 09/2015
                            <h4 class="title-box">Kỹ năng khác</h4>
                            <p class="text">
                                “ nteger scelerisque turpis urna magna habitasse? Duis pellentesque, rhoncus a, eros, placerat integer augue ac montes cras lacus turpis augue, nisi porta! Ac magna? Nunc tempor. Tristique vel, vel aliquet, odio lectus et? Montes, mus! Facilisis turpis duis pellentesque eu, tincidunt nisi vel magna porta vut tempor scelerisque! Nec turpis.”
                                nteger scelerisque turpis urna magna habitasse? Duis pellentesque, rhoncus a, eros, placerat integer augue ac montes cras lacus turpis augue, nisi porta! Ac magna? Nunc tempor. Tristique vel, vel aliquet.

                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
</section>
<?= $this->render('_modalinvited', ['job' => $job, 'invited' => $invited]) ?>
<?= $this->registerJs("$(document).on('click', '.invited', function (event){
        event.preventDefault();
        var user_id = $(this).attr('data-id');
        var user_name = $('.user-'+user_id+' .name').text();
        $('#invited').modal('show');
        $('#invited').find('.modal-body .actor-name').text(user_name);
        $('#invited').find('.modal-body #jobinvited-actor').val(user_id);
    

});") ?>


<?= $this->registerJs("$(document).on('submit', '#formInvited', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["job/jobinvited"]) . "',
               type: 'post',
          data: $('form#formInvited').serialize(),
        success: function(data, status) {
          if(data){
       $('#invited').modal('hide');          
}
        }
    });

});

") ?>
<?= $this->registerJs("$(document).on('click', '.saved', function (event){
        event.preventDefault();
        var user_id = $(this).attr('data-id');
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/saveuser"]) . "',
            type: 'post',
            data: {user_id:user_id},
            success: function(data) {
                if(data.status==0){
                $('.user-'+user_id+' a.saved').html('<i class=\"fa fa-heart-o\"></i>');
                } else {
                $('.user-'+user_id+' a.saved').html('<i class=\"fa fa-heart\"></i>');
                }
            }
        });

});") ?>
