<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Hồ sơ của ' . $model->name . '!';
?>
<section>
    <div class="introduce profile-member user-<?= (string) $model->_id ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-8 col-xs-12">
                    <div class="profile-item ">
                        <div class="profile">
                            <?php
                            if (!empty($model->avatar))
                                $avatar = Yii::$app->setting->value('url_file') . 'thumbnails/150-' . $model->avatar;
                            else if (!empty($model->fbid))
                                $avatar = '//graph.facebook.com/' . $model->fbid . '/picture?type=large';
                            else
                                $avatar = Yii::$app->setting->value('url_file') . 'avatar.png';
                            ?>
                            <img class="img-circle avatar" width="150" src="<?= $avatar; ?>">
                            <div class="num-review">
                                <h5>Đánh giá: </h5> <span><?= $model->getPoint($model->_id) ?></span>
                            </div>
                        </div>
                        <div class="profile-content">
                            <ul class="list-unstyled text-left">
                                <li>          
                                    <h5>
                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $model->slug) ?>" class="name"><b><?php echo $model->name ?></b></a>
                                        <small> - Hoạt động cách đây <?= Yii::$app->convert->time($model->lastvisit) ?></small>
                                    </h5>
                                </li>
                                <li><b><?= !empty($model->findcategory->name) ? $model->findcategory->name : "" ?></b></li>
                                <li>Cấp độ: <b><?= !empty($model->findlevel->name) ? $model->findlevel->name : "" ?></b></li>

                                <li><i class="fa fa-map-marker"></i> <b><?= $model->location->name ?>, <?= $model->location->city->name ?></b> - <small>Test năng lực: <?= count($test) ?> - Portfolior: 5</small></li>
                                <li>
                                    <ul class="list-unstyled">
                                        <?php
                                        if (!empty($model->skills))
                                        {
                                            foreach ($model->skills as $k => $skill)
                                            {
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
                            <?php
                            if (\Yii::$app->info->isboss())
                            {
                                ?>
                                <ul class="list-unstyled">
                                    <li class="options">
                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('tin-nhan/' . $model->slug) ?>" class="btn btn-blue">Liên hệ</a> 
                                        <a class="btn btn-square invited" data-id="<?= (string) $model->_id ?>">Mời nhận việc</a>
                                        <p><?php
                                            if (!empty($model->bookuser))
                                                echo '<p>Book nhân viên: <label class="text-danger">' . $model->bookuser . '</label></p>';
                                            else
                                            {
                                                ?>
                                                <a class="btn btn-info userbid" style="margin-left:3px; text-transform: uppercase; padding: 10px" data-id="<?= (string) $model->_id ?>">Book nhân viên</a>
                                                <?php
                                            }
                                            ?>
                                        </p>
                                    </li>
                                    <li><a href="javascript:void(0)" data-id="<?= (string) $model->_id ?>" class="saved"><i class="fa <?= !$model->saveexits((string) $model->_id) ? 'fa-heart-o' : 'fa-heart' ?>"></i></a> Lưu lại nhân viên này</li>

                                </ul>
                            <?php } ?>
                            <h4 class="title-box">Kinh nghiệm làm việc</h4>
                            <ul class="list-unstyled">
                                <li><b><?= $model->getCountReview($model->_id) ?></b> đánh giá</li>
                                <li><b><?= $model->countReview ?></b> đánh giá</li>
                                <li><b><?= $model->countjobdone ?></b> việc đã hoàn thành</li>

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
                            <?php
                            if (!empty($assignment))
                            {
                                echo '<h4 class="title-box">Các công việc đã làm và đánh giá (' . count($assignment) . ')</h4>';
                                foreach ($assignment as $value)
                                {
                                    ?>
                                    <?php
                                    if (!empty($value->findComment($value->actor)))
                                    {
                                        ?>
                                        <div class="review-item">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <ul class="list-unstyled">
                                                        <li>
                                                            <b class="text-blue"><?= $value->job->name ?> </b><small>-<?= $value->job->category->name ?></small></br>
                                                            <small><?= $model->getStar($value->findComment($value->actor)->rating); ?></small></br>
                                                            <i style="color:#989898"><?= $value->findComment($value->actor)->comment; ?></i> - 
                                                            <small>
                                                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $value->job->findUser($value->findComment($value->actor)->actor)->slug) ?>"><b><?= $value->job->findUser($value->findComment($value->actor)->actor)->name; ?></b></a>
                                                            </small>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> 
                                    <?php } ?>	
                                    <?php
                                }
                            }
                            ?>
                            <h4 class="title-box">Đánh giá nhân viên</h4>
                            <div class="row review-box">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <div class="text-blue average ">
                                        <?= $model->getPoint($model->_id); ?>
                                    </div>
                                    <div class="rating-star text-center">
                                        <span class="star text-yellow">
                                            <?= $model->getRating($model->_id); ?>
                                        </span>
                                    </div>
                                    <div class="total">
                                        <i class="fa fa-user"></i> <?= $model->getCountReview($model->_id); ?> Lượt đánh giá 
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12 detail-rating">
                                    <ul class="list-unstyled">
                                        <?php
                                        foreach ($model->getProgress($model->_id) as $key => $value)
                                        {
                                            if (($model->getCountReview($model->_id)) > 0)
                                            {
                                                $percent = round(($value / $model->getCountReview($model->_id)) * 100, 2);
                                            }
                                            else
                                            {
                                                $percent = 0;
                                            }
                                            echo '<li>
                                                        <div class="tit-rating">
                                                            <i class="fa fa-star"></i> ' . $key . ' 
                                                        </div>
                                                        <div class="progress lev-' . $key . ' ">
                                                            <div style="width: ' . $percent . '%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar bg-success">
                                                                ' . number_format($value, 0, '', ',') . '
                                                            </div> 
                                                        </div>
                                                    </li>';
                                        };
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <h4 class="title-box">Kinh nghiệm làm việc</h4>
                            <div class="exp">
                                <div class="row">
                                    <?php
                                    if (!empty($workdone))
                                    {
                                        foreach ($workdone as $value)
                                        {
                                            ?>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <?php
                                                if (!empty($value->files))
                                                {
                                                    foreach ($value->files as $file)
                                                    {
                                                        echo '<a class="fancybox" href="' . Yii::$app->setting->value('url_file') . $file . '" data-fancybox-group="gallery"><img class="img-rounded" style="width:60px;" src="' . \Yii::$app->params['url_file'] . 'thumbnails/' . $file . '"></a>';
                                                    }
                                                }
                                                ?>
                                                <h5><?= $value->name ?></h5>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                </div>
                                <!--                                <div class="row">
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
                                                                </div>-->
                            </div>
                            <h4 class="title-box">Kiểm tra năng lực chuyên môn</h4>
                            <div class="tests">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr><th>Tên bài kiểm tra</th><th>Điểm tối đa (10)</th><th>Thời gian hoàn tất</th></tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($test))
                                            {
                                                foreach ($test as $value)
                                                {
                                                    $point = number_format($value->point * (10 / $value->sector->test_number), 1, '.', '');
                                                    if ($point < 5)
                                                        $rank = '<span class="label label-danger">Yếu</span>';
                                                    elseif ($point >= 5 || $point < 6.5)
                                                        $rank = '<span class="label label-info">Trung bình</span>';
                                                    elseif ($point >= 6.5 || $point < 8)
                                                        $rank = '<span class="label label-success">Khá</span>';
                                                    else
                                                        $rank = '<span class="label label-warning">Tốt</span>';

                                                    $time = $value->sector->test_time - number_format(str_replace(':', '.', $value->count_time), 2, '.', '');
                                                    ?>
                                                    <tr><td><?= $value->sector->name ?></td><td><span class="point"><?= $point ?> </span><?= $rank ?></td><td><?= $time ?> phút</td></tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <h4 class="title-box">Quá trình làm việc</h4>
                            <?php
                            if (!empty($workprocess))
                            {
                                foreach ($workprocess as $value)
                                {
                                    ?>
                                    <h5><b><?= $value->position ?></b> | <?= $value->company ?></h5>
                                    <small>Tháng <?= $value->created_begin ?> - <?= $value->created_end ?></small>
                                    <?php
                                }
                            }
                            ?>
                            <h4 class="title-box">Trình độ học vấn</h4>
                            <?php
                            if (!empty($edu))
                            {
                                foreach ($edu as $value)
                                {
                                    ?>
                                    <h5><b><?= $value->course ?></b> | <?= $value->school ?></h5>
                                    <small>Tháng <?= $value->created_begin ?> - <?= $value->created_end ?></small>
                                    <?php
                                }
                            }
                            ?>
                            <!--                            <h4 class="title-box">Kỹ năng khác</h4>
                                                        <p class="text">
                                                            “ nteger scelerisque turpis urna magna habitasse? Duis pellentesque, rhoncus a, eros, placerat integer augue ac montes cras lacus turpis augue, nisi porta! Ac magna? Nunc tempor. Tristique vel, vel aliquet, odio lectus et? Montes, mus! Facilisis turpis duis pellentesque eu, tincidunt nisi vel magna porta vut tempor scelerisque! Nec turpis.”
                                                            nteger scelerisque turpis urna magna habitasse? Duis pellentesque, rhoncus a, eros, placerat integer augue ac montes cras lacus turpis augue, nisi porta! Ac magna? Nunc tempor. Tristique vel, vel aliquet.
                            
                                                        </p>-->
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
</section>
<div class="modal fade" id="userBid" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Book nhân viên</h4>
            </div>
            <div class="modal-body">

                <?php $form = ActiveForm::begin(['id' => 'formUserBid', 'options' => ['class' => 'form-horizontal']]); ?>  
                <p class="success_userbid"></p>
                <div class="form-group">
                    <label class="col-sm-3">Nhân viên</label>
                    <div class="col-sm-9">
                        <strong class="userbid-name"></strong>
                        <?= $form->field($userbid, 'actor_id')->hiddenInput()->label(FALSE) ?>
                    </div>
                </div>

                <?= $form->field($userbid, 'message', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label" style="text-align:left">{label}</label><div  class="col-md-9 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textarea() ?>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-8">
                        <button id="submitUserBid" type="submit" class="btn btn-default btn-boss">Book</button>
                        <a href="#"  data-dismiss="modal" class="alert"><strong>Hủy</strong></a>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?= $this->render('/membership/_modalinvited', ['job' => $job, 'invited' => $invited]) ?>
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
$('.fancybox').fancybox();
") ?>
<?= $this->registerJs("$(document).on('click', '.userbid', function (event){
        event.preventDefault();
        var user_id = $(this).attr('data-id');
        var user_name = $('.user-'+user_id+' .name').text();
        $('#userBid').modal('show');
        $('#userBid').find('.modal-body .userbid-name').text(user_name);
        $('#userBid').find('.modal-body #userbid-actor_id').val(user_id);
    

});") ?>
<?= $this->registerJs("$(document).on('submit', '#formUserBid', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/userbid"]) . "',
               type: 'post',
          data: $('form#formUserBid').serialize(),
        success: function(data, status) {
          if(data){
             $('.success_userbid').html('Đã book thành công');
          $('.options p').html('<label class=\'text-danger\'>Đã book nhân viên này</label>');
                 window.setTimeout(function () {
                $('.success_userbid').html('');
            }, 1000);
                      window.setTimeout(function () {
                   $('#userBid').modal('hide'); 
            }, 2000);
         
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
