<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Kiểm tra bài test';
?>
<section>
    <div class="introduce profile-edit profile-member">
        <?php
        $form = ActiveForm::begin(['id' => 'formTest', 'options' => ['name' => 'start']]);
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="title-container">
                        <h4><?= $this->title ?> 
                            <?php
                            if (!empty($model->questions)) {
                                echo '<small class="pull-right">Bạn trả lời đúng được ' . $model->point . ' câu.</small>';
                            } else {
                                ?>
                                <small id="countDown" class="pull-right"></small>
                            <?php } ?>
                        </h4>
                    </div>
                </div>
            </div>

            <?php
            if (!empty($questions)) {
                for ($i = 0; $i < $model->sector->test_number; $i++) {
                    if (!empty($questions[$i]->name)) {
                        ?>
                        <div class="row">
                            <div class="col-lg-12">Câu <?= $i + 1 ?>: <?= $questions[$i]->name ?>   <hr></div>
                            <input type="hidden" name="question_id[<?= $i ?>]" value="<?= (string) $questions[$i]->_id ?>">
                            <?php
                            foreach ($questions[$i]->questions as $k => $val) {
                                $order = $k;
                                echo ' <div class="col-lg-6"><div class="radio"><label><input type="radio" name="question_' . $i . '" value="' . $order . '">' . $val . '</label></div></div>';
                            }
                            ?>
                        </div>
                        <?php
                    }
                }
            }
            ?>
            <input type="hidden" id="count-time" value="<?= $model->sector->test_time ?>">
            <div id="timer"></div>
            <?php
            if (!empty($model->questions)) {
                echo 'Đề này bạn đã kiểm tra, bạn hãy tạo câu hỏi khác.';
                echo '<a href=' . Yii::$app->urlManager->createAbsoluteUrl(['test/index']) . '>Tạo câu hỏi';
            } else {
                ?>
                <div class="form-group">
                    <?= Html::submitButton('Nộp bài ', ['class' => 'btn btn-primary pull-right']) ?>
                </div>
            <?php } ?>
        </div>
        <?php
        ActiveForm::end();
        ?>
    </div>
</section>

<script type="text/javascript">

    var phut = parseInt(document.getElementById('count-time').value), timeLeft = 0;
    function decrementCounter()
    {
        if (phut >= 0) {
            if (timeLeft > 0) {
                document.all('countDown').innerHTML = "Thời gian làm bài: " + phut + " : " + timeLeft + "<input type='hidden' name='time' value='" + phut + ":" + timeLeft + "'>";
                timeLeft--;
                setTimeout("decrementCounter()", 1000);
            }
            else {
                document.all('countDown').innerHTML = "Thời gian làm bài: " + phut + " : " + timeLeft;
                timeLeft--;
                setTimeout("decrementCounter()", 1000);
                timeLeft = 60;
                phut--;

            }
        }
        else {
            document.getElementById("formTest").submit();
        }
    }
    decrementCounter();

</script>

