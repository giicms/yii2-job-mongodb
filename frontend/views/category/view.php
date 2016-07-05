<?php
$this->title = $category->name;
?>
<section>
            <!-- slide main -->
            <div class="slide_main slide-jobs slide-info">
                <div class="container">
                    <!-- slide content -->
                    <div id="owl-demo" class="owl-carousel2">
                        <div class="item">
                            <h3>Thiết kế, Đồ họa, Video</h3>
                            <div class="content-info">
                                <p>Tìm kiếm các nhà thiết kế sáng tạo được đánh giá cao nhất</p>
                            </div>
                        </div>
                        <div class="item">
                            <h3>Lập trình Website, ứng dụng di động</h3>
                            <div class="content-info">
                                <p>Bắt đầu công việc của bạn hầu như ngay lập tức thật dễ dàng</p>
                            </div>
                        </div>
                        <div class="item">
                            <h3>Viết bài, Dịch thuật</h3>
                            <div class="content-info">
                                <p>Bạn có một danh sách các nhân viên có tay nghề để lựa chọn làm việc</p>
                            </div>
                        </div>
                    </div>
                    <!-- End slide content -->
                    <div class="text-center">
                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/index']) ?>"><button class="btn btn-blue" type="button">bắt đầu</button></a>
                    </div>
                </div>
            </div>
            <!-- End slide main -->
        </section>


        <!-- page jobs -->
        <section>
            <div class="jobs-box">
                <div class="container">
                    <!-- div tab jobs-->
                    <!--Horizontal Tab-->
                    <div id="horizontalTab">
                        <ul>
                        <?php 
                            foreach ($jobCategory as $key => $value) {
                                echo '<li><a href="#'.$value->slug.'">'.$value['name'].'</a></li>';
                            }
                        ?>
                        </ul>

                        <?php 
                            foreach ($jobCategory as $key => $value) {
                                $sectors = $value->getJobsector((string)$value->_id);
                        ?>
                        <div id="<?=$value->slug?>" class="tab-tem">
                            <div id="post_6" class="title-container text-center">
                                <h3>Một số lĩnh vực phổ biến nhất của chúng tôi:</h3>
                            </div>
                            <div class="row">
                                <?php 
                                    if(!empty($sectors)){
                                    foreach ($sectors as $sector) {
                                ?>
                                <!-- item section job -->
                                <div class="col-md-2 col-sm-3 col-xs-6">
                                    <div class="job-item text-center">
                                        <div class="icon job-<?=$sector['icon'];?>"></div>
                                        <div class="line-gray"></div>
                                        <div class="title-job">
                                            <h4><?=$sector['name'];?></h4>
                                        </div>
                                    </div>
                                </div>
                                <!-- end item section job -->
                                <?php
                                    }}
                                ?>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <!-- End div tab jobs-->
                </div>
            </div>
        </section>
        <!-- End page content -->

        <!-- members-box -->
        <section>
            <div class="members-box">
                <div class="container">
                    <div class="title-container text-center">
                        <h3>Các nhà thiết kế sáng tạo được đánh giá hàng đầu</h3>
                    </div>
                    <!-- slide members -->
                    <div id="owl-member" class="owl-carousel owl-theme">

                        <!-- member item -->
                        <div class="item">
                                <div class="info-member">
                                    <div class="avatar">
                                        <img class="img-circle" width="120" src="images/customer/1.jpg" alt="">
                                    </div>
                                    <h4><a href="#">nguyễn hoàng liên sơn</a></h4>
                                    <div class="line-gray"></div>
                                    <h3>Graphic Design</h3>
                                </div>
                                <div class="summary">
                                    <div class="col-6 rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <span>(4.0)</span>
                                    </div>  
                                    <div class="col-6 local">
                                        <i class="fa fa-map-marker"></i>
                                        <span>Đà Nẵng</span>
                                    </div> 
                                    <div class="clear-fix"></div>     
                                </div>
                                <div class="skill">
                                    <button class="button">Photoshop</button> 
                                    <button class="button">html/css</button> 
                                    <button class="button">Flash</button>
                                </div>
                                <div class="bottom-inf">
                                    <p>roin dignissim faucibus odio sollicitudin sagittis roin dignissim faucibus odio</p>
                                    <a  href=""><button class="btn btn-blue" type="button">Xem hồ sơ</button></a>
                                </div>
                        </div>
                        <!-- End member item -->

                        <!-- member item -->
                        <div class="item">
                                <div class="info-member">
                                    <div class="avatar">
                                        <img class="img-circle" width="120" src="images/customer/2.jpg" alt="">
                                    </div>
                                    <h4><a href="#">nguyễn hoàng liên sơn</a></h4>
                                    <div class="line-gray"></div>
                                    <h3>Graphic Design</h3>
                                </div>
                                <div class="summary">
                                    <div class="col-6 rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <span>(4.0)</span>
                                    </div>  
                                    <div class="col-6 local">
                                        <i class="fa fa-map-marker"></i>
                                        <span>Đà Nẵng</span>
                                    </div>
                                    <div class="clear-fix"></div>      
                                </div>
                                <div class="skill">
                                    <button class="button">Photoshop</button> 
                                    <button class="button">html/css</button> 
                                    <button class="button">Flash</button>
                                </div>
                                <div class="bottom-inf">
                                    <p>roin dignissim faucibus odio sollicitudin sagittis roin dignissim faucibus odio</p>
                                    <a href=""><button class="btn btn-blue" type="button">Xem hồ sơ</button></a>
                                </div>
                        </div>
                        <!-- End member item -->

                        <!-- member item -->
                        <div class="item">
                                <div class="info-member">
                                    <div class="avatar">
                                        <img class="img-circle" width="120" src="images/customer/3.jpg" alt="">
                                    </div>
                                    <h4><a href="#">nguyễn hoàng liên sơn</a></h4>
                                    <div class="line-gray"></div>
                                    <h3>Graphic Design</h3>
                                </div>
                                <div class="summary">
                                    <div class="col-6 rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <span>(4.0)</span>
                                    </div>  
                                    <div class="col-6 local">
                                        <i class="fa fa-map-marker"></i>
                                        <span>Đà Nẵng</span>
                                    </div>  
                                    <div class="clear-fix"></div>    
                                </div>
                                <div class="skill">
                                    <button class="button">Photoshop</button> 
                                    <button class="button">html/css</button> 
                                    <button class="button">Flash</button>
                                </div>
                                <div class="bottom-inf">
                                    <p>roin dignissim faucibus odio sollicitudin sagittis roin dignissim faucibus odio</p>
                                    <a href=""><button class="btn btn-blue" type="button">Xem hồ sơ</button></a>
                                </div>
                        </div>
                        <!-- End member item -->

                        <!-- member item -->
                        <div class="item">
                                <div class="info-member">
                                    <div class="avatar">
                                        <img class="img-circle" width="120" src="images/customer/4.jpg" alt="">
                                    </div>
                                    <h4><a href="#">nguyễn hoàng liên sơn</a></h4>
                                    <div class="line-gray"></div>
                                    <h3>Graphic Design</h3>
                                </div>
                                <div class="summary">
                                    <div class="col-6 rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <span>(4.0)</span>
                                    </div>  
                                    <div class="col-6 local">
                                        <i class="fa fa-map-marker"></i>
                                        <span>Đà Nẵng</span>
                                    </div> 
                                    <div class="clear-fix"></div>     
                                </div>
                                <div class="skill">
                                    <button class="button">Photoshop</button> 
                                    <button class="button">html/css</button> 
                                    <button class="button">Flash</button>
                                </div>
                                <div class="bottom-inf">
                                    <p>roin dignissim faucibus odio sollicitudin sagittis roin dignissim faucibus odio</p>
                                    <a href=""><button class="btn btn-blue" type="button">Xem hồ sơ</button></a>
                                </div>
                        </div>
                        <!-- End member item -->

                        <!-- member item -->
                        <div class="item">
                                <div class="info-member">
                                    <div class="avatar">
                                        <img class="img-circle" width="120" src="images/customer/5.jpg" alt="">
                                    </div>
                                    <h4><a href="#">nguyễn hoàng liên sơn</a></h4>
                                    <div class="line-gray"></div>
                                    <h3>Graphic Design</h3>
                                </div>
                                <div class="summary">
                                    <div class="col-6 rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <span>(4.0)</span>
                                    </div>  
                                    <div class="col-6 local">
                                        <i class="fa fa-map-marker"></i>
                                        <span>Đà Nẵng</span>
                                    </div> 
                                    <div class="clear-fix"></div>     
                                </div>
                                <div class="skill">
                                    <button class="button">Photoshop</button> 
                                    <button class="button">html/css</button> 
                                    <button class="button">Flash</button>
                                </div>
                                <div class="bottom-inf">
                                    <p>roin dignissim faucibus odio sollicitudin sagittis roin dignissim faucibus odio</p>
                                    <a href=""><button class="btn btn-blue" type="button">Xem hồ sơ</button></a>
                                </div>
                        </div>
                        <!-- End member item -->

                        <!-- member item -->
                        <div class="item">
                                <div class="info-member">
                                    <div class="avatar">
                                        <img class="img-circle" width="120" src="images/customer/6.jpg" alt="">
                                    </div>
                                    <h4><a href="#">nguyễn hoàng liên sơn</a></h4>
                                    <div class="line-gray"></div>
                                    <h3>Graphic Design</h3>
                                </div>
                                <div class="summary">
                                    <div class="col-6 rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <span>(4.0)</span>
                                    </div>  
                                    <div class="col-6 local">
                                        <i class="fa fa-map-marker"></i>
                                        <span>Đà Nẵng</span>
                                    </div>  
                                    <div class="clear-fix"></div>    
                                </div>
                                <div class="skill">
                                    <button class="button">Photoshop</button> 
                                    <button class="button">html/css</button> 
                                    <button class="button">Flash</button>
                                </div>
                                <div class="bottom-inf">
                                    <p>roin dignissim faucibus odio sollicitudin sagittis roin dignissim faucibus odio</p>
                                    <a href=""><button class="btn btn-blue" type="button">Xem hồ sơ</button></a>
                                </div>
                        </div>
                        <!-- End member item -->
                    </div>
                     
                    <div class="customNavigation">
                      <a class="prev"><i class="fa fa-angle-left"></i></a>
                      <a class="next"><i class="fa fa-angle-right"></i></a>
                    </div>
                    <!-- End slide member -->
                </div>
            </div>
        </section>      
        <!-- End members box -->

        <!-- comment customer -->
        <section>
            <div class="comment-customer">
                <div class="container">
                    <div class="col-sm-12">
                        <div class="col-md-3 col-sm-3"></div>
                        <div class="col-md-6 col-sm-6 line text-center">
                            <img src="images/quotes.png" alt="">
                        </div>
                        <div class="col-md-3 col-sm-3"></div>
                    </div>
                    <!-- slide comment customer  -->
                    <div id="owl-comments" class="owl-carousel2 col-sm-12">
                        <div class="item">
                            <h4>Bắt đầu công việc của bạn hầu như ngay lập tức thật dễ dàng Bạn có một danh sách các nhân viên có tay nghề để lựa chọn làm việc</h3>
                            <div class="line"></div>
                            <h3>Evan Liang // CEO, Lean Data</h3>
                        </div>
                        <div class="item">
                            <h4>Bắt đầu công việc của bạn hầu như ngay lập tức thật dễ dàng Bạn có một danh sách các nhân viên có tay nghề để lựa chọn làm việc</h3>
                            <div class="line"></div>
                            <h3>Evan Liang // CEO, Lean Data</h3>
                        </div>
                        <div class="item">
                            <h4>Bắt đầu công việc của bạn hầu như ngay lập tức thật dễ dàng Bạn có một danh sách các nhân viên có tay nghề để lựa chọn làm việc</h3>
                            <div class="line"></div>
                            <h3>Evan Liang // CEO, Lean Data</h3>
                        </div>
                    </div>
                    <!-- End slide comment customer  -->
                </div>
            </div>
        </section>
        <!-- End customer -->

        <!-- work steps -->
        <section>
            <div class="work-steps">
                <div class="container">
                    <div class="title-container text-center">
                        <h3>Làm việc cùng nhau một cách đơn giản với các bước sau:</h3>
                    </div>
                    <div class="col-ms-6 col-sm-6 col-xs-12">
                        <div class="step text-center">
                            <div class="stp-number">1</div>
                            <div class="line-gray"></div>
                            <div class="stp-title">
                                <h4>đăng việc</h4>
                                <p>Bạn có thể đăng bát kỳ yêu cầu về các lĩnh vực theo nhu cầu</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-ms-6 col-sm-6 col-xs-12">
                        <div class="step text-center">
                            <div class="stp-number">2</div>
                            <div class="line-gray"></div>
                            <div class="stp-title">
                                <h4>chọn nhân viên</h4>
                                <p>Bạn có thể đăng bát kỳ yêu cầu về các lĩnh vực theo nhu cầu</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-ms-6 col-sm-6 col-xs-12">
                        <div class="step text-center">
                            <div class="stp-number">3</div>
                            <div class="line-gray"></div>
                            <div class="stp-title">
                                <h4>làm việc online</h4>
                                <p>Bạn có thể đăng bát kỳ yêu cầu về các lĩnh vực theo nhu cầu</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-ms-6 col-sm-6 col-xs-12">
                        <div class="step text-center">
                            <div class="stp-number">4</div>
                            <div class="line-gray"></div>
                            <div class="stp-title">
                                <h4>duyệt và chi trả</h4>
                                <p>Bạn có thể đăng bát kỳ yêu cầu về các lĩnh vực theo nhu cầu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End work steps -->
        

        <!-- view count -->
        <section>
            <div class="view-count">
                <div class="container">
                    <div class="row">
                        <!-- count item -->
                        <div class="col-ms-4 col-sm-4 col-xs-12 count-item">
                            <div class="number-count">
                                3 ngày
                            </div>
                            <div class="line-white"></div>
                            <h4>thời gian thuê trung bình</h4>
                        </div>
                        <!-- End count item -->
                        <!-- count item -->
                        <div class="col-ms-4 col-sm-4 col-xs-12 count-item">
                            <div class="number-count">
                                98.000
                            </div>
                            <div class="line-white"></div>
                            <h4>các công việc được duyệt</h4>
                        </div>
                        <!-- End count item -->
                        <!-- count item -->
                        <div class="col-ms-4 col-sm-4 col-xs-12 count-item">
                            <div class="number-count">
                                80%
                            </div>
                            <div class="line-white"></div>
                            <h4>được khách hàng thuê lại</h4>
                        </div>
                        <!-- End count item -->
                    </div>
                </div>
            </div>
        </section>
        <!-- End view count -->


<!-- slide top -->
<?= $this->registerJs("$(document).ready(function() {
    $('#owl-demo').owlCarousel({
        navigation : false,
        slideSpeed : 500,
        paginationSpeed : 400,
        singleItem : true,
        autoPlay : true
    });
});") ?>

<!-- slide comment customer-->
<?= $this->registerJs("$(document).ready(function() {
    $('#owl-comments').owlCarousel({
        navigation : false,
        slideSpeed : 800,
        paginationSpeed : 800,
        singleItem : true,
        autoPlay : true
    });
});") ?>
   

<!-- slide members -->
<?= $this->registerJs("$(document).ready(function() {
    var owl = $('#owl-member');
    owl.owlCarousel({
        autoPlay : true, 
        slideSpeed: 900, 
        items : 3, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // betweem 900px and 601px
        itemsTablet: [768,2], //2 items between 600 and 0
        itemsMobile : [350,1] // itemsMobile disabled - inherit from itemsTablet option
    });   
    // Custom Navigation Events
    $('.next').click(function(){
        owl.trigger('owl.next');
    })
    $('.prev').click(function(){
        owl.trigger('owl.prev');
    })
}); ")?>


<!-- tab job category -->
<?= $this->registerJs("$(document).ready(function () {
    var tabs = $('#horizontalTab');
    tabs.responsiveTabs({
        rotate: false,
        startCollapsed: 'accordion',
        collapsible: 'accordion',
        setHash: true,
        //disabled: [3,4],
        activate: function(e, tab) {
            $('.info').html('Tab <strong>' + tab.id + '</strong> activated!');
        },
        activateState: function(e, state) {
            //console.log(state);
            $('.info').html('Switched from <strong>' + state.oldState + '</strong> state to <strong>' + state.newState + '</strong> state!');
        }
    });
});")?>

