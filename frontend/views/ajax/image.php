<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="modal-header">
<!--    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
    <h4 class="modal-title">Hình ảnh</h4>
</div>
<div class="modal-body">
    <?php $form = ActiveForm::begin(['id' => 'cropimage', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>  
    <div class="row-item">
        <div class="cropbox" style="margin: 0 auto">
            <img id="cropbox" src="<?= Yii::$app->params['url_file'] ?>thumbnails/<?= $src ?>">
        </div>
    </div>
    <input type="hidden" id="avatar" name="img" value="<?= $src ?>"/>
    <input type="hidden" size="4" id="x1" name="x1" />
    <input type="hidden" size="4" id="y1" name="y1" />
    <input type="hidden" size="4" id="x2" name="x2" />
    <input type="hidden" size="4" id="y2" name="y2" />
    <input type="hidden" size="4" id="w" name="w" />
    <input type="hidden" size="4" id="h" name="h" />

    <div class="row-item">
        <button type="submit" class="btn btn-blue">Lưu</button>
        <a type="submit" class="btn btn-default modal-cancel">Hủy</a>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?= $this->registerJs("$(document).ready(function(){

				jQuery('#cropbox').Jcrop({
					onChange: showCoords,
					onSelect: showCoords,
                                        minSize: [150,150],
                                        setSelect:[50, 50, 200, 200 ],
                                        aspectRatio: 1/1,

				});

			});

			// Simple event handler, called from onChange and onSelect
			// event handlers, as per the Jcrop invocation above
			function showCoords(c)
			{
				jQuery('#x1').val(c.x);
				jQuery('#y1').val(c.y);
				jQuery('#x2').val(c.x2);
				jQuery('#y2').val(c.y2);
				jQuery('#w').val(c.w);
				jQuery('#h').val(c.h);
			};")
?>