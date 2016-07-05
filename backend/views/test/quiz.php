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



    <?php
    $form = ActiveForm::begin(['id' => 'test-form']);
    echo $form->field($model, '_id')->hiddenInput()->label(FALSE);
    if (!empty($model)) {
        foreach ($model->questions as $value) {
            $question = $model->question($value['id']);
            ?>
            <div class="row">
                <div class="col-lg-12"><?= $question->name ?></div>
                <?php
                foreach ($question->questions as $k => $val) {
                    echo ' <div class="col-lg-6"><div class="radio"><label><input type="radio" name="Test_' . $value['id']. '" value="' . $k . '">' . $val . '</label></div></div>';
                }
                ?>
            </div>
            <?php
        }
    }
    ?>
    <input type="submit" value="Submit">
    <?php
    ActiveForm::end();
    ?>

</div>

</div>
