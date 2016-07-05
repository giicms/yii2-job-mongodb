<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(['options' => [ 'class' => 'form-horizontal form-label-left']]); ?>  
<?php if (Yii::$app->session->hasFlash('success')) { ?>
    <div class="alert alert-success" role="alert">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php } ?>
<?= $form->field($model, 'name', ['template' => '<div class="col-md-2 col-sm-4 col-xs-12">{label}</div><div class="col-md-4 col-sm-6 col-xs-12">{input}{hint}{error}</div>'])->textInput() ?>
<?= $form->field($model, 'description', ['template' => '<div class="col-md-2 col-sm-4 col-xs-12">{label}</div><div class="col-md-4 col-sm-6 col-xs-12">{input}{hint}{error}</div>'])->textarea() ?>
<?= $form->field($model, 'icon', ['template' => '<div class="col-md-2 col-sm-4 col-xs-12">{label}</div><div class="col-md-4 col-sm-6 col-xs-12">{input}{hint}{error}</div>'])->textInput() ?>
<div class="form-group">
    <div class="col-md-2 col-sm-4 col-xs-12"><label class="control-label">Skills</label></div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <select name="skills[]" class="form-control skills" multiple>
            <?php
            if (!empty($skills)) {
                foreach ($skills as $value) {
                    $exit = $model->getExitskill($model->id, $value->id);
                    ?>
                    <option value="<?= $value->id ?>" <?= $exit == 1 ? "selected" : "" ?>><?= $value->name ?></option>
                    <?php
                }
            }
            ?>
        </select>
    </div>
</div>
<div class="form-group">
    <div class="col-md-offset-2 col-md-4 col-sm-6 col-xs-12">
        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?= $this->registerJs('
$(".skills").select2({
      placeholder: "Chọn skills",
});
');
?>
