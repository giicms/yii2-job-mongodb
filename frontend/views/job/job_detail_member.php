<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Assignment;

$this->title = $model->name;
$book = $model->getBid();
?>

<section>
    <div class="introduce job-detail">
        <div class="container">
            <div class="row">
                <?php
                if (!empty($assignment) && ($assignment->actor == (string) Yii::$app->user->identity->id) && $assignment->status_boss == Assignment::STATUS_GIVE)
                {
                    echo '<div class="alert alert-success">Bạn đã được giao việc , vui lòng chờ khách hàng đặt cọc để bắt đầu làm việc </div>';
                }
                if (!empty($assignment) && ($assignment->actor == (string) Yii::$app->user->identity->id) && $assignment->status_boss == Assignment::STATUS_COMMITMENT && $assignment->status_member < Assignment::STATUS_COMMITMENT)
                {
                    echo '<div class="alert alert-success">Khách hàng đã đặt cọc, Hãy bắt đầu làm việc </div>';
                }
                ?>
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <h2 class="job-title text-blue"><?= $this->title ?></h2>
                    <p><label class="button"><?= $model->category->name ?></label> Đăng cách đây <?= \Yii::$app->convert->time($model->created_at) ?></p>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p>Hạn chào giá: <br><b><?= date('d/m/Y', $model->deadline); ?></b></p>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p>Ngân sách dự kiến: <br><b><?= $model->budget ?></b></p>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p>Nhân viên book việc: <br><b><?= count($model->bid) ?>  </b></p>
                        </div>
                    </div>
                </div> 


                <!-- button book -->
                <div class="col-md-4 col-sm-12 col-xs-12 profile-member">
                    <div class="profile-content">
                        <ul class="list-group list-unstyled">
                            <li>
                                <!-- kiem tra neu cong viec da duoc giao -->
                                <?php
                                if (!empty($assignment))
                                {
                                    if ($assignment->status_boss == Assignment::STATUS_COMMITMENT)
                                    {
                                        echo '<a href="' . Yii::$app->urlManager->createAbsoluteUrl(['assignment/memberconfirm', 'id' => (string) $assignment->_id]) . '" class="btn btn-red btn-blue">Đồng ý làm việc</a>';
                                    }
                                    else
                                    {
                                        echo '<button class="btn btn-red btn-blue " style="cursor: default;">Đã được giao việc</button>';
                                    }
                                }
                                else
                                {
                                    ?> 
                                    <div class="option-<?= (string) $model->_id ?>">
                                        <?php
                                        $findBid = $model->getBidexits($model->_id);
                                        if (!empty($findBid))
                                        {
                                            $assign = $findBid->getOptions((string) $findBid->_id);
                                            if (empty($assign))
                                            {
                                                ?>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-square dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Chỉnh sửa<span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <?php
                                                        if (empty($assign))
                                                        {
                                                            ?>
                                                            <li><a href="javascript:void(0)" class="update" data-id="<?= (string) $findBid->_id ?>"><i class="fa fa-pencil"></i> Sửa</a></li>
                                                            <?php
                                                        }
                                                        ?>
                                                        <li><a href="#" data-id="<?= (string) $findBid->_id ?>" data-toggle="modal" data-target="#confirm-delete"  data-alert="Bạn có muốn hủy book công việc này không"><i class="fa fa-trash-o"></i> Hủy book</a></li>
                                                        <div class="clear-fix"></div>
                                                    </ul>
                                                </div>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            if (count($book) >= $model->num_bid)
                                            {
                                                ?>
                                                <a class="btn btn-danger">Book việc</a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <a class="btn btn-blue book" data-id="<?= (string) $model->_id ?>" data-title="<?= $model->name ?>">Book việc</a>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                <?php } ?>
                                <?php
                                $like = $model->getLikeexits();
                                if (!empty($like))
                                {
                                    ?>
                                    <a href="javascript:void(0)" class="btn btn-square btn-likejob  text-red like-<?= (string) $model->_id ?>" data-bind="<?= (string) $model->_id ?>" title="Lưu việc" ><i class="fa fa-heart-o"></i> <span>Đã lưu</span></a>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <a href="javascript:void(0)" class="btn btn-square btn-likejob color like like-<?= (string) $model->_id ?>" data-bind="<?= (string) $model->_id ?>" title="Lưu việc" ><i class="fa fa-heart-o"></i> <span>Lưu việc</span></a>
                                    <?php
                                }
                                ?>
                            </li>
                            <li><p>Lượt book việc cần có: <?= $model->num_bid ?></p></li>
                            <li><p>Lượt book việc còn lại của bạn: <?= $model->num_bid - count($model->getBid((string) $model->_id)) ?></p></li>
                        </ul>
                    </div>
                </div>
                <!-- End button book -->


                <div class="col-md-8 col-sm-12 col-xs-12">    
                    <div class="well no-radius">
                        <h4>Chi tiết công việc</h4>
                        <?php
                        foreach ($model->options as $option)
                        {
                            if (!empty($option['other']))
                                $other = ',' . $option['other'];
                            else
                                $other = '';
                            echo '<p><b>' . $option['name'] . ':</b> ' . trim($option['option'] . $other, ',') . '</p>';
                        }
                        ?>
                        <p><b>Yêu cầu khác:</b></p>
                        <p>
                            <?= nl2br($model->description) ?> 
                        </p>
                        <p>
                            <?php
                            if (!empty($model->file))
                            {
                                ?>
                                <i class="fa fa-paperclip fa-2x"></i> 
                                <a href="<?= $model->file[0] ?>"><strong>Mở file đính kèm</strong></a>
                                <?php
                            }
                            ?>
                        </p>

                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <h5><strong>Yêu cầu công việc</strong></h5>
                                <ul class="list-group list-unstyled">
                                    <li>
                                        Địa điểm làm việc: 
                                        <?php
                                        if ($model->work_location == 1)
                                        {
                                            echo 'Toàn quốc';
                                        }
                                        else
                                        {
                                            echo $model->address . ', ' . $model->local->name . ', ' . $model->local->city->name;
                                        }
                                        ?>
                                    </li>
                                    <li>Số Lượng nhận book việc: <?= $model->num_bid; ?></li>


                                </ul>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <h5><strong>Các nhân viên tham gia nhận việc</strong></h5>
                                <ul class="list-group list-unstyled">
                                    <?php
                                    foreach ($model->level as $level)
                                    {
                                        echo '<li>' . $model->getLevelname($level) . '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="well no-radius bid-member">
                        <h4 class="title-box text-blue"><strong>Nhân viên book việc (<?= count($model->getBid((string) $model->_id)) ?>)</strong></h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr><th>Nhân viên</th><th></th><th class="text-right" >Thành tựu</th><th class="text-right" >Thời gian book</th></tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($book))
                                    {
                                        foreach ($book as $value)
                                        {
                                            ?>
                                            <tr>
                                                <td style="width: 15%">
                                                    <div class="info">
                                                        <div class="profile">
                                                            <img class="avatar img-circle" width="100" src="<?= Yii::$app->params['url_file'] ?>thumbnails/<?= !empty($value->user->avatar) ? '150-' . $value->user->avatar : "avatar.png" ?>">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width: 25%">
                                                    <div class="info">
                                                        <p><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $value->user->slug) ?>"><b><?= $value->user->name; ?></b></a></p>
                                                        <p><b><?= !empty($value->user->findcategory->name) ? $value->user->findcategory->name : ""; ?></b></p>
                                                        <p><i class="fa fa-map-marker"></i> <b><?php
                                                                if (!empty($value->user->location->name))
                                                                {
                                                                    echo $value->user->location->name;
                                                                }
                                                                ?>, <?php
                                                                if (!empty($value->user->location->city->name))
                                                                {
                                                                    echo $value->user->location->city->name;
                                                                }
                                                                ?></b></p>
                                                    </div>
                                                </td>
                                                <td class="text-right" style="width: 35%">
                                                    <p><b><?= $value->user->findlevel->name; ?></b></p>
                                                    <p><b><?= $value->user->countjobdone ?></b> việc đã hoàn thành</p>
                                                    <p>
                                                        Đánh giá:  
                                                        <span class="star text-blue">
                                                            <?= $value->user->getStar($value->user->rating); ?>
                                                        </span> <?= $value->user->getCountReview($value->user->_id); ?><i class="fa fa-user"></i>
                                                    </p>

                                                </td>
                                                <td class="text-right" style="width: 25%">
                                                    <?php
                                                    $id_current = (string) Yii::$app->user->identity->id;
                                                    if ($id_current == $value->actor)
                                                    {
                                                        ?>
                                                        <h3 class="text-blue"><?= number_format($value->price, 0, '', '.') ?></h3>
                                                        <p class="text-gray"><?= Yii::$app->convert->time($value->created_at) ?></p>
                                                        <p>
                                                            <?php
                                                            if (!empty($assignment) && ($assignment->actor == $value->actor))
                                                            {
                                                                echo '<button style="width:100%;" type="button" class="btn btn-red btn-blue">Đã giao việc</button>';
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <a href="#" data-id="<?= (string) $value->_id ?>" class="btn btn-square square" data-toggle="modal" data-target="#confirm-delete"  data-alert="Bạn có muốn hủy book công việc này không">Hủy book </a>
                                                                <a href="javascript:void(0)" class="update btn btn-blue" data-id="<?= (string) $value->_id ?>"><i class="fa fa-pencil"></i> Sửa</a>
                                                            <?php } ?>
                                                        </p>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <p class="text-gray"><?= Yii::$app->convert->time($value->created_at) ?></p>
                                                        <?php
                                                    }
                                                    ?>
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
                    <div class="well no-radius">
                        <h4 class="title-box"><strong>Việc làm tương tự trên giaonhanviec.com</strong></h4>
                        <!-- member item -->
                        <?php
                        if (!empty($jobs))
                        {
                            foreach ($jobs as $key => $job)
                            {
                                //$bid_job = $job->getBidexits($job->_id);
                                $findBid = $model->getBidexits($job->_id);
                                $assignment = $job->getassignment();
                                ?>
                                <div class="job-item-info">
                                    <div class="row">
                                        <div class="col-md-8 col-sm-12 col-xl-12">
                                            <h5><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '-' . (string) $job->_id) ?>"><b><?= $job->name ?> </b></a></h5>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xl-12">
                                            <?php
                                            if (empty($assignment))
                                            {
                                                ?>
                                                <a class="btn btn-blue" href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '-' . (string) $job->_id) ?>">Đã chọn</a>
                                                <?php
                                            }
                                            else
                                            {
                                                if (!empty($findBid))
                                                {
                                                    ?>
                                                    <a href="#" data-id="<?= (string) $findBid->_id ?>" class="btn btn-square square" data-toggle="modal" data-target="#confirm-delete"  data-alert="Bạn có muốn hủy book công việc này không">Hủy book </a>
                                                    <a href="javascript:void(0)" class="update btn btn-blue" data-id="<?= (string) $findBid->_id ?>"><i class="fa fa-pencil"></i> Sửa</a>
                                                    <?php
                                                }
                                                else
                                                {
                                                    if (count($job->getBid()) == $job->num_bid)
                                                    {
                                                        ?>
                                                        <a class="btn btn-danger">BOOK VIỆC</a>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <a class="btn btn-blue book" data-id="<?= (string) $job->_id ?>">Book việc</a>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="sm-12 col-xs-12">

                                            <p><?= $job->category->name ?>/ <?= $job->sector->name ?></p>
                                            <p>
                                                <?php
                                                echo $job->budget;
                                                ?>
                                                - Hạn book: <b><?= date('d/m/Y', $job->deadline) ?></b> - Đăng cách đây <?= Yii::$app->convert->time($job->created_at) ?> </b></p>
                                            <p><?= Yii::$app->convert->excerpt($job->description, 250) ?> <a href="/cong-viec/<?= $job->slug ?>">Xem thêm </a></p>

                                        </div>
                                        <div class="col-md-8 col-sm-12 col-xl-12 owner-job">
                                            <p><b>Khách hàng: </b><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $job->user->slug) ?>"><span class="text-blue"><?= $job->user->name ?></span></a> - <?= $job->user->location->name ?> - <?= $job->user->location->city->name ?></p>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xl-12 quantity-book">
                                            <p><b>Lượt book: </b><b class="<?= count($job->getBid((string) $job->_id)) == $job->num_bid ? 'text-danger' : 'text-blue' ?>  num-book"><?= count($job->getBid((string) $job->_id)) ?>/<?= $job->num_bid ?></b></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <!-- End member item -->
                    </div>
                </div>


                <!-- profile boss -->
                <div class="col-md-4 col-sm-12 col-xs-12 profile-member">
                    <div class="profile-content">        
                        <h4 class="title-box"><strong>Giới thiệu về khách hàng này</strong></h4>
                        <div class="profile-item">
                            <div class="profile">
                                <img width="100" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($model->user->avatar) ? '150-' . $model->user->avatar : "avatar.png" ?>" class="img-circle avatar">
                            </div>
                            <div class="profile-content">
                                <ul class="list-unstyled">
                                    <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $model->user->slug) ?>"><b><?= $model->user->name ?></b></a></li>
                                    <li> 
                                        Đánh giá: 
                                        <span class="star text-blue">
                                            <?= $model->user->getStar($model->user->rating); ?>
                                        </span> 
                                        <?= $model->user->getCountReview($model->user->_id); ?><i class="fa fa-user"></i>
                                    </li>
                                    <li><i class="fa fa-map-marker"></i> <b><?= $model->user->location->name . ', ' . $model->user->location->city->name ?></b></li>
                                    <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('/tin-nhan/' . $model->user->slug) ?>" class="btn btn-blue contact">Liên hệ</a> </li>
                                </ul>
                            </div>
                        </div>
                        <ul class="list-group list-unstyled">
                            <p><b><?= $model->user->countbossjob ?> việc làm đã đăng </b></p>
                            <p><b><?= $model->user->countbossassign ?></b> việc đã giao </p>
                        </ul>
                        <h4 class="title-box"><strong>Xác thực</strong></h4>
                        <ul class="list-group list-unstyled">
                            <p><i class="fa fa-check-square text-blue"></i> <b>Số điện thoại:</b> đã xác thực</p>
                            <p><i class="fa fa-check-square text-blue"></i>  <b>Số tài khoản ngân hàng:</b>  đã xác thực</p>
                            <p><i class="fa fa-check-square text-blue"></i>  <b>Thông tin công ty:</b>  đã xác thực</p>

                        </ul>
                        <p>Tham gia ngày <?= date('d', $model->user->created_at) ?> tháng <?= date('m', $model->user->created_at) ?> năm <?= date('Y', $model->user->created_at) ?></p>
                    </div>  
                </div>
                <!-- End profile boss -->


            </div>
        </div>
    </div>
</section>
<!-- End introduce -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Hủy book</h4>
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

<?= $this->render('_bidjs') ?>
<?= $this->render('_likejs') ?>


<?= $this->registerJs("$('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.modal-body .alert').text($(e.relatedTarget).data('alert'));
        $(this).find('.modal-body input#confirm-id').val($(e.relatedTarget).data('id'));
    $(this).find('.btn-delete').attr('href', $(e.relatedTarget).data('href'));
});") ?>
<?=
$this->registerCss('
        .contact{
        width: auto !important;
        padding: 5px 10px !important;
    }
 ')?>