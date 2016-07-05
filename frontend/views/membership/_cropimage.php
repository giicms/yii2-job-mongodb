<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="modal fade bs-example-modal-lg in" id="modalImg" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<?=
$this->registerJs('$(document).ready(function ()
{
    var upload = {
        url: "' . Yii::$app->urlManager->createUrl(["upload/image"]) . '",
        method: "POST",
        allowedTypes: "jpg,png,jpeg,gif",
        fileName: "myfile",
        multiple: false,
        maxSize: 100000,
        onBeforeSend: function () {
            $(".loading").html("Đang tải...");
        },
        onSuccess: function (files, data, xhr)
        {
            $.each(data, function (index, value) {
                $(".loading").html("");
                var img = value[0].name;
                $("#avatar").val(value[0].name);
                $("#profile-avatar").val(value[0].name);
                   $("#boss-avatar").val(value[0].name);       
                   $("#bossinfo-avatar").val(value[0].name);
                   $("#modalImg").modal({
                   show: true,
                   remote: "/ajax/image?src="+img,
                   backdrop: "static",
                   keyboard: false
});    
            });
        },
        onError: function (files, status, errMsg)
        {
            $(".resultFile").html("Không đúng định dạng hoặc size không quá 2 MB");
        }
    };
        $(".uploadFile").uploadFile(upload);

})');
?>
<?=
$this->registerJs("$(document).ready(function(){

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

<?= $this->registerJs("$(document).on('submit', '#cropimage', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["upload/cropimage"]) . "',
               type: 'post',
          data: $('form#cropimage').serialize(),
        success: function(data) {
          if(data){
  window.location.href = '" . $_SERVER['REQUEST_URI'] . "';        
}
        }
    });

});") ?>
<?= $this->registerJs('
$(document).on("click", ".modal-cancel", function (event){
                 window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
});') ?>