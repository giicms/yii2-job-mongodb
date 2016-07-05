<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Skills */
/* @var $form yii\widgets\ActiveForm */
?>
<?= $form->field($model, 'category_id')->dropDownList($model->categories, ['prompt' => 'Chọn danh mục']) ?>
<?= $form->field($model, 'sectors')->dropDownList($model->sectorList, ['prompt' => 'Chọn chuyên mục', 'multiple' => TRUE]); ?>    
<?php

echo $form->field($model, 'options')->dropDownList($model->options, ['multiple' => TRUE]);
?>
<?= $form->field($model, 'description')->textarea() ?>
<?= $this->registerJs('
$("#budgetpacket-sectors").select2({
      placeholder: "Chọn lĩnh vực",
});
');
?>

<?=

$this->registerJs('
$("#budgetpacket-options").select2({
  tags: true,
  tokenSeparators: [","]
})
');
?>