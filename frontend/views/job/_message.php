<?php
if ($message->user_1 == $job->owner)
    $user = $message->user2;
else {
    $user = $message->user1;
}
?>
<a href="/user/<?= (string) $user->_id ?>"> <h4 class="title"><?= $user->name ?></h4></a>
<p class="time">Thứ ba, ngày 18 tháng 09 năm 2015</p>
<div class="comment scroll">
    <?php
    if (!empty($message)) {
        $conver = $message->conversation((string) $message->_id);
        if (!empty($conver)) {
            foreach ($conver as $val) {
                $profile = $val->profile;
                ?>
                <div class="media">
                    <div class="media-left">
                        <a href="#">
                            <img class="img-circle avatar" width="50" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty(Yii::$app->user->identity->avatar) ? '60-' . Yii::$app->user->identity->avatar : "avatar.png" ?>">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading"><?= $profile['name'] ?></h4>
                        <small><?= $val->content ?></small>
                    </div>
                </div>
                <?php
            }
        }
    }
    ?>


</div>