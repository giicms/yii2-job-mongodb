
<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Danh sách lưu nhân viên';
?>
<section>
    <div class="introduce">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="title-container">
                        <h3>Lưu nhân viên </h3>
                    </div>

                    <!-- profile-item -->
                    <?php
                    if (!empty($model)) {
                        foreach ($model as $key => $value) {
                            ?>
                            <div class="profile-item user-<?= (string) $value->findactor->_id ?>">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="profile">
                                            <img width="100" src="<?= Yii::$app->params['url_file'] ?>thumbnails/<?= !empty($value->findactor->avatar) ? '150-' . $value->findactor->avatar : "avatar.png" ?>" class="avatar img-circle">
                                            <div class="num-review">
                                                <h5>Đánh giá: </h5> <span>5.0</span>
                                            </div>
                                        </div>
                                        <div class="profile-content">
                                            <ul class="list-unstyled text-left">

                                                <li>
                                                    <h5>
                                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['membership/user', 'id' => (string) $value->findactor->_id]) ?>"  class="name"><b><?= $value->findactor->name ?></b></a>
                                                        <small> - Hoạt động cách đây <?= Yii::$app->convert->time($value->findactor->created_at) ?></small>
                                                    </h5>
                                                </li>
                                                <li><b><?= !empty($value->findactor->findcategory->name) ? $value->findactor->findcategory->name : "" ?></b></li>
                                                <li>Cấp độ: <b><?= !empty($value->findactor->findlevel->name) ? $value->findactor->findlevel->name : "" ?></b></li>
                                                <li>
                                                    <i class="fa fa-map-marker"></i> 
                                                    <b>Đà Nẵng, Việt Nam</b> - <small>Test năng lực: <?= $value->getPoint($value->id) ?></small>
                                                </li>
                                                <li class="skill-pro">
                                                    <ul class="list-unstyled">
                                                        <?php
                                                        if (!empty($value->findactor->skills)) {
                                                            foreach ($value->findactor->skills as $key => $skill) {
                                                                ?>
                                                                <li class="pull-left" style="display: <?= $key > 5 ? 'block' : 'none' ?>"><span class="label label-default"><?= $value->findactor->getskills($skill)->name ?></span></li>
                                                                <?php
                                                            }
                                                            ?>
                                                            <li class="pull-left">     <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['user/' . $value->findactor->slug]) ?>"><strong>Xem thêm</strong></a></li>
                                                            <?php
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
                                                <li>
                                                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['messages/index']) ?>" class="btn btn-blue">Liên hệ</a> 
                                                    <a class="btn btn-square invited" data-id="<?= (string) $value->findactor->_id ?>">Mời nhận việc</a>
                                                </li>
                                                <li><b>31</b> đánh giá</li>
                                                <li><b>56</b> việc làm đã nhận</li>
                                                <li><b>100%</b> công việc đã hoàn thành</li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <!-- End profile-item -->

                </div>
                <div class="col-lg-12 nav-pagination">
                    <nav>
                        <?php
                        echo LinkPager::widget(['pagination' => $pages,
                            'options' => ['class' => 'pagination pull-right'],
                            'firstPageLabel' => 'Trang đầu',
                            'lastPageLabel' => 'Trang cuối',
                            'prevPageLabel' => 'Trang trước',
                            'nextPageLabel' => 'Trang sau',
                        ]);
                        ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End introduce -->
<div class="modal fade" id="invited" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Mời nhận việc</h4>
            </div>
            <div class="modal-body">
                <?php
                if (!empty($job)) {
                    ?>
                    <?php $form = ActiveForm::begin(['id' => 'formInvited', 'options' => ['class' => 'form-horizontal']]); ?>  
                    <div class="form-group">
                        <label class="col-sm-3">Nhân viên</label>
                        <div class="col-sm-9">
                            <strong class="actor-name"></strong>
                            <input type="hidden" id="jobinvited-actor" name="JobInvited[actor]" value="">
                        </div>
                    </div>


                    <?= $form->field($invited, 'message', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label" style="text-align:left">{label}</label><div  class="col-md-9 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textarea() ?>
                    <div class="form-group">
                        <label class="col-sm-3">Chọn công việc</label>
                        <div class="col-sm-4">Từ công việc đã đăng</div>
                        <div class="col-sm-5">
                            <div class="select">
                                <select name="JobInvited[job_id]" id="jobinvited-job_id" style="width:100%" class="form-control">
                                    <?php
                                    foreach ($job as $value) {
                                        ?>
                                        <option selected value="<?= (string) $value['_id'] ?>"><?= $value->name ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-8">
                            <button id="submitInvited" type="submit" class="btn btn-default btn-boss">Mời nhận việc</button>
                            <a href="#"  data-dismiss="modal" class="alert"><strong>Hủy</strong></a>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                    <?php
                } else {
                    echo 'Bạn chưa có công việc nào trong hệ thống!';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?= $this->registerJs("$(document).on('click', '.invited', function (event){
        event.preventDefault();
        var user_id = $(this).attr('data-id');
        var user_name = $('.user-'+user_id+' .name').text();
        $('#invited').modal('show');
        $('#invited').find('.modal-body .actor-name').text(user_name);
        $('#invited').find('.modal-body #jobinvited-actor').val(user_id);
    

});") ?>


<?= $this->registerJs("$(document).on('submit', '#formInvited', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["job/jobinvited"]) . "',
               type: 'post',
          data: $('form#formInvited').serialize(),
        success: function(data, status) {
          if(data){
       $('#invited').modal('hide');          
}
        }
    });

});

") ?>
