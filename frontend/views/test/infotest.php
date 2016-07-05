<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Kiểm tra năng lực';
?>
<section>
    <div class="introduce testing">
        <div class="container">
            <div class="title-container">
                <h3><?= $this->title ?> <small id="countDown" class="pull-right"></small></h3>
            </div>
            <div class="content tests">
                <div class="row">
                    <div class="col-md-8 col-sm-7 col-xs-12>">
                        <h4><a href="#"><i class="fa fa-angle-double-left"></i> Quay lại</a></h4>
                        <div class="title-container" style="margin-top: 30px;">
                            <h4><?= $model->sector->name ?></h4>
                        </div>
                        <p>Bài test này bao gồm <?= $model->sector->test_number ?> câu trắc nghiệm về và bạn có <?= $model->sector->test_time ?> phút để hoàn thành bài test này.</p>
                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['test/start', 'id' => (string) $model->_id]) ?>" class="btn btn-blue"><i class="fa fa-pencil-square-o"></i> Bắt đầu test</a>
                    </div>
                    <div class="col-md-4 col-sm-5 col-xs-12>">
                        <div class="well">
                            <h4><strong>Nội dung bài test bao gồm  </strong></h4>
                            <ul class="nav">
                                <?php
                                foreach ($model->sector->skills as $value) {
                                    $getskill = $model->getSkills($value);
                                    echo '<li>' . $getskill->name . '</li>';
                                }
                                ?>

                            </ul>
                            <a href="#"><b>Tìm hiểu thêm về kỹ năng làm bài test <i class="fa fa-angle-double-right"></i></b></a>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</section>

<?= $this->registerJs('
$("#category_id").on("change",function(){    
 $.ajax({
   url:"' . Yii::$app->urlManager->createUrl(["ajax/sector"]) . '",
   type:"POST",            
   data:"id="+$("#job-category_id option:selected").val(),
   dataType:"json",
   success:function(data){     
         if(data){
         var html = "<option>Chọn chuyên mục</option>";
         for (index = 0; index < data.length; ++index) {
         html += "<option value="+data[index].id+">"+data[index].name+"</option>";
}    
         } else{
              html = "<option>Chuyên mục này chưa có</option>";
         }
               $("#job-sector_id").html(html);
       }
      });
    });

');
?>