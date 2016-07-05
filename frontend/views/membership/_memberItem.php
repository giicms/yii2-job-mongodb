<!-- member item -->
<div class="profile-item user-<?= (string) $value->_id ?>">
    <input type="hidden" id="user_id" value="<?= (string) $value->_id ?>">
    <div class="row">
        <div class="col-lg-8">
            <div class="profile">
                <img class="avatar img-circle" width="100" src="<?= Yii::$app->params['url_file'] ?>thumbnails/<?= !empty($value->avatar) ? '150-' . $value->avatar : "avatar.png" ?>">
                <div class="num-review">
                    <h5>Đánh giá: </h5> <span><?= $value->getPoint($value->_id) ?></span>
                </div>
            </div>
            <div class="profile-content">
                <ul class="list-unstyled text-left">
                    <li>
                        <h5>
                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $value->slug) ?>" class="name"><b><?php echo $value->name ?></b></a>
                            <small> - Hoạt động cách đây <?= Yii::$app->convert->time($value->lastvisit) ?></small>
                        </h5>
                    </li>
                    <li><b><?= !empty($value->findcategory->name) ? $value->findcategory->name : "" ?></b></li>
                    <li>Cấp độ: <b><?= !empty($value->findlevel->name) ? $value->findlevel->name : "" ?></b></li>
                    <li>
                        <i class="fa fa-map-marker"></i> 
                        <b><?= $value->location->name ?>, <?= $value->location->city->name ?></b> - <small>Test năng lực: <?= $value->getTestpoint($value->id) ?></small>
                    </li>
                    <li class="skill-pro">
                        <ul class="list-unstyled">
                            <?php
                            if (!empty($value->skills)) {
                                foreach ($value->skills as $k => $skill) {
                                    if ($k > 5)
                                        $dis = 'none';
                                    else
                                        $dis = 'block';
                                    $getskill = $value->getSkills($skill);
                                    echo '<li class="pull-left" style="display:' . $dis . '"><span class="label label-default">' . $getskill['name'] . '</span></li> ';
                                }
                                echo '<li class="pull-left"><a href="#"><strong>Xem thêm</strong></a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
        <div class="col-lg-4">
            <div class="profile-content">
                <ul class="list-unstyled">
                    <?php
                    if (!\Yii::$app->user->isGuest) {
                        if (\Yii::$app->info->isboss()) {
                            ?>
                            <li class="options option-<?= (string) $value->id ?>">
                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('/tin-nhan/' . $value->slug) ?>" class="btn btn-blue btn-comments"><i class="fa fa-comments-o"></i></a> 
                                <a class="btn btn-square userbid" data-id="<?= (string) $value->_id ?>">Book nhân viên</a>
                                <p><a class="btn btn-info invited" style="margin-top:5px; text-transform: uppercase" data-id="<?= (string) $value->_id ?>">Mời nhận việc</a></p>
                            </li>
                            <?php
                        }
                    }
                    ?>
                    <li><b><?= $value->getCountReview($value->_id) ?></b> đánh giá</li>
                    <li><b><?=$value->countjobdone?></b> công việc đã hoàn thành</li>
                    <?php if (!\Yii::$app->user->isGuest) { ?>
                        <li>Lưu lại : <a href="javascript:void(0)" data-id="<?= (string) $value->_id ?>" class="saved"><i class="fa <?= !$value->saveexits((string) $value->_id) ? 'fa-heart-o' : 'fa-heart' ?>"></i></a></li>
                            <?php } ?>
                </ul>
            </div>

        </div>
    </div>
</div>