<?php
$this->title = 'Danh sách công việc đã lưu';
?>
<section>
    <div class="introduce">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="title-container">
                        <h3>Các công việc đã lưu  </h3>
                    </div>
                    <?php
                    foreach ($model as $value)
                    {
                        $job = $value->job;
                        ?>
                        <!-- profile-item -->
                        <div class="job-item-info">
                            <div class="row">
                                <div class="col-md-8 col-sm-12 col-xl-12">
                                    <h5>
                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '-' . $job->id) ?>"><b><?= $job->name ?></b></a>
                                    </h5>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xl-12 btn-bar">
                                    <?php
                                    $findBid = $job->getBidexits((string) $job->_id);
                                    if (!empty($findBid))
                                    {
                                        ?>
                                        <div class="btn-group btn">
                                            <button type="button" class="btn btn-square dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Chỉnh sửa<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="javascript:void(0)" class="update" data-id="<?= (string) $findBid->_id ?>"><i class="fa fa-pencil"></i> Sửa</a></li>
                                                <li><a href="javascript:void(0)" class="block" data-id="<?= (string) $findBid->_id ?>"><i class="fa fa-trash-o"></i> Hủy book</a></li>
                                                <div class="clear-fix"></div>
                                            </ul>
                                        </div>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <a class="btn btn-blue book" data-id="<?= (string) $job->_id ?>" data-title="<?= $job->name ?>">Book việc</a>
                                    <?php } ?>
                                    <div class="clear-fix"></div>
                                </div>
                                <div class="sm-12 col-xs-12">
                                    <p><?= $job->category->name ?>/ <?= $job->sector->name ?></p>
                                    <p><?= $job->budget ?></b> - Hạn book: <b><?= date('d-m-Y', $job->deadline) ?></b> - Ngày đăng: <b><?= date('d-m-Y', $job->created_at) ?></b> </p>
                                    <p><?= Yii::$app->convert->excerpt(nl2br($job->description), 500) ?><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '-' . (string) $job->_id) ?>">Xem thêm </a></p>

                                    <div class="clear-fix"></div>
                                </div>
                                <div class="col-md-8 col-sm-12 col-xl-12 owner-job">
                                    <p><b>Khách hàng: </b><span class="text-blue"><?= $job->user->name; ?></span> - <?= $job->user->location->name ?>, <?= $job->user->location->city->name ?> </p>
                                    <div class="clear-fix"></div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xl-12 quantity-book">
                                    <p><b>Lượt book: </b><b class="text-blue num-book"><?= count($job->bid) ?>/<?= $job['num_bid'] ?></b></p>
                                </div>
                            </div>
                        </div>
                        <!-- End profile-item -->
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End introduce-->


