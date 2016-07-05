<?php 
    use yii\helpers\Html;
    $this->title='Quy chế báo mật';
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
                            <li class="r-tabs-tab r-tabs-state-default"><?= Html::a('câu hỏi thường gặp', ['help/question']); ?></li>
                            <li class="r-tabs-tab r-tabs-state-active"><?= Html::a('Quy chế báo mật', ['page/privacy']); ?></li>
                            <li class="r-tabs-tab r-tabs-state-default"><?= Html::a('điều khoản sữ dụng', ['page/termsofuse']); ?></li>
                        </ul>
                    </div>   

                        <div id="huong-dan-su-dung" class="tab-tem">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <?php    echo $privacy->content;?>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </section>
        <!-- End page content -->



