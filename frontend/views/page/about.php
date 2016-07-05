<?php 
use common\models\Page;
$this->title = 'Giới thiệu về Giaonhanviec';
?>
<section>
            <!-- slide main -->
            <div class="slide_main slide-help">
                <div class="container">
                    <!-- End slide content -->
                    <!-- slide content -->
                    <div id="owl-demo" class="owl-carousel2">
                        <div class="item">
                            <h3>VỀ GIAONHANVIEC.COM</h3>
                            <div class="content-info">
                                <p>Hệ thống làm việc trực tuyến lần đầu tiên xuất hiện tại Việt Nam</p>
                            </div>
                        </div>
                        <div class="item">
                            <h3>VỀ GIAONHANVIEC.COM</h3>
                            <div class="content-info">
                                <p>Hệ thống làm việc trực tuyến lần đầu tiên xuất hiện tại Việt Nam</p>
                            </div>
                        </div>
                        <div class="item">
                            <h3>VỀ GIAONHANVIEC.COM</h3>
                            <div class="content-info">
                                <p>Hệ thống làm việc trực tuyến lần đầu tiên xuất hiện tại Việt Nam</p>
                            </div>
                        </div>
                    </div>
                    <!-- End slide content -->
                </div>
            </div>
            <!-- End slide main -->
        </section>


        <!-- page jobs -->
        <section>
            <div class="about-box">
                <div class="container">
                    <!-- div tab jobs-->
                    <!--Horizontal Tab-->
                    <div id="horizontalTab">
                        <ul>
                            <li><a href="#gioi-thieu">giới thiệu</a></li>
                            <li><a href="#co-hoi-nghe-nghiep">cơ hội nghề nghiệp</a></li>
                            <li><a href="#doi-ngu-nhan-vien">đội ngũ</a></li>
                            <li><a href="#doi-tac">đối tác</a></li>
                            <li><a href="#bao-chi">báo chí</a></li>
                            <li><a href="#lien-he">liên hệ</a></li>
                        </ul>

                        <div id="gioi-thieu" class="tab-tem">
                            <div class="tab-gioi-thieu">
                                <?php 
                                    echo $about->content;
                                ?>
                            </div>
                        </div>
                        <div id="co-hoi-nghe-nghiep" class="tab-tem">
                            <div class="tab-co-hoi-nghe-nghiep">
                                <?php 
                                    echo $recruit->content;
                                ?>
                                <div class="join-team text-center">
                                    <h4>Join our team</h4>
                                    <div class="text-center">
                                        <div class="line-blue"></div>
                                    </div>
                                    <a href=""><button type="button" class="btn btn-blue">xem các vị trí đang tuyển dụng</button></a>
                                </div>
                                
                            </div>
                        </div>
                        <div id="doi-ngu-nhan-vien" class="tab-tem">
                            <div class="tab-doi-ngu">
                                <?php 
                                    echo $membership->content;
                                ?>
                            </div>
                        </div>
                        <div id="doi-tac" class="tab-tem">
                            <div class="tab-doi-tac">
                                <?php echo $partner->content;?>
                            </div>
                        </div>

                        <div id="bao-chi" class="tab-tem">
                            <div class="tab-bao-chi">
                                <?php echo $newspaper->content;?>
                            </div>
                        </div>

                        <div id="lien-he" class="tab-tem">
                            <div class="tab-lien-he">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <h5 class="title-tab">Gởi yêu cầu</h5>
                                        <div>
                                            <form id="frmContact" class="frm-contact" action="" method="post" accept-charset="utf-8">
                                                <label>HỌ VÀ TÊN *</label>
                                                <input name="txt_name" class="form-control input-contact" type="text" value="" required >
                                                <label>EMAIL *</label>
                                                <input name="txt_email" class="form-control input-contact" type="text" value="" required >
                                                <label>SỐ ĐIỆN THOẠI *</label>
                                                <input name="txt_phone" class="form-control input-contact" type="text" value="" required >
                                                <label>NỘI DUNG *</label>
                                                <textarea name="txt_content" class="form-control input-contact" rows="6" required></textarea>
                                                <button type="submit" class="btn btn-blue">GỞI ĐI</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="col-md-12">
                                            <?php echo $info_contact->content; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <h5 class="title-tab text-center">Bản đồ</h5>
                                    <div class="col-md-3 col-sm-3"></div>
                                    <div class="col-md-6 col-sm-6 line"></div>
                                    <div class="col-md-3 col-sm-3"></div>
                                    <?php echo $map_contact->content;?>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- End div tab jobs-->
                </div>
            </div>
        </section>
        <!-- End page content -->



<!-- slide main content -->
<?= $this->registerJs("            
    $(document).ready(function() {
        $('#owl-demo').owlCarousel({
            navigation : false,
            slideSpeed : 500,
            paginationSpeed : 400,
            singleItem : true,
            autoPlay : true
        });
    });
");?>

<!-- Responsive Tabs JS -->
<?= $this->registerJs("
    $(document).ready(function () {
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
    });
");?>

    <!-- scroll to top -->
<?= $this->registerJs("
    $(document).ready(function(){
    
        //Check to see if the window is top if not then display button
        $(window).scroll(function(){
            if ($(this).scrollTop() > 300) {
                $('.scroll-top').fadeIn();
            } else {
                $('.scroll-top').fadeOut();
            }
        });
        
        //Click event to scroll to top
        $('#Scrolltop').click(function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });
        
    });
");?>       