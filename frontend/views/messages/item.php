<?php
if (!empty($conver)) {
    foreach ($conver as $value) {
        ?>
        <div class="media">
            <div class="media-left">
                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['membership/user/' . (string) $value->profile->_id]) ?>" title="<?= $value->profile->name ?>">
                    <img class="img-circle avatar" width="50" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($value->profile->avatar) ? '150-' . $value->profile->avatar : "avatar.png" ?>">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading"><?= $value->profile->name ?><small class="pull-right"><?= date('d/m/Y h:i', $value->created_at) ?></small></h4>
                <small><?= $value->content ?></small>
            </div>
        </div>

        <?php
    }
}
?>