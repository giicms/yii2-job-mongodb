<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;
use common\models\Job;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý boss', 'url' => ['index']];
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
                            <?php
                            if ($model->step < 5)
                                echo Html::a('Duyệt hồ sơ', ['browse', 'id' => (string) $model->_id], ['class' => 'btn btn-primary'])
                                ?>
                        </li>
                        <li>     
                            <?= Html::a('Cập nhật', ['update', 'id' => (string) $model->_id], ['class' => 'btn btn-success']) ?>
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
                            <li><i class="fa fa-phone user-profile-icon"></i> <?= $model->phone ?></li>
                        </ul>


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
                                <li role="presentation" class="active"><a href="#tab_project" role="tab" id="project-book" data-toggle="tab" aria-expanded="false">Dự án đã đăng (<?= count($project) ?>)</a></li>
                                <li role="presentation" class=""><a href="#tab_assign" id="project-pending" role="tab" data-toggle="tab" aria-expanded="true">Dự án đang chờ (<?= count($pending) ?>)</a></li>
                                <li role="presentation" class=""><a href="#tab_progress" id="project-progress" role="tab" data-toggle="tab" aria-expanded="true">Dự án đang làm (<?= count($progress) ?>)</a></li>
                                <li role="presentation" class=""><a href="#tab_completed" id="project-completed" role="tab" data-toggle="tab" aria-expanded="true">Dự án đã hoàn thành (<?= count($completed) ?>)</a></li>
                                <li role="presentation" class=""><a href="#tab_users" id="users" role="tab" data-toggle="tab" aria-expanded="true">Nhân viên (<?= count($user) ?>)</a></li>
                                <li role="presentation" class=""><a href="#tab_messages" id="messages-tab" role="tab" data-toggle="tab" aria-expanded="true">Tin nhắn (<?= count($messages) ?>)</a></li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab_project">
                                    <!-- start user projects -->
                                    <table class="data table table-striped no-margin">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tên dự án</th>
                                                <th>Ngân sách dự án</th>
                                                <th>Ngày đăng</th>
                                                <th>Ngày kết thúc</th>
                                                <th>Lượt book</th>
                                                <th>Trạng thái</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($project)) {
                                                foreach ($project as $key => $job) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $key + 1 ?></td>
                                                        <td>
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . $job->id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?= $job->project_type == 2 ? 'Từ ' . number_format($job->budget->min, 0, '', '.') . ' đến ' . number_format($job->budget->max, 0, '', '.') : number_format($job->price, 0, '', '.') . ' VNĐ' ?></td>
                                                        <td><?= date('d/m/Y', $job->created_at) ?></td>
                                                        <td><?= date('d/m/Y', $job->deadline) ?></td>
                                                        <td class="text-center"><?= count($job->bid) ?></td>
                                                        <td>
                                                            <?php
                                                            switch ($job->publish) {
                                                                case Job::PUBLISH_NOACTIVE:
                                                                    $status = 'Mới đăng';
                                                                    break;
                                                                case Job::PUBLISH_VIEW:
                                                                    $status = 'Lưu tạm';
                                                                    break;
                                                                case Job::PUBLISH_ACTIVE:
                                                                    $status = 'Đã duyệt';
                                                                    break;
                                                                case Job::PUBLISH_CLOSE:
                                                                    $status = 'Đã đóng bởi boss';
                                                                    break;
                                                            }
                                                            echo $status;
                                                            ?>
                                                        </td>

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
                                                <th>Ngày đăng</th>
                                                <th>Ngày kết thúc</th>
                                                <th>Lượt book</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($pending)) {
                                                foreach ($pending as $key => $job) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $key + 1 ?></td>
                                                        <td style="width:40%">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . $job->id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?= $job->project_type == 2 ? 'Từ ' . number_format($job->budget->min, 0, '', '.') . ' đến ' . number_format($job->budget->max, 0, '', '.') : number_format($job->price, 0, '', '.') . ' VNĐ' ?></td>
                                                        <td><?= date('d/m/Y', $job->created_at) ?></td>
                                                        <td><?= date('d/m/Y', $job->deadline) ?></td>
                                                        <td><?= $job->num_bid ?></td>
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
                                                <th>Ngày đăng</th>
                                                <th>Ngày kết thúc</th>
                                                <th>Lượt book</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($progress)) {
                                                foreach ($progress as $key => $job) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $key + 1 ?></td>
                                                        <td style="width:40%">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . $job->id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?= $job->project_type == 2 ? 'Từ ' . number_format($job->budget->min, 0, '', '.') . ' đến ' . number_format($job->budget->max, 0, '', '.') : number_format($job->price, 0, '', '.') . ' VNĐ' ?></td>
                                                        <td><?= date('d/m/Y', $job->created_at) ?></td>
                                                        <td><?= date('d/m/Y', $job->deadline) ?></td>
                                                        <td><?= $job->num_bid ?></td>
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
                                                <th>Ngày đăng</th>
                                                <th>Ngày kết thúc</th>
                                                <th>Lượt book</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($completed)) {
                                                foreach ($completed as $job) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $key + 1 ?></td>
                                                        <td style="width:40%">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . $job->id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?= $job->project_type == 2 ? 'Từ ' . number_format($job->budget->min, 0, '', '.') . ' đến ' . number_format($job->budget->max, 0, '', '.') : number_format($job->price, 0, '', '.') . ' VNĐ' ?></td>
                                                        <td><?= date('d/m/Y', $job->created_at) ?></td>
                                                        <td><?= date('d/m/Y', $job->deadline) ?></td>
                                                        <td><?= $job->num_bid ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="6">
                                                        <p>Bạn chưa có dự án hoàn thành nào trong hệ thống</p>
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
                                                <th>Nhân viên</th>
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
                                                        <td><?= $value->actor->name ?></td>
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
                                                        <p>Bạn chưa có cuộc trò chuyện nào</p>
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


<?= $this->registerJs('$("[name=status]").bootstrapSwitch({onText:"&nbsp;",offText:"&nbsp;",onColor:"default",offColor:"default"});') ?>
<?= $this->registerJs('
$("input[name=status]").on("switchChange.bootstrapSwitch", function(event, state) {
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["boss/block"]) . '", data: {id: "' . $model->id . '",state:state}, success: function (data) {
   
            }, });
});
') ?>
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