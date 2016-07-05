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
            <div class="content">
                <p>Để tăng cấp và được khách hàng tiềm năng tin tưởng bằng cách hoàn thành các bài kiểm tra trong lĩnh vực chuyên môn của bạn </p>
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal frm-testing']]); ?>
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="select">
                            <?php
                            echo $form->field($model, 'category_id')->dropDownList($model->categoryList, ['prompt' => 'Chọn danh mục'])->label(FALSE);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="select">
                            <?php echo $form->field($model, 'sector_id')->dropDownList([], ['prompt' => 'Chọn chuyên mục'])->label(false);
                            ?>     
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <button class="btn btn-blue" type="submit"><i class="fa fa-pencil-square-o"></i> Bắt đầu test</button>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="title-container" style="margin-top: 30px;">
                <h4>Lịch sử test</h4>
            </div>
            <div class="content tests">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tên bài kiểm tra</th>
                                <th>Điểm tối đa (10)</th>
                                <th>Thời gian hoàn tất</th>
                                <th>Xếp loại</th>
                                <th>Test vào lúc</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($test)) {
                                foreach ($test as $value) {
                                    $point = number_format($value->point * (10 / $value->sector->test_number), 1, '.', '');
                                    if ($point < 5)
                                        $rank = 'Yếu';
                                    elseif ($point >= 5 || $point < 6.5)
                                        $rank = 'Trung bình';
                                    elseif ($point >= 6.5 || $point < 8)
                                        $rank = 'Khá';
                                    else
                                        $rank = 'Tốt';

                                    $time = $value->sector->test_time - number_format(str_replace(':', '.', $value->count_time), 2, '.', '');
                                    ?>
                                    <tr><td><?= $value->sector->name ?></td><td><span class="point"><?= $point ?> </span></td><td><?= $time ?> phút</td><td><span class="label label-success"><?= $rank ?></span></td><td><?= date('H:i', $value->created_at) ?> Ngày <?= date('d-m-Y', $value->created_at) ?></td></tr>
                                            <?php
                                        }
                                    }
                                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->registerJs('
$("#test-category_id").on("change",function(){    
 $.ajax({
   url:"' . Yii::$app->urlManager->createUrl(["ajax/sector"]) . '",
   type:"POST",            
   data:"id="+$("#test-category_id option:selected").val(),
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
               $("#test-sector_id").html(html);
       }
      });
    });

');
?>