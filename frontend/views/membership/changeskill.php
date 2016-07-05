
<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<style>
    .disnone{
        display: none
    }
    .disblock{
        display: block
    }
</style>
<section>
    <div class="introduce select-skills">
        <div class="container">
            <div class="row">

                <!-- introduce item -->
                <div class="col-md-12 col-sm-12 col-xs-12 title-container">
                    <?php $form = ActiveForm::begin(); ?>
                    <h3>Chào mừng đến với Giaonhanviec.com!</h3>
                    <h4 class="title-box">Chọn lĩnh vực ngành nghề phù hợp với năng lực và kinh nghiệm của bạn</h4>
                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="title-col">
                                                DANH MỤC NGÀNH NGHỀ 
                                            </div>
                                            
                                        </div>
                                        <div class="col-sm-6" style="border-left: 1px solid #ccc;">
                                            <div class="title-col">
                                                DANH MỤC KỸ NĂNG
                                            </div>    
                                        </div>
                                    </div>
                                </div>    
                                <div class="panel-content">
                                    <div class="form-search-skill">
                                        <div class="form-group">
                                            <label class="col-md-3 col-sm-4 col-xs-12 control-label">
                                                Tìm kiếm kỹ năng
                                            </label>
                                            <div class="col-md-9 col-sm-8 col-xs-12 form-input">
                                                <input id="search" type="text" class="form-control">
                                            </div>
                                            <div class="clear-fix"></div>
                                        </div>
                                    </div>

                                    <div class="jobs-skill">
                                        <ul class="jobs list-unstyled scroll">
                                            <?php
                                            if (!empty($sectors)) {
                                                foreach ($sectors as $k => $val) {
                                                        ?>
                                                        <li class="<?= $k == 0 ? "active" : "" ?>"><a href="javascript:void(0)" class="cat-item" data="<?= $k ?>"><?= $val->name ?></a></li>
                                                        <div class="cat-<?= $k ?> disnone">
                                                            <?= implode(',', $val->skills); ?>
                                                        </div>
                                                        <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                        <ul class="skill list-unstyled scroll">
                                            <?php
                                            if (!empty($sectors)) {
                                                $num = 0;
                                                foreach ($sectors as $k => $val) {
                                                    $cl_sect = $num++;
                                                    foreach ($val->skills as $skill) {

                                                    if($model->skills){
                                                        if (in_array($skill, $model->skills)) { $active = "active"; $item = "";}else{$active = ""; $item = "item";}
                                                    }else{$active = ""; $item = "item";}
                                                        
                                            ?>

                                                    <li class="id-<?=$skill?> <?=$active?>"><a href="javascript:void(0)" class="<?=$item?> skill-item sector<?=$k?>" data="<?=$skill?>"><?= $model->getSkillname($skill) ?></a></li>
                                            <?php              
                                                    }
                                                }
                                            }
                                            ?>
                                        </ul>
                                        <div class="clear-fix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="title-col">DANH SÁCH KỸ NĂNG ĐÃ CHỌN (tối đa 12)</div>
                                </div>
                                <div class="panel-body">
                                    <ul class="rs-skill list-unstyled">
                                        <?php 
                                            if($model->skills){ $count = count($model->skills);} else{ $count=0;}
                                        ?>
                                        <li><input type="hidden" id="count-skill" value="<?=$count;?>"></li>
                                        <?php
                                        if($model->skills){ 
                                            foreach ($model->skills as $skill) {
                                        ?>
                                            <li class="item-<?=$skill?>">
                                                <?=$model->getSkillname($skill);?>
                                                <input type="hidden" value="<?=$skill?>" name="skills[]">
                                                <a class="btn btn-remove delete" data-id="<?=$skill?>" href="javascript:void(0)">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </li>
                                        <?php
                                        }}
                                        ?>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="text-right">
                                <a href="#">Quay lại</a>
                                <button type="submit" class="btn btn-blue">Lưu và tiếp tục</button>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
</section>
<!-- select sector -->
<?=$this->registerJs("
    $(document).ready(function(){
        $('.cat-item').click(function(){
            var data = $(this).attr('data');
            $('.jobs li').removeClass('active');
            $(this).parent().addClass('active');
            $('.skill-item').hide();
            $('.skill .sector'+data).css('display','list-item');
            return false;
        });
    });
")?>

<!-- slect skill item -->
 <?=$this->registerJs('
$(document).on("click", ".item", function () {
            var name =$(this).text();
            var id = $(this).attr("data");
            var count =parseInt($("#count-skill").val())+1;
            if (count < 13){
                $("#count-skill").val(count);
                $(".id-"+id).addClass("active");
                $(".rs-skill").append("<li class=item-"+id+">"+name+"<input type=\"hidden\" name=\"skills[]\" value=\'"+id+"\'><a href=\"javascript:void(0)\" data-id="+id+" class=\"btn btn-remove delete\"><i class=\"fa fa-times\"></i></a></li>");
                $(".id-"+id+" a").removeClass("item");
            }else{
                $.notify({
                    // options
                    icon: "fa fa-exclamation-triangle",
                    message: "Bạn đã chọn tốt đa 25 kỷ năng cá nhân " 
                },{
                    // settings
                    type: "danger"
                });
            }
            return false;

})');?>

<!-- remove skill item -->
<?=
$this->registerJs('$(document).ready(function ()
{
    $(document).on("click", ".delete", function () {
    var id = $(this).attr("data-id");
    var count =parseInt($("#count-skill").val())-1;
    $("#count-skill").val(count);
    $(this).parent().remove();
    $(".id-"+id).removeClass("active");
    $(".id-"+id+" .skill-item").addClass("item");
    });
})');
?>

<!-- search skill -->
<?=$this->registerJs("
    $(document).ready(function(){
        var rows = $('.skill li');
        $('#search').keyup(function() {
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
            
            rows.show().filter(function() {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();
        });
    })
")?>


