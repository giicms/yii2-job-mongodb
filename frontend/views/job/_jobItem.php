<?php
use common\models\Job;
?>
<!-- member item -->
<div class="job-item-info job-<?= (string) $value->_id ?> <?php if($value->featured == Job::FEATURED_OPEN){echo 'featured-job';}?>">
    <div class="row">
	<?php if($value->featured == Job::FEATURED_OPEN){echo '<div class="jobhot"></div>';}?>
    <div class="jobitem-info">
        <div class="col-md-8 col-sm-12 col-xl-12">
            <h5>
                <a class="name" href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $value->slug . '-' . $value->_id) ?>"><b><?= $value->name ?></b></a>
            </h5>
        </div>
        <div class="col-md-4 col-sm-12 col-xl-12 btn-bar">

            <?php
            if (!\Yii::$app->user->isGuest)
            {
                if (!\Yii::$app->info->isboss())
                {
                    ?> 
                    <?php
                    $like = $value->getLikeexits();
                    if (!empty($like))
                    {
                        ?>
                        <a href="javascript:void(0)" class="btn btn-likejob text-red like like-<?= (string) $value->_id ?>" data-bind="<?= (string) $value->_id ?>" title="Lưu việc" ><i class="fa fa-heart-o"></i> <span>Đã lưu</span></a>
                        <?php
                    }
                    else
                    {
                        ?>
                        <a href="javascript:void(0)" class="btn btn-likejob text like like-<?= (string) $value->_id ?>" data-bind="<?= (string) $value->_id ?>" title="Lưu việc" ><i class="fa fa-heart-o"></i> <span>Lưu việc</span></a>
                        <?php
                    }
                    ?>

                    <?php
                    $findBid = $value->getBidexits($value->_id);
                    if (!empty($findBid))
                    {
                        ?>
                        <a class="btn btn-green book">Đã Book</a>
                        <?php
                    }
                    else
                    {
                        ?>
                        <a class="btn btn-blue book" data-id="<?= (string) $value->_id ?>" data-title="<?= $value->name ?>">Book việc</a>
                    <?php } ?>

                    <?php
                }
            }
            else
            {
                ?>
                <a href="javascript:void(0)" class="btn btn-blue book">Book việc</a>
                <?php
            }
            ?>
            <div class="clear-fix"></div>
        </div>
        <div class="sm-12 col-xs-12">
            <p><?= $value->category->name ?>/<?= $value->sector->name ?></p>
            <p><i class="fa fa-money text-orange" aria-hidden="true"></i> <?= $value->budget ?>  -  <i class="fa fa-calendar text-danger" aria-hidden="true"></i> Ngày đăng: <b><?= date('d/m/Y', $value->created_at) ?></b> - <i class="fa fa-clock-o text-green" aria-hidden="true"></i> Còn lại <b><?= Yii::$app->convert->countdown($value->deadline) ?></b></p>
            <p>
                <?= nl2br(Yii::$app->convert->excerpt($value->description, 250)) ?>
                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $value->slug . '-' . (string) $value->_id) ?>"><b> Xem thêm </b></a>
            </p>

            <div class="clear-fix"></div>
        </div>
        <div class="col-md-8 col-sm-12 col-xl-12 owner-job">
            <p><b>Khách hàng: </b><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $value->user->slug) ?>"><span class="text-blue"><?= $value->user->name ?></span></a> - <i class="fa fa-map-marker text-gray" aria-hidden="true"></i> <?= $value->user->location->name ?>, <?= $value->user->location->city->name ?> </p>
            <div class="clear-fix"></div>
        </div>
        <div class="col-md-4 col-sm-12 col-xl-12 quantity-book">
            <p><b>Lượt book: </b><b class="text-blue num-book"><?= count($value->getBid((string) $value->_id)) ?>/<?= $value->num_bid ?></b></p>
        </div>
    </div>
	</div>
</div>
<!-- End member item -->
