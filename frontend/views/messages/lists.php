
<?php
if (!empty($conversation)) {
    foreach ($conversation as $value) {
        $profile = $value->profile;
        ?>
        <div class="media">
            <div class="media-left">
                <a href="/user/<?= (string) $profile->_id ?>">
                    <img class="img-circle avatar" width="50" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($profile['avatar']) ? '60-' . $profile['avatar'] : "avatar.png" ?>">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading"><?= $profile['name'] ?> <small class="pull-right"><?= date('d/m/Y h:i', $value->created_at) ?></small></h4>
                <small><?= $value->content ?></small>
            </div>
        </div>
        <?php
    }
}
?>
