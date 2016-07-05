<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Job;

$this->title = 'Danh sách công việc của bạn';
?>
<section>
    <div class="introduce introduce-finish">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-sm-10 col-xs-12">
                    <div class="title-container">
                        <h3><?= $this->title ?></h3>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/create']) ?>" class="btn btn-blue" title="Đăng việc">Đăng việc</a>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="list-project">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#sectionD">Công việc đang chờ (<?= count($jobnew) ?>)</a></li>
                            <li><a data-toggle="tab" href="#sectionA">Công việc đã giao (<?= count($pending) ?>)</a></li>
                            <li><a data-toggle="tab" href="#sectionB">Công việc đang làm (<?= count($making) ?>)</a></li>
                            <li><a data-toggle="tab" href="#sectionC">Công việc hoàn tất (<?= count($complete) ?>)</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="sectionD" class="tab-pane fade in active">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tên dự án</th>
                                                <th>Ngân sách dự án</th>
                                                <th>Hạn chào giá</th>
                                                <th>Lượt book</th>
                                                <th>Trạng thái</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($jobnew))
                                            {
                                                foreach ($jobnew as $job)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td style="width:40%">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '-' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?= $job->budget ?></td>
                                                        <td><?= date('d/m/Y', $job->deadline) ?></td>
                                                        <td class="text-center"><?= count($job->bid) ?></td>
                                                        <td><?= $job->getStatus($job->_id); ?></td>
                                                        <td class="text-right">
                                                            <!-- Single button -->
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Tùy chọn  <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/update', 'id' => (string) $job->_id]) ?>">Sửa việc  </a></li>

                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                                <tr>
                                                    <td colspan="6">
                                                        <p>Bạn chưa có công việc nào cần thuê trên hệ thống, Đăng việc để nhân viên của chúng tôi giúp bạn hoàn thành công việc</p>
                                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/create']) ?>" class="btn btn-blue" title="Đăng việc">Đăng việc</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="sectionA" class="tab-pane fade in">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tên dự án</th>
                                                <th>Ngân sách dự án</th>
                                                <th>Hạn chào giá</th>
                                                <th>Lượt book</th>
                                                <th>Trạng thái</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($pending))
                                            {
                                                foreach ($pending as $job)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td style="width:40%">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '-' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?= $job->budget ?></td>
                                                        <td><?= date('d/m/Y', $job->deadline) ?></td>
                                                        <td class="text-center"><?= count($job->bid) ?></td>
                                                        <td><?= $job->getStatus($job->_id); ?></td>
                                                        <td class="text-right">
                                                            <!-- Single button -->
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Tùy chọn  <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/update', 'id' => (string) $job->_id]) ?>">Sửa việc  </a></li>

                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                                <tr>
                                                    <td colspan="6">
                                                        <p>Bạn chưa có công việc nào cần thuê trên hệ thống, Đăng việc để nhân viên của chúng tôi giúp bạn hoàn thành công việc</p>
                                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/create']) ?>" class="btn btn-blue" title="Đăng việc">Đăng việc</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="sectionB" class="tab-pane fade">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tên dự án</th>
                                                <th>Ngân sách dự án</th>
                                                <th>Ngày bắt đầu</th>
                                                <th>Thời gian hoàn thành</th>
                                                <th>Nhân viên</th>
                                                <th>Trạng thái</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($making))
                                            {
                                                foreach ($making as $job)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '-' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?= $job->budget ?></td>
                                                        <td><?= date('d/m/Y', $job->assignment->startday) ?></td>
                                                        <td><?= $job->assignment->bid->period ?> ngày</td>
                                                        <td><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $job->assignment->user->slug) ?>"><b><?= $job->assignment->user->name ?></b></a></td>
                                                        <td><?= $job->getStatus($job->_id); ?></td>
                                                        <td class="text-right">
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="sectionC" class="tab-pane fade">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr><th>Tên dự án</th><th>Ngân sách dự án</th><th>Ngày bắt đầu</th><th>Ngày kết thúc</th><th>Lượt book</th><th>Nhân viên</th><th>Trạng thái</th></tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($complete))
                                            {
                                                foreach ($complete as $job)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '-' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a></td>
                                                        <td><?= $job->budget ?></td>
                                                        <td><?= date('d/m/Y', $job->assignment->startday) ?></td>
                                                        <td> ngày</td>
                                                        <td><?= count($job->bid) ?></td>
                                                        <td><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $job->assignment->user->slug) ?>"><b><?= $job->assignment->user->name ?></b></a></td>
                                                        <td class="text-success"><b><?= $job->getStatus($job->_id); ?></b></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- End introduce -->


<!-- close job -->
<?=
$this->registerJs('$(document).ready(function ()
{
    $(document).on("click", ".job-close", function () {
        var id = $(this).attr("data");
        var publish = $(this).attr("publish");
        if(publish == "on"){
            var comfirm = confirm("Bạn có chắc muốn đóng công việc này không");
        }else{
            var comfirm = confirm("Bạn có chắc muốn đăng công việc này không");
        }
        
        if(comfirm){ 
            $.ajax({
                type: "POST", 
                url:"' . Yii::$app->urlManager->createUrl(["job/jobclose"]) . '", 
                data: { id : id}, 
                success: function (data) {
                    if(data=="ok"){
                        window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
                    }
                },    
            });
        }
    });
});
');
