<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Thông tin thành viên</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= $this->title ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>     
                            <?= Html::a('Cập nhật', ['update', 'id' => (string) $model->_id], ['class' => 'btn btn-primary']) ?>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

                        <div class="profile_img">

                            <!-- end of image cropping -->
                            <div id="crop-avatar">
                                <!-- Current avatar -->
                                <div class="avatar-view" title="Change the avatar">
                                    <?php
                                    if (!empty($model->avatar)) {
                                        ?>
                                        <img src="<?= Yii::$app->params['url_file'] . 'thumbnails/150-' . $model->avatar ?>" alt="<?= $model->name ?>">
                                        <?php
                                    } else {
                                        ?>
                                        <img src="<?= Yii::$app->params['url_file'] . 'thumbnails/avatar.png' ?>" alt="<?= $model->name ?>">
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- end of image cropping -->

                        </div>
                        <h3><?= $model->name ?></h3>

                        <ul class="list-unstyled user_data">
                            <?php
                            if ($model->city) {
                                ?>
                                <li><i class="fa fa-map-marker user-profile-icon"></i> <?= $model->location->name . ', ' . $model->location->city->name ?></li>
                                <?php
                            }
                            ?>
                            <li><i class="fa fa-envelope-o user-profile-icon"></i> <?= $model->email ?></li>
                            <li><i class="fa fa-briefcase user-profile-icon"></i> <?= $model->findcategory->name ?></li>
                            <li class="m-top-xs"><i class="fa fa-external-link user-profile-icon"></i> <?= $model->findsector->name ?></li>
                        </ul>
                        <?= Html::a('Cập nhật', ['update', 'id' => (string) $model->_id], ['class' => 'btn btn-success']) ?>
                        <?php
                        if ($model->status == User::STATUS_NOACTIVE)
                            echo "<a class='btn btn-danger'>Chưa kích hoạt</a>";
                        else
                            echo Html::a($model->publish == User::PUBLISH_BLOCK ? 'Mở tài khoản' : 'Khóa tài khoản', ['block', 'id' => (string) $model->_id], ['class' => 'btn btn-danger'])
                            ?>
                        <br />
                        <?php
                        if ($model->step < 5)
                            echo Html::a('Duyệt hồ sơ', ['browse', 'id' => (string) $model->_id], ['class' => 'btn btn-primary'])
                            ?>
                        <!-- start skills -->
                        <h4>Bình chọn</h4>
                        <ul class="list-unstyled user_data">
                            <li>
                                <p>Web Applications</p>
                                <div class="progress progress_sm">
                                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                                </div>
                            </li>

                        </ul>
                        <!-- end of skills -->

                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">


                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab_book" role="tab" id="project-book" data-toggle="tab" aria-expanded="false">Dự án đã book (<?= count($book) ?>)</a></li>
                                <li role="presentation" class=""><a href="#tab_assign" id="project-assign" role="tab" data-toggle="tab" aria-expanded="true">Dự án đã xác nhận (<?= count($assign) ?>)</a></li>
                                <li role="presentation" class=""><a href="#tab_progress" id="project-progress" role="tab" data-toggle="tab" aria-expanded="true">Dự án đang làm (<?= count($progress) ?>)</a></li>
                                <li role="presentation" class=""><a href="#tab_completed" id="completed-tab" role="tab" data-toggle="tab" aria-expanded="true">Dự án đã hoàn thành (<?= count($completed) ?>)</a></li>
                                <li role="presentation" class=""><a href="#tab_users" id="users" role="tab" data-toggle="tab" aria-expanded="true">Khách hàng (<?= count($user) ?>)</a></li>
                                <li role="presentation" class=""><a href="#tab_messages" id="messages-tab" role="tab" data-toggle="tab" aria-expanded="true">Tin nhắn (<?= count($messages) ?>)</a>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab_book">
                                    <!-- start user projects -->
                                    <table class="data table table-striped no-margin">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tên dự án</th>
                                                <th>Ngân sách dự án</th>
                                                <th>Ngày kết thúc</th>
                                                <th>Lượt book</th>
                                                <th>Trạng thái</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($book)) {
                                                foreach ($book as $key => $value) {
                                                    $job = $value->job;
                                                    ?>
                                                    <tr>
                                                        <td><?= $key + 1 ?></td>
                                                        <td style="width:40%">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . $job->id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?= $job->project_type == 2 ? $job->budget->name : number_format($job->price, 0, '', '.') ?></td>
                                                        <td><?= date('d/m/Y', $job->deadline) ?></td>
                                                        <td class="text-center"><?= count($job->bid) ?></td>
                                                        <td>Chờ thanh toán</td>

                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr><td colspan="6">Không có dự án nào</td></tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <!-- end user projects -->

                                </div>
                                <div role="tabpanel" class="tab-pane fade " id="tab_assign">
                                    <!-- start user projects -->
                                    <table class="data table table-striped no-margin">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tên dự án</th>
                                                <th>Ngân sách dự án</th>
                                                <th>Ngày kết thúc</th>
                                                <th>Lượt book</th>
                                                <th>Trạng thái</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($assign)) {
                                                foreach ($assign as $key => $value) {
                                                    $job = $value->job;
                                                    ?>
                                                    <tr>
                                                        <td><?= $key + 1 ?></td>
                                                        <td style="width:40%">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . $job->id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?= $job->project_type == 2 ? $job->budget->name : number_format($job->price, 0, '', '.') ?></td>
                                                        <td><?= date('d/m/Y', $job->deadline) ?></td>
                                                        <td class="text-center"><?= count($job->bid) ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr><td colspan="5">Không có dự án nào</td></tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <!-- end user projects -->

                                </div>
                                <div role="tabpanel" class="tab-pane fade " id="tab_progress">
                                    <table class="table table-striped no-margin">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tên dự án</th>
                                                <th>Ngân sách dự án</th>
                                                <th>Ngày bắt đầu</th>
                                                <th>Ngày kết thúc</th>
                                                <th>Người thuê</th>
                                                <th>Tiến độ </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($progress)) {
                                                foreach ($progress as $key => $value) {
                                                    $job = $value->job;
                                                    ?>
                                                    <tr>
                                                        <td><?= $key + 1 ?></td>
                                                        <td style="width:40%">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . $job->id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?= number_format($value->price, 0, '', '.') . ' VNĐ' ?></td>
                                                        <td><?= date('d/m/Y', $job->assignment->startday) ?></td>
                                                        <td><?= date('d/m/Y', $job->assignment->startday + (86400 * $value->period)) ?></td>
                                                        <td><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $job->user->slug) ?>"><b><?= $job->user->name ?></b></a></td>
                                                        <td>
                                                            <div class="progress">
                                                                <?php
                                                                $progress = ((time() - $job->assignment->startday) / ($job->assignment->startday + (86400 * $value->period) - $job->assignment->startday)) * 100;
                                                                if ($progress >= 100)
                                                                    $rs = 100;
                                                                else
                                                                    $rs = $progress;
                                                                ?>
                                                                <div style="width: <?= $rs ?>%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?= $rs ?>" role="progressbar" class="progress-bar">
                                                                </div> 
                                                            </div>
                                                            <p class="text-gray"><?= number_format($rs, 0, '.', '') ?>%  hoàn thành</p>
                                                        </td>

                                                    </tr>

                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="7">
                                                        <p>Không có dự án nào trong hệ thống</p>
                                                    </td>
                                                </tr>
                                            <?php } ?>





                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane fade " id="tab_completed">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tên dự án</th>
                                                <th>Ngân sách dự án</th>
                                                <th>Ngày bắt đầu</th>
                                                <th>Ngày kết thúc</th>
                                                <th>Lượt book</th>
                                                <th>Nhân viên</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($completed)) {
                                                foreach ($completed as $value) {
                                                    $job = $value->job;
                                                    ?>
                                                    <tr>
                                                        <td><?= $key + 1 ?></td>
                                                        <td style="width:40%">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . $job->id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?= number_format($value->price, 0, '', '.') . ' VNĐ' ?></td>
                                                        <td><?= date('d/m/Y', $job->assignment->startday) ?></td>
                                                        <td><?= date('d/m/Y', $job->assignment->startday + (86400 * $value->period)) ?></td>
                                                        <td><?= count($job->bid) ?></td>
                                                        <td><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $job->user->slug) ?>"><b><?= $job->user->name ?></b></a></td>
                                                        <td class="text-success"><b>Hoàn tất</b></td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="6">
                                                        <p>Dữ liệu rỗng</p>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane fade " id="tab_users">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Khách hàng</th>
                                                <th>Ngày book</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($user)) {
                                                foreach ($user as $key => $value) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $key + 1 ?></td>
                                                        <td><?= $value->owner->name ?></td>
                                                        <td><?= date('d/m/Y', $value->created_at) ?></td>
                                                        <td>
                                                            <div class="col-md-4">
                                                                <select name="UserBid[status]" id="userbid-status" class="form-control" data-id="<?= $value->id ?>">
                                                                    <?php
                                                                    foreach ($value->dropstatus as $key => $status) {
                                                                        ?>
                                                                        <option <?= ($value->status == $key) ? "selected" : "" ?> value="<?= $key ?>"><?= $status ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="4">
                                                        <p>Dữ liệu rỗng</p>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane fade " id="tab_messages">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Người tạo</th>
                                                <th>Người tham gia</th>
                                                <th>Ngày tạo</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($messages)) {
                                                foreach ($messages as $key => $value) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $key + 1 ?></td>
                                                        <td><?= $value->userowner->name ?></td>
                                                        <td><?= $value->useractor->name ?></td>
                                                        <td><?= date('d/m/Y', $value->created_at) ?></td>
                                                        <td><?= $value->publish == 1 ? 'Hoạt động' : 'Ngừng hoạt động' ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="6">
                                                        <p>Dữ liệu rỗng</p>
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
</div>
<?= $this->registerJs('
$("#userbid-status").on("change",function(){    
var id = $(this).attr("data-id");
var status = $("#userbid-status option:selected").val();
    $.ajax({
    url:"' . Yii::$app->urlManager->createUrl(["ajax/userbookstatus"]) . '",
   type:"POST",            
   data:{id:id,status:status},
   success:function(data){     
       }
      });
    });

'); ?>