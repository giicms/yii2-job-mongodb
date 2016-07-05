<?php 
    use yii\helpers\Html;
    $this->title='Hướng dẫn sữ dụng';
?>
<section>
            <!-- slide main -->
            <div class="slide_main slide-help">
                <div class="container">
                    <!-- End slide content -->
                    <div class="text-center">
                        <div class="title-container text-center">
                            <div class="row">
                                <h3>TRUNG TÂM HỖ TRỢ</h3>
                                <div class="col-md-2 col-ms-2"></div>
                                <div class="col-md-8 col-ms-8 col-xs-12">
                                    <div class="box-search">
                                        <form id="frmSearch" class="frm-search" action="#" method="post" accept-charset="utf-8">
                                            <button class="btn btn-search" type="submit"><i class="fa fa-search"></i></button>
                                            <input class="form-control" id="btn_search" type="text" value="" placeholder="Tìm câu hỏi">
                                            <div class="clear-fix"></div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-2 col-ms-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End slide main -->
        </section>
<?php //var_dump($manual); exit;?>

        <!-- page jobs -->
        <section>
            <div class="help-box">
                <div class="container">
                    <!-- div tab jobs-->
                    <!--Horizontal Tab-->
                    <div class="r-tabs">
                        <ul class="r-tabs-nav">
                            <li class="r-tabs-tab r-tabs-state-default"><?= Html::a('hướng dẫn sữ dụng', ['help/manual']); ?></li>
                            <li class="r-tabs-tab r-tabs-state-active"><?= Html::a('câu hỏi thường gặp', ['help/question']); ?></li>
                            <li class="r-tabs-tab r-tabs-state-default"><?= Html::a('Quy chế báo mật', ['page/privacy']); ?></li>
                            <li class="r-tabs-tab r-tabs-state-default"><?= Html::a('điều khoản sữ dụng', ['page/termsofuse']); ?></li>
                        </ul>
                    </div>    
                        <div id="huong-dan-su-dung" class="tab-tem">
                            <div class="row">
                                <!-- menu -->
                                <div class="col-md-3 col-sm-5 col-xs-12">
                                    <nav id="menu" class="mm-current mm-opened mm-menu mm-effect-slide-menu  mm-offcanvas ">
                                        <ul class="list-unstyled">
                                            <?php 
                                                foreach ($question as $key => $value) {
                                                    ?>
                                                    <li class="<?php if($_GET['id']==$value->_id){echo 'mm-selected';}?>"><a href="<?=Yii::$app->urlManager->createAbsoluteUrl('cau-hoi-thuong-gap/'. $value->slug .'-' . (string)$value->_id)?>"><?=$value->icon.$value->name?></a>
                                                    <?php
                                                    $cate2 = $value->getCateChild($value->_id); //select blogcategory level2
                                                    $post2 = $value->getPost($value->_id); //select post in blogcate level1
                                                    if(!empty($cate2) | !empty($post2)){
                                                        echo '<ul class="list-unstyled">';
                                                        foreach ($cate2 as $key => $val) {
                                                        ?>
                                                        <li class="<?php if($_GET['id']==$val->_id){echo 'mm-selected';}?>"><a href="<?=Yii::$app->urlManager->createAbsoluteUrl('cau-hoi-thuong-gap/'. $val->slug .'-' . (string)$val->_id)?>"><?=$val->name?></a>
                                                        <?php
                                                            $cate3 = $val->getCateChild($val->_id); //select blogcategory level3
                                                            $post3 = $val->getPost($val->_id); //select post in blogcate level2
                                                            if(!empty($cate3) | !empty($post3)){
                                                                echo '<ul class="list-unstyled">';
                                                                foreach ($cate3 as $key => $cat) {
                                                                ?>
                                                                <li class="<?php if($_GET['id']==$cat->_id){echo 'mm-selected';}?>"><a href="<?=Yii::$app->urlManager->createAbsoluteUrl('cau-hoi-thuong-gap/'. $cat->slug .'-' . (string)$cat->_id)?>"><?=$cat->name?></a>
                                                                <?php
                                                                }
                                                                foreach ($post3 as $key => $cat) {
                                                                ?>
                                                                    <li class="<?php if($_GET['id']==$cat->_id){echo 'mm-selected';}?>"><a href="<?=Yii::$app->urlManager->createAbsoluteUrl('cau-hoi-thuong-gap/' . (string)$cat->_id)?>"><?=$cat->name?></a>
                                                                <?php }
                                                                echo '</ul>';
                                                            }
                                                            echo '</li>';
                                                        }
                                                        foreach ($post2 as $key => $val) {
                                                        ?>
                                                            <li class="<?php if($_GET['id']==$val->_id){echo 'mm-selected';}?>"><a href="<?=Yii::$app->urlManager->createAbsoluteUrl('cau-hoi-thuong-gap/' . (string)$val->_id)?>"><?=$val->name?></a>
                                                        <?php           
                                                                }
                                                        echo '</ul>';
                                                    }
                                                    echo '</li>';
                                                }
                                            foreach ($post as $post) {
                                            ?>
                                                <li class="<?php if(!empty($_GET['id'])){if($_GET['id']==$post->_id){echo 'mm-selected';}}?>"><a href="<?=Yii::$app->urlManager->createAbsoluteUrl('cau-hoi-thuong-gap/' . (string)$post->_id)?>"><?=$post->name?></a>
                                            <?php        
                                                }
                                            ?>
                                            
                                        </ul>
                                    </nav>
                                </div>
                                <!-- end menu -->

                                <!-- content -->
                                <div class="col-md-9 col-sm-7 col-xs-12 box-content-item">
                                    <div class="row">
                                        <div class="title-container">
                                            <h3 style="margin-bottom:30px;"><?=$value->getCate($_GET['id'])->name; ?></h3>
                                        </div>
                                        <?php 
                                        $cate = $value->getCateChild($_GET['id']); 
                                        $post = $value->getPost($_GET['id']); 
                                        if(!empty($post)){
                                        ?>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <h4>Các vấn đề chung</h4>
                                            <ul class="list-unstyled">
                                        <?php    
                                            foreach ($post as $value) {
                                        ?>
                                            <li><a href="<?=Yii::$app->urlManager->createAbsoluteUrl('cau-hoi-thuong-gap/' . (string)$value->_id)?>"><?=$value->name?></a></li>
                                        <?php } ?> 
                                            </ul>  
                                        </div>
                                        <?php } ?>


                                        <?php 
                                            if(!empty($cate)){
                                            foreach ($cate as $value) {
                                        ?>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <h4><?=$value->name?></h4>
                                                <ul class="list-unstyled">
                                                    <?php 
                                                    $post2 = $value->getPost($value->_id); 
                                                    if(!empty($post2)){
                                                    foreach ($post2 as $val) {
                                                    ?>
                                                    <li><a href="<?=Yii::$app->urlManager->createAbsoluteUrl('cau-hoi-thuong-gap/' . (string)$val->_id)?>"><?=$val->name?></a></li>
                                                    <?php        
                                                        }}   
                                                    ?>
                                                </ul>  
                                            </div>
                                        <?php        
                                            }}
                                        ?>

                                        <?php 
                                            if(empty($cate) && empty($post)){
                                                echo '<div class="alert alert-danger text-center">
                                                        <p><i class="fa fa-exclamation-circle"></i> Rất tiếc, hiện tại chưa có dữ liệu ở mục này .</p>
                                                        <p>Vui lòng gửi thắc mắc về hộp thư  <strong><a href="mailto:giaonhanviec@gmail.com">giaonhanviec@gmail.com</a></strong> để được hỗ trợ. </p>
                                                    </div>';
                                            }
                                        ?>
                                    </div>
                                </div>
                                <!-- end content -->
                            </div>
                        </div>
                </div>
            </div>
        </section>
        <!-- End page content -->



<?= $this->registerJs("
    $(document).ready(function () {
        $(function() {
                $('nav#menu').mmenu({
                    counters    : true,
                    navbar      : {
                        title       : ''
                    },
                });
            });
    });")?>

