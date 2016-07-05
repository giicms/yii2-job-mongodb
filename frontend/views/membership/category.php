
<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Hãy chọn ngành nghề của bạn!';
?>
<!-- jobs -->
<section>
    <div class="jobs-container" style="position:relative;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="title-container">
                        <h3 style="margin-bottom:15px;">Chào mừng đến với Giaonhanviec.com!</h3>
                        <h4>Chọn ngành nghề phù hợp với năng lực và kinh nghiệm làm việc của bạn.</h4>
                    </div>
                </div>
            </div>
            <!-- jobs -->
            <div class="row">
                <div id="tabjob_select">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal  frm-Profile']]); ?>  
                    <ul class="list-unstyled">
                        <li class="cate-job">
                        <?php if (Yii::$app->session->hasFlash('error')) { ?>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="alert alert-danger" role="alert">
                                    <?= Yii::$app->session->getFlash('error') ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        if (!empty($jobCategory)) {
                            $dem = 1;
                            foreach ($jobCategory as $value) {
                            ?>
                            <!-- job item -->
                            <div class="catejob-item col-md-3 col-sm-6 col-xs-12">
                                <a href="javascript:;" data="<?=$value->_id?>" rel="<?=$dem++?>">
                                    <div class="checkbox-inline">
                                        <input id="radio2" type="radio" name="User[category]" value="<?=$value['id'];?>">
                                    </div> 
                                    <div class="job-item">
                                        <div class="icon job-<?= $value['icon'] ?>"></div>
                                        <div class="line-gray"></div>
                                        <div class="title-job">
                                            <h4><?= $value['name'] ?></h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- End job item -->
                            <?php
                            }
                        }
                        ?>
                            <div class="clear-fix"></div>     
                        </li>
                        <?php 
                            foreach ($jobCategory as $key => $value) {
                                $sectors = $value->getJobsector((string)$value->_id);
                        ?>
                        <li id="cate<?=$value->_id?>" class="tabsector-tem">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <?php 
                                        if(!empty($sectors)){
                                        foreach ($sectors as $sector) {
                                    ?>
                                    <!-- item section job -->
                                    <div class="col-md-2 col-sm-3 col-xs-6 sector-item">
                                        <a href="javascript:;">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="User[sector][]" value="<?=$sector['id'];?>">
                                                <div class="clear-fix"></div> 
                                            </label>    
                                            <div class="job-item text-center">
                                                <div class="icon job-<?=$sector['icon'];?>"></div>
                                                <div class="line-gray"></div>
                                                <div class="title-job">
                                                    <h4><?=$sector['name'];?></h4>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <!-- end item section job -->
                                    <?php
                                        }}
                                    ?>
                                </div>    
                            </div>
                            <?php if (Yii::$app->session->hasFlash('error')) { ?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="alert alert-danger" role="alert">
                                        <?= Yii::$app->session->getFlash('error') ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <a href="javascript:;" class="btn btn-blue comeback">Quay lại</a>
                                <button type="submit" class="btn btn-success continue">Lưu và tiếp tục</button>
                            </div>
                            <div class="clear-fix"></div>     
                        </li>
                        <?php }?>
                    </ul>
                    <?php ActiveForm::end(); ?>
                    
                </div>

            </div>
            <!-- End jobs -->
        </div>
    </div>
</section>
<!-- End jobs -->


<?= $this->registerJs("
    $(document).ready(function(){
        var width = $('#tabjob_select').width();
        var numItems = $('.tabsector-tem').length;
        $('#tabjob_select ul').css({'width':(1+numItems)*width, 'position':'relative'});
        $('#tabjob_select ul li').width(width);

        $('.cate-job a').click(function(){
            var cate = $(this).attr('data');
            var rel = $(this).attr('rel');
            $('.cate-job a.active').removeClass('active');
            $(this).addClass('active');

            if($(this).hasClass('active')){
                $(this).find('input').prop('checked', true);
            }else{
                $(this).find('input').prop('checked', false);
            }
            $('.tabsector-tem a').find('input').prop('checked', false);
            $('.tabsector-tem a').removeClass('active');
            $('#tabjob_select ul').animate({left: -width*rel}, 150);
        })

        $('.comeback').click(function(){
            $('#tabjob_select ul').animate({left: '0'}, 150);
        })

        $('.tabsector-tem a').click(function(){
            $( this ).toggleClass('active');
            if($(this).hasClass('active')){
                $(this).find('input').prop('checked', true);
            }else{
                $(this).find('input').prop('checked', false);
            }
            return false();
           
        })

    });
") ?>



