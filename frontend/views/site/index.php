<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\models\Job;

$this->title = 'Giao nhận việc';
?>

<section>
    <!-- slide main -->
    <div class="slide_main demo-2">
        <div id="slider" class="sl-slider-wrapper container">
            <div class="sl-slider">
                <?php
                if (!empty($sildehome))
                {
                    foreach ($sildehome as $key => $value)
                    {
                        ?>
                        <div class="sl-slide" data-orientation="<?php
                        if ($key % 2 == 0)
                        {
                            echo 'horizontal';
                        }
                        else
                        {
                            echo 'vertical';
                        }
                        ?>" data-slice1-rotation="20" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="2">
                            <div class="sl-slide-inner">
                                <div class="bg-img bg-img-1" style="background-image:url(<?= $value->thumbnail ?>)"></div>
                                <?= $value->content ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div><!-- /sl-slider -->

            <nav id="nav-dots" class="nav-dots">
                <?php
                if (!empty($sildehome))
                {
                    foreach ($sildehome as $key => $value)
                    {
                        ?>
                        <span class="<?php
                        if ($key == 0)
                        {
                            echo 'nav-dot-current';
                        }
                        ?>"></span>
                              <?php
                          }
                      }
                      ?>
            </nav>

        </div><!-- /slider-wrapper -->

        <!-- register button -->
        <div class="div-position">
            <div class="container ">
                <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12 register_box" >
                    <?php
                    if (\Yii::$app->user->isGuest)
                    {
                        ?>
                        <div class="row">
                            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['page/pageboss']) ?>">
                                            <div class="btn-register">
                                                <button type="button" class="btn btn-boss">Trở thành boss</button>
                                                <div class="clear-fix"></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['page/pageworkers']) ?>">
                                            <div class="btn-register">
                                                <button type="button" class="btn btn-nhanvien">Trở thành nhân viên</button>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 text-center guide-link">
                                        <?= Html::a('Xem hướng dẫn sữ dụng &raquo;', ['help/manual']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div class="row">
                            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
                                <div class="row">
                                    <?php $form = ActiveForm::begin(['id' => 'frmSearchjob', 'action' => Yii::$app->urlManager->createAbsoluteUrl(['job/fillter']), 'method' => 'get', 'options' => ['class' => 'form-horizontal']]); ?> 
                                    <div class="col-sm-12 col-xs-12 row-search">
                                        <input class="txt-keysearch form-control" name="k" type="text" value="" placeholder="Nhập tên công việc ...">
                                        <button type="submit" class="btn btn-blue">Tìm kiếm </button>
                                    </div>
                                    <div class="col-sm-12 col-xs-12 row-search">
                                        <div class="col-sm-4 col-xs-12 col-search select">
                                            <select id="jobCategory" class="form-control" name="t">
                                                <option class="sec-item" value="">Tất cả ngành nghề</option>
                                                <?php
                                                foreach ($jobCategory as $key => $value)
                                                {
                                                    ?>
                                                    <option value="<?= $value->_id ?>"><?= $value->name ?></option>
                                                <?php } ?>
                                            </select> 
                                        </div>
                                        <div class="col-sm-4 col-xs-12 col-search select">
                                            <select id="jobSector" class="form-control" name="s" >
                                                <option class="sec-item" value="">Tất cả lĩnh vực</option>
                                                <?php
                                                foreach ($jobCategory as $k => $value)
                                                {
                                                    echo '<option class="sec-' . $value->_id . ' sec-item item" value="">Tất cả lĩnh vực</option>';
                                                    foreach ($value->getJobsector((string) $value->_id) as $val)
                                                    {
                                                        ?>
                                                        <option class="sec-<?= $value->_id ?> sec-item item" value="<?= $val->_id ?>"><?= $val->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>     
                                            </select> 
                                        </div>
                                        <style type="text/css">
                                            #jobSector option {display: none;}
                                        </style>
                                        <div class="col-sm-4 col-xs-12 col-search select">
                                            <select class="form-control" name="d">
                                                <option value="">Toàn quốc</option>
                                                <?php
                                                foreach ($city as $value)
                                                {
                                                    ?>
                                                    <option value="<?= $value->_id ?>"><?= $value->name ?></option>
                                                <?php } ?>
                                            </select> 
                                        </div>
                                    </div>  
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?> 
            </div> 
        </div>
    </div>
    <!-- End register button -->
</div>
<!-- End slide main -->
</section>

<!-- view count -->
<section>
    <div class="view-count">
        <div class="container">
            <div class="row">
                <!-- count item -->
                <div class="col-ms-4 col-sm-4 col-xs-12 count-item">
                    <div class="number-count">
                        <?= number_format($totalmember, 0, '', '.') ?>
                    </div>
                    <div class="line-white"></div>
                    <h4>nhân viên trực tuyến</h4>
                </div>
                <!-- End count item -->
                <!-- count item -->
                <div class="col-ms-4 col-sm-4 col-xs-12 count-item">
                    <div class="number-count">
                        <?= number_format($totaljob, 0, '', '.') ?>
                    </div>
                    <div class="line-white"></div>
                    <h4>công việc được đăng</h4>
                </div>
                <!-- End count item -->
                <!-- count item -->
                <div class="col-ms-4 col-sm-4 col-xs-12 count-item">
                    <div class="number-count">
                        <?= number_format($totalprice, 0, '', '.') ?>

                    </div>
                    <div class="line-white"></div>
                    <h4>tổng trị giá công việc</h4>
                </div>
                <!-- End count item -->
            </div>
        </div>
    </div>
</section>

<!-- new jobs -->
<section>
    <div class="new-jobs">
        <div class="container">
            <div class="row">
                <!-- danh sach cong viec -->
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="title-container">
                        <h4>Công việc mới nhất <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/index']) ?>" class="readmore pull-right">Xem thêm <i class="fa fa-angle-double-right"></i></small></a>
                    </div>
                    <?php
                    if (!empty($jobs))
                    {
                        foreach ($jobs as $job)
                        {
                            $job_id = (string) $job->_id;
                            ?>
                            <!-- job item -->
                            <div class="job featured-job">
                                <div class="row">
                                    <?php
                                    if ($job->featured == Job::FEATURED_OPEN)
                                    {
                                        echo '<div class="jobhot"></div>';
                                    }
                                    ?>
                                    <div class="jobitem-info">
                                        <div class="col-md-8 col-ms-8 col-xs-12">
                                            <h4>
                                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['cong-viec/' . $job['slug'] . '-' . (string) $job['_id']]) ?>" title="<?= $job->name ?>"><?= $job['name'] ?></a>
                                            </h4>
                                        </div>
                                        <?php
                                        if (!Yii::$app->user->isGuest)
                                        {
                                            if (!Yii::$app->info->isboss())
                                            {
                                                ?>
                                                <div class="col-md-3 col-sm-4 col-xs-5 text-right button-job option-<?= $job_id ?>">
                                                    <?php
                                                    if (!Yii::$app->user->isGuest)
                                                    {
                                                        $findBid = $job->getBidexits($job_id);
                                                        if (!empty($findBid))
                                                        {
                                                            ?>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-square dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Chỉnh sửa<span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <?php
                                                                    if (empty($assign))
                                                                    {
                                                                        ?>
                                                                        <li><a href="javascript:void(0)" class="update" data-id="<?= (string) $findBid->_id ?>"><i class="fa fa-pencil"></i> Sửa</a></li>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <li><a href="javascript:void(0)" data-id="<?= (string) $findBid->_id ?>" data-toggle="modal" data-target="#confirm-delete"  data-alert="Bạn có muốn hủy book công việc này không"><i class="fa fa-trash-o"></i> Hủy book</a></li>
                                                                    <div class="clear-fix"></div>
                                                                </ul>
                                                            </div>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <a href="javascript:void(0)" class="btn btn-info book" data-id="<?= $job_id ?>" data-title="<?= $job->name ?>">Book việc</a>
                                                            <?php
                                                        }
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <a href="javascript:void(0)" class="btn btn-info book" data-id="<?= $job_id ?>" data-title="<?= $job->name ?>">Book việc</a>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-md-1 col-sm-2 col-xs-4 button-job job-heart">
                                                    <?php
                                                    if (!Yii::$app->user->isGuest)
                                                    {
                                                        $like = $job->getLikeexits();
                                                        if (!empty($like))
                                                        {
                                                            ?>
                                                            <a href="javascript:void(0)" class="color like like-<?= (string) $job->_id ?>" data-bind="<?= (string) $job->_id ?>" title="Đã lưu" ><i class="fa fa-heart"></i> </a>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <a href="javascript:void(0)" class="color like like-<?= (string) $job->_id ?>" data-bind="<?= (string) $job->_id ?>" title="Lưu việc" ><i class="fa fa-heart-o"></i></a>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <div class="col-md-4 col-sm-4 col-xs-5 text-right button-job option-<?= $job_id ?>" style="padding-right:15px">
                                                <a href="javascript:void(0)" class="btn btn-info book" data-id="<?= $job_id ?>" data-title="<?= $job->name ?>">Book việc</a>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="col-ms-12 col-xs-12 content-job">
                                            <p><?= $job->category->name ?>/ <?= $job->sector->name ?> - <i class="fa fa-clock-o text-green" aria-hidden="true"></i> Còn lại <b><?= Yii::$app->convert->countdown($job->deadline) ?></b></p>
                                            <p><i class="fa fa-money text-orange" aria-hidden="true"></i> <?php
                                                echo 'Ngân sách: <b> ' . $job->budget . '</b>';
                                                ?> - <i class="fa fa-calendar text-danger" aria-hidden="true"></i> Ngày đăng: <b><?= date('d/m/Y', $job->created_at) ?></b></p>
                                            <p>
                                                <?= Yii::$app->convert->excerpt($job->description, 250) ?>
                                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . (string) $job->_id) ?>"><b> Xem thêm </b></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End job item -->
                            <?php
                        }
                    }
                    ?>

                    <!-- banner -->
                    <div class="row banner-index">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <img class="img-responsive" src="/images/banner/banner-index2.png" alt="banner-index-1">
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <img class="img-responsive" src="/images/banner/banner-index1.png" alt="banner-index-1">
                        </div>
                    </div>
                    <!-- End / banner -->
                </div>

                <!-- danh sach nhan vien -->
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="title-container">
                        <h4>Nhân viên nổi bật</h4>
                    </div>
                    <div class="list-member featured-member">
                        <?php
                        foreach ($members as $member)
                        {
                            ?>
                            <div class="well profile-member">
                                <div class="info">
                                    <div class="profile">
                                        <img class="avatar img-circle" width="100" src="<?= Yii::$app->setting->value('url_file') ?>thumbnails/<?= !empty($member->avatar) ? '150-' . $member->avatar : "avatar.png" ?>">
                                        <div class="num-review">
                                            <h5>Đánh giá: </h5> <span><?= $member->getPoint($member->_id) ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-content text-left">
                                        <h5><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $member->slug) ?>"><b><?= $member->name ?></b></a></h5>
                                        <p><b><?= $member->findcategory->name ?></b> </p>
                                        <p><i class="fa fa-map-marker"></i> <?= $member->location->name ?>, <?= $member->location->city->name ?></p>
                                        <p>
                                            Đánh giá: 
                                            <span class="star text-blue">
                                                <?= $member->getRating($member->_id); ?>
                                            </span> <?= $member->getCountReview($member->_id); ?><i class="fa fa-user"></i>
                                        </p>

                                    </div>
                                </div>
                            </div>  
                        <?php } ?>
                    </div>
                </div>    
                <!-- End / sanh sach nhan vien -->
            </div>
        </div>
    </div>
</section>
<!-- End new jobs -->


<!-- review partner -->
<?php
if (!empty($customer))
{
    ?>
    <section>
        <div class="review-partner">
            <div class="container">
                <div class="row">
                    <div class="title-container text-center">
                        <h3>NHẬN XÉT KHÁCH HÀNG</h3>
                    </div>
                    <div id="reviews_customer" class="slider-pro">
                        <div class="sp-slides">
                            <?php
                            foreach ($customer as $key => $cust)
                            {
                                ?>
                                <div class="sp-slide">
                                    <div class="quotes">
                                        <div class="quotes2">
                                            <p class="sp-layer sp-black sp-padding hide-small-screen" 
                                               data-horizontal="40" data-vertical="10%" data-show-transition="left" data-show-delay="400" data-hide-transition="left" data-hide-delay="500">
                                                   <?= $cust->content ?>
                                            </p>
                                            <div class="clear-fix"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="sp-thumbnails">

                            <?php
                            foreach ($customer as $key => $cust)
                            {
                                ?>
                                <div class="sp-thumbnail">
                                    <div class="avatar">
                                        <img class="img-circle" width="100" src="<?= $cust->thumbnail ?>" alt="<?= $cust->name ?>">
                                    </div>
                                    <div class="sp-thumbnail-title"><?= $cust->name ?></div>
                                    <div class="sp-thumbnail-description"><?= $cust->description ?></div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </section>
<?php } ?>
<!-- End review partner -->



<!-- jobs -->
<section>
    <div class="jobs-container">
        <div class="container">
            <div class="title-container text-center">
                <h3>Chọn dịch vụ phù hợp với nhu cầu của bạn</h3>
            </div>
            <!-- jobs -->
            <div class="row">
                <?php
                if (!empty($jobCategory))
                {
                    foreach ($jobCategory as $value)
                    {
                        ?>
                        <!-- job item -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('danh-muc-nganh-nghe#' . $value->slug) ?>" title="<?= $value->name ?>">
                                <div class="job-item">
                                    <div class="icon job-<?= $value['icon'] ?>"></div>
                                    <div class="line-gray"></div>
                                    <div class="title-job">
                                        <h4><?= $value['name'] ?></h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- End job item -->
                        <?php
                    }
                }
                ?>

            </div>
            <!-- End jobs -->
            <div class="more-jobs">
                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['category/index']) ?>" class="btn btn-square" title="Danh mục ngành nghề">Xem tất cả các danh mục</a>

            </div>
        </div>
    </div>
</section>
<!-- End jobs -->

<!-- introduce -->
<section>
    <div class="introduce">
        <div class="container">
            <div class="row">
                <div class="title-container text-center">
                    <h3>Tại sao chọn Giaonhanviec.com</h3>
                </div>
                <!-- introduce item -->
                <div class="col-md-4 col-sm-4 col-xs-12 introduce-item">
                    <div class="intro-item howdo">
                        <div class="video">
                            <img src="images/banner/video.png" alt="video">
                        </div>
                        <h5>công việc đã hoàn thành bởi các nhân viên tài năng</h5>
                        <div class="intro-content">
                            <p>Nhận đươc kết quả tuyệt vời khi làm việc với các lập trình viên, nhà thiết kế, dịch giả,... trực tuyến hàng đầu. Thuê nhân viên online với sự an tâm, bạn luôn biết kinh nghiệm làm việc của họ từ phản hồi của các khách hàng khác.</p>
                        </div>
                        <div class="guide-button">
                            <div class="guide-button">
                                <?= Html::a('<button type="button" class="btn btn-square">làm việc như thế nào?</button>', ['help/manual']); ?>
                            </div>
                        </div>
                    </div>
                </div>    
                <!-- introduce item -->

                <!-- introduce item -->
                <div class="col-md-4 col-sm-4 col-xs-12 introduce-item">
                    <div class="intro-item search-nv">
                        <div class="video">
                            <img src="images/banner/video_2.png" alt="video">
                        </div>
                        <h5>tìm nhân viên phù hợp nhanh chóng</h5>
                        <div class="intro-content">
                            <p>Bắt đầu công việc của bạn hầu như ngay lập tức. Bạn dễ dàng có một danh sách các nhân viên có tay nghề, chọn lựa và thuê nhân viên phù hợp với yêu cầu của bạn. Có thể phỏng vấn trực tuyến và thuê nhân viên chỉ với một nút bấm đơn giản</p>
                        </div>
                        <div class="guide-button">
                            <div class="guide-button">
                                <?= Html::a('<button type="button" class="btn btn-square">tìm nhân viên</button>', ['membership/index']); ?>
                            </div>
                        </div>
                    </div>
                </div>    
                <!-- introduce item -->

                <!-- introduce item -->
                <div class="col-md-4 col-sm-4 col-xs-12 introduce-item">
                    <div class="intro-item start-job">
                        <div class="video">
                            <img src="images/banner/video_3.png" alt="video">
                        </div>
                        <h5>làm việc cùng nhau một cách dễ dàng</h5>
                        <div class="intro-content">
                            <p>Cộng tác làm việc trong một môi trương trực tuyến an toàn bằng cách sử dụng những công cụ truyền thông mới nhất. Làm việc không phải căng thắng với thời gian theo dõi, báo cáo. Giaonhanviec.com  đảm bảo rằng bạn chỉ phải trả cho công việc bạn chấp nhận.</p>
                        </div>
                        <div class="guide-button">
                            <div class="guide-button">
                                <?= Html::a('<button type="button" class="btn btn-square">bắt đầu ngay</button>', ['job/index']); ?>
                            </div>
                        </div>
                    </div>
                </div>    
                <!-- introduce item -->


            </div>
        </div>
    </div>
</section>
<!-- End introduce -->



<!--  -->
<section>
    <div class="manager-container">
        <div class="container">
            <h4>Bạn cần người quản lí các dự án lớn?</h4>
            <h4>Giaonhanviec.com sẽ giúp bạn!</h4>
            <div class="more-manager">
                <a href="#">
                    <button type="button" class="btn btn-square">Xem thêm Quản lý dự án</button>
                </a>
            </div>
        </div>
    </div>
</section>





<?= $this->render('/job/_bidjs') ?>
<?= $this->registerJs("$(document).on('click', '.like', function (event){
        event.preventDefault();
        var job_id = $(this).attr('data-bind');
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/savejob"]) . "',
            type: 'post',
            data: {job_id:job_id},
            success: function(data) {
                if(data==2){
                $('.like-'+job_id).html('<i class=\"fa fa-heart\"></i>');
                } else {
                $('.like-'+job_id).html('<i class=\"fa fa-heart-o\"></i>');
                }
            }
        });

});") ?>

<!-- select job category -->
<?= $this->registerJs("
    $('#jobCategory').change(function(){
        $('.sec-item').removeAttr('selected');
        $('.sec-item.item').hide();
        $('.sec-'+$(this).val()).show();
        $('.sec-'+$(this).val()).first().attr('selected','selected');
        
    })
") ?>

<!-- slide main -->
<?= $this->registerJs("
$(function () {
    var Page = (function () {
        var nav = $('#nav-dots > span'),
        slitslider = $('#slider').slitslider({
            onBeforeChange: function (slide, pos) {
                nav.removeClass('nav-dot-current');
                nav.eq(pos).addClass('nav-dot-current');
            }
        }),
        init = function () {
            initEvents();
        },
        initEvents = function () {
            nav.each(function (i) {
                $(this).on('click', function (event) {
                    var dot = $(this);
                    if (!slitslider.isActive()) {
                        nav.removeClass('nav-dot-current');
                        dot.addClass('nav-dot-current');
                    }
                    slitslider.jump(i + 1);
                    return false;
                });
            });
        };
        return {
            init: init
        };
    })();
    Page.init();
});") ?>


<!-- customer comment -->
<?= $this->registerJs("
$(document).ready(function ($) {
    $('#reviews_customer').sliderPro({
        width: 1100,
        height: 240,
        arrows: true,
        buttons: false,
        waitForLayers: true,
        thumbnailWidth: 363,
        thumbnailHeight: 150,
        thumbnailPointer: true,
        autoplay: true,
        autoScaleLayers: true,
        breakpoints: {
            500: {
                thumbnailWidth: 120,
                thumbnailHeight: 50
            }
        }
    });
});") ?>
