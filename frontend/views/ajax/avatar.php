<div class="form-group">
    <div class="col-md-3 col-sm-4 col-xs-12 control-label"><b>Bạn cần có tấm hình đại duyệt</b></div>
    <div class="col-md-6 col-sm-8 col-xs-12">
        <div class="profile-item no-border">
            <div class="profile">
                <img id="profile-avatar" src="<?= Yii::$app->params['url_file'] ?>thumbnails/<?= !empty(Yii::$app->user->identity->avatar) ? '150-' . Yii::$app->user->identity->avatar : "avatar.png" ?>" style="width:150px" class="fa avatar-16 img-circle">
            </div>
            <div class="profile-content">
                <ul>
                    <li><b>Ảnh đại diện của bạn</b></li>
                    <li>Hãy tạo cảm giác thân thiện và gần gũi với khách hàng <br> bằng ảnh đại diện của bạn.</li>
c

                </ul>

            </div>
        </div>
    </div>
</div>