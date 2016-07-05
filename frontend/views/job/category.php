<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng việc';
$this->params['breadcrumbs'][] = $this->title;
?>

<section>
    <div class="introduce dang-viec">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="title-container">
                        <h3>Lựa chọn danh mục công việc mà bạn muốn đăng</h3>
                    </div>
                    <!-- introduce item -->

                    <?php
                    foreach ($category as $value)
                    {
                        ?>
                        <div class="category-item">
                            <h4><strong><?= $value->name ?></strong></h4>
                            <ul class="nav row">
                                <?php
                                $sector = $value->sectors;
                                if (!empty($sector))
                                {
                                    foreach ($sector as $value)
                                    {
                                        ?>
                                        <li class="col-md-6 col-sm-6 col-xs-12"><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('dang-viec/' . $value->slug . '-' . $value->_id) ?>"><?= $value->name ?></a></li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="list-group">
                        <a href="#" class="list-group-item active">
                            <div class="media">
                                <div class="media-left">
                                    <i class="fa fa-question-circle fa-5x" aria-hidden="true"></i>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"> Tại sao phải đăng việc và làm việc với nhân viên trên giaonhanviec.com?</h4>
                                </div>
                            </div>
                        </a>
                        <a class="list-group-item active">
                            <i class="fa fa-check"></i>  Có đủ nhân viên chất lượng và đã xác thực.
                        </a>
                        <a href="#" class="list-group-item active">
                            <i class="fa fa-check"></i> Báo giá không đạt yêu cầu sẽ bị loại trừ trước khi gởi đến bạn.
                        </a>
                        <a href="#" class="list-group-item active">
                            <i class="fa fa-check"></i> Được cung cấp đầy đủ thông tin liên hệ của nhân viên.
                        </a>
                        <a href="#" class="list-group-item active">
                            <i class="fa fa-check"></i> Đảm bảo an toàn khi giao dịch tiền bạc với nhân viên
                        </a>
                        <a href="#" class="list-group-item active">
                            <i class="fa fa-check"></i> Hoàn tiền miễn phí từ đăng tin đến tuyển dụng và thanh toán
                        </a>
                        <a href="#" class="list-group-item active">
                            <i class="fa fa-check"></i> Hoàn tiền 100% giao dịch với nhân viên không hoàn thành.
                        </a>
                        <a href="#" class="list-group-item active">
                            <i class="fa fa-check"></i> Được hỗ trợ nhanh chóng 24/7.
                        </a>
                    </div>
                    <div class="list-group list-job-step text-center">
                        <a href="#" class="list-group-item" style="background-color: #f7f7f9; border-top:1px solid #ddd">
                            <h4 class="list-group-item-heading">Hoàn thành công việc chỉ với 4 bước</h4>
                        </a>
                        <a href="#" class="list-group-item ">
                            <i class="fa fa-file-text fa-5x text-primary"></i>
                            <h4 class="list-group-item-heading"><strong>01. ĐĂNG VIỆC</strong></h4>
                            <p class="list-group-item-text">Không mất thời gian suy nghĩ, chúng tôi có sẵn mẫu đăng việc. Chỉ mất 2 phút để hoàn thành.</p>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-users fa-5x text-primary"></i>
                            <h4 class="list-group-item-heading"><strong>02. CHỌN NHÂN VIÊN</strong></h4>
                            <p class="list-group-item-text">Những nhân viên này "Đủ năng lực chuyên môn" và đã được "xác thực có kinh nghiệm" làm qua loại dịch vụ bạn cần.</p>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-cogs fa-5x text-primary"></i>
                            <h4 class="list-group-item-heading"><strong>03. LÀM VIỆC</strong></h4>
                            <p class="list-group-item-text">Sau khi xác nhận yêu cầu, nhân viên sẽ giải quyết công việc của bạn.</p>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-money fa-5x text-primary"></i>
                            <h4 class="list-group-item-heading"><strong>04. NGHIỆM THU & THANH TOÁN</strong></h4>
                            <p class="list-group-item-text">Chúng tôi co sẵn hệ thống nhận đặt cọc và thanh toán phí cho nhân viên</p>
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<?= $this->registerCss('
        .category-item{
        margin-bottom:30px;
    }
     .category-item h4 strong{
     color:#2FB4E0;
}
         .category-item ul li a{
        font-weight:normal;
        padding-left: 0;
        color:#363636;
    }
     .category-item ul li a:hover{
        background-color:#fff;
        color: #2FB4E0;
    }
    .list-group a h5{
line-height:20px;   
}
.list-group-item a i{
margin-right:10px;
}
.list-job-step a{
border-top:0
}
.list-job-step a i{
margin:15px 0;
}
        ') ?>
