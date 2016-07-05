<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
?>
<?php $form = ActiveForm::begin(['id' => 'form_cropimage', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>  

<div class="cropbox" style="margin: 0 auto">
    <img id="cropbox" src="<?= $src ?>">
</div>
<div style="display: none">
    <?= $form->field($model, 'id')->hiddenInput(['value' => $id])->label(FALSE) ?>
    <?= $form->field($model, 'x1')->hiddenInput()->label(FALSE) ?>
    <?= $form->field($model, 'y1')->hiddenInput()->label(FALSE) ?>
    <?= $form->field($model, 'x2')->hiddenInput()->label(FALSE) ?> 
    <?= $form->field($model, 'y2')->hiddenInput()->label(FALSE) ?> 
    <?= $form->field($model, 'w')->hiddenInput()->label(FALSE) ?> 
    <?= $form->field($model, 'h')->hiddenInput()->label(FALSE) ?>
</div>
<?php ActiveForm::end(); ?>

<?= $this->registerJsFile(Yii::$app->urlManager->createAbsoluteUrl(['js/jquery-ui.min.js']), ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?= $this->registerJsFile(Yii::$app->urlManager->createAbsoluteUrl(['js/jquery.Jcrop.js']), ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?= $this->registerCssFile(Yii::$app->urlManager->createAbsoluteUrl(['css/jquery.Jcrop.css']), ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?=
$this->registerJs("$(document).ready(function(){
   
				jQuery('#cropbox').Jcrop({
					onChange: showCoords,
					onSelect: showCoords,
                                        minSize: [150,150],
                                        setSelect:[150, 150, 355, 355 ],
                                        aspectRatio: 1/1,

				});

			});

			// Simple event handler, called from onChange and onSelect
			// event handlers, as per the Jcrop invocation above
			function showCoords(c)
			{
				jQuery('#crop-x1').val(c.x);
				jQuery('#crop-y1').val(c.y);
				jQuery('#crop-x2').val(c.x2);
				jQuery('#crop-y2').val(c.y2);
				jQuery('#crop-w').val(c.w);
				jQuery('#crop-h').val(c.h);
			};")
?>

<?php
if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}
?>