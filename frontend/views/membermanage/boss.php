
<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Danh sách khách hàng';
?>
<section>
    <div class="introduce">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="title-container">
                        <h3><?= $this->title ?> </h3>
                    </div>

                    <!-- profile-item -->
                    <?php
                    if (!empty($model)) {
                        foreach ($model as $key => $value) {
                            ?>
                            <div class="profile-item user-<?= (string) $value->actor_id ?>">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="profile">
                                            <img width="100" src="<?= Yii::$app->params['url_file'] ?>thumbnails/<?= !empty($value->owner->avatar) ? '150-' . $value->owner->avatar : "avatar.png" ?>" class="avatar img-circle">
                                            <div class="num-review">
                                                <h5>Đánh giá: </h5> <span>5.0</span>
                                            </div>
                                        </div>
                                        <div class="profile-content">
                                            <ul class="list-unstyled text-left">

                                                <li>
                                                    <h5>
                                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['user/' . $value->owner->slug]) ?>"  class="name"><b><?= $value->owner->name ?></b></a>
                                                        <small> - Hoạt động cách đây <?= Yii::$app->convert->time($value->owner->created_at) ?></small>
                                                    </h5>
                                                </li>
                            
                                                <li>
                                                    <i class="fa fa-map-marker"></i> 
                                                    <b><?= $value->owner->location->name ?>, <?= $value->owner->location->city->name ?></b>
                                                </li>
                                          
                                            </ul>

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="profile-content">
                                            <ul class="list-unstyled">
                                                <li>
                                                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['tin-nhan/' . $value->actor->slug]) ?>" class="btn btn-blue">Liên hệ</a> 
                                                </li>
                                                <li>
                                                    <?php
                                                    if (!empty($value->owner->bookboss))
                                                        echo '<p class="text-danger">' . $value->owner->bookuser . '</p>';
                                                    ?>
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
