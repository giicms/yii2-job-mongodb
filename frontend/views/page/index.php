<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $model->name;
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
        <section class="about-box">
            <div class="container">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <h5 class="title-tab"><?=$model->name;?></h5>
                    <div class="post-content">
                        <?=$model->content;?>
                    </div>
                    
                </div>
                <div class="col-md-offset-1 col-md-3 col-sm-offset-1 col-sm-3 col-xs-12 help-sidebar">
                    <h4>Có thể bạn quan tâm</h4>
                    <ul>
                        <li><?= Html::a('hướng dẫn sữ dụng', ['help/manual']); ?></li>
                        <li><?= Html::a('câu hỏi thường gặp', ['help/question']); ?></li>
                        <li><?= Html::a('Quy chế báo mật', ['page/privacy']); ?></li>
                        <li><?= Html::a('điều khoản sữ dụng', ['page/termsofuse']); ?></li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- End page content -->




