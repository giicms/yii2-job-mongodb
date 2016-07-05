<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

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
                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/index']) ?>" class="btn btn-blue" title="Tìm việc">Tìm việc</a>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="list-project">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#bid">Công việc đã book (<?= count($bid) ?>)</a></li>
                            <li><a data-toggle="tab" href="#pending">Công việc đã nhận (<?= count($assign) ?>)</a></li>
                            <li><a data-toggle="tab" href="#making">Công việc đang làm (<?= count($making) ?>)</a></li>
                            <li><a data-toggle="tab" href="#complete">Công việc hoàn tất (<?= count($complete) ?>)</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="bid" class="tab-pane fade in active">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tên dự án</th>
                                                <th>Ngân sách dự án</th>
                                                <th>Hạn chào giá</th>
                                                <th>Lượt book</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($bid)) {
                                                foreach ($bid as $value) {
                                                    $job = $value->job;
                                                    ?>
                                                    <tr>
                                                        <td style="width:40%">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '-' . (string) $job->_id) ?>"><b><?= $job->name ?><?= $job->getStatus($job->_id); ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?= $job->budget ?></td>
                                                        <td><?= date('d/m/Y', $job->deadline) ?></td>
                                                        <td class="text-center"><?= count($job->bid) ?></td>
                                                        <td><?=$job->getStatus($job->_id);?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="6">
                                                        <p>Bạn chưa có công việc làm nào trong hệ thống</p>
                                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/index']) ?>" class="btn btn-blue" title="Tìm việc">Tìm việc</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="pending" class="tab-pane fade in">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tên dự án</th>
                                                <th>Ngân sách dự án</th>
                                                <th>Hạn chào giá</th>
                                                <th>Lượt book</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($assign)) {
                                                foreach ($assign as $value) {
                                                    $job = $value->job;
                                                    ?>
                                                    <tr>
                                                        <td style="width:40%">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '-' . (string) $job->_id) ?>"><b><?= $job->name ?><?= $job->getStatus($job->_id); ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?= $job->budget ?></td>
                                                        <td><?= date('d/m/Y', $job->deadline) ?></td>
                                                        <td class="text-center"><?= count($job->bid) ?></td>
                                                        <td><?= $job->getStatus($job->_id); ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="6">
                                                        <p>Bạn chưa có công việc làm nào xác nhận</p>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="making" class="tab-pane fade">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tên dự án</th>
                                                <th>Ngân sách dự án</th>
                                                <th>Ngày bắt đầu</th>
                                                <th>Thời gian hoàn thành</th>
                                                <th>Người thuê</th>
                                                <th>Trạng thái</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($making)) {
                                                foreach ($making as $value) {
                                                    $job = $value->job;
                                                    ?>
                                                    <tr>
                                                        <td style="width:40%">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '-' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?= number_format($job->assignment->bid->price, 0, '', '.') . ' VNĐ' ?></td>
                                                        <td><?= date('d/m/Y', $job->assignment->startday) ?></td>
                                                        <td><?= $job->assignment->bid->period?></td>
                                                        <td><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $job->user->slug) ?>"><b><?= $job->user->name ?></b></a></td>
                                                        <td><?= $job->getStatus($job->_id); ?></td>
                                                        <td class="text-right">
                                                            <!-- Single button -->
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Tùy chọn  <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a href="#">Báo cáo quản trị viên </a></li>
                                                                    <div class="clear-fix"></div>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="6">
                                                        <p>Bạn chưa có công việc làm nào trong hệ thống</p>
                                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/index']) ?>" class="btn btn-blue" title="Tìm việc">Tìm việc</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="complete" class="tab-pane fade">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr><th>Tên dự án</th><th>Ngân sách dự án</th><th>Ngày bắt đầu</th><th>Ngày kết thúc</th><th>Khách hàng</th><th>Trạng thái</th></tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($complete)) {
                                                foreach ($complete as $value) {
                                                    $job = $value->job;
                                                    ?>
                                                    <tr>
                                                        <td style="width:40%">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?= number_format($job->assignment->bid->price, 0, '', '.') . ' VNĐ' ?></td>
                                                        <td><?= date('d/m/Y', $job->assignment->startday) ?></td>
                                                        <td><?= $job->assignment->bid->period?></td>
                                                        <td><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $job->user->slug) ?>"><b><?= $job->user->name ?></b></a></td>
                                                        <td class="text-right">
                                                            <?=$job->getStatus($job->_id);?>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="6">
                                                        <p>Bạn chưa có công việc làm nào trong hệ thống</p>
                                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/index']) ?>" class="btn btn-blue" title="Tìm việc">Tìm việc</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>

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
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>
            <form id="frmComfirm">
                <div class="modal-body">
                    <p class="alert"></p>
                    <input type="hidden" id="confirm-id" name="confirm">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-delete">Delete</a>
                </div>
        </div>
    </div>
</div>
<!-- End introduce -->
<?= $this->registerJs("$('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.modal-body .alert').text($(e.relatedTarget).data('alert'));
        $(this).find('.modal-body input#confirm-id').val($(e.relatedTarget).data('id'));
    $(this).find('.btn-delete').attr('href', $(e.relatedTarget).data('href'));
});") ?>
<?= $this->registerJs("$(document).on('click', '.btn-delete', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/removebid"]) . "',
            type: 'post',
             data: $('form#frmComfirm').serialize(),
            success: function(data) {
                if(data.message=='ok'){
           window.location.href = '" . $_SERVER['REQUEST_URI'] . "';        
                }
            }
        });

});") ?>