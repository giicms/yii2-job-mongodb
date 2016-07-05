<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Nganh nghe';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>


    <p><span id="countDown"></span></p>
    <?php
    $form = ActiveForm::begin(['id' => 'test-form']);
    if (!empty($model)) {
        for ($i = 0; $i < 6; $i++) {
            ?>
            <div class="row">
                <div class="col-lg-12"><?= $model[$i]->name ?></div>
                <input type="hidden" name="question_id[<?= $i ?>]" value="<?= (string) $model[$i]->_id ?>">
                <?php
                foreach ($model[$i]->questions as $k => $val) {
                    $order = $k + 1;
                    echo ' <div class="col-lg-6"><div class="radio"><label><input type="radio" name="question_' . $i . '" value="' . $order . '">' . $val . '</label></div></div>';
                }
                ?>
            </div>
            <?php
        }
    }
    ?>
    <input type="hidden" id="count-time" value="1">
    <input type="submit" value="Submit">
    <?php
    ActiveForm::end();
    ?>

</div>


<script type="text/javascript">
    var phut = parseInt(document.getElementById('count-time').value), timeLeft = 0;
    function decrementCounter()
    {

        if (phut >= 0) {
            if (timeLeft > 0) {
                document.all('countDown').innerHTML = "Thời gian làm bài: " + phut + " phut " + timeLeft + " s ";
                timeLeft--;
                setTimeout("decrementCounter()", 1000);
            }
            else {
                document.all('countDown').innerHTML = "Thời gian làm bài: " + phut + " phut " + timeLeft + " s ";
                timeLeft--;
                setTimeout("decrementCounter()", 1000);
                timeLeft = 60;
                phut--;

            }
        }
        else {
            autoSubmit();
        }

    }
    decrementCounter();
</script>

