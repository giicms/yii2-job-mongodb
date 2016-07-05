<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\gallery\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class Upload extends Widget {

    public $lable;
    public $crop;
    public $view;

    public function init() {
        
    }

    public function run() {
        ?>
        <a href="javascript:void(0)" style="overflow: hidden" id="upload"><?= $this->lable ?></a>
        <div class="loading"></div>
        <input type="hidden" id="crop" value="<?= $this->crop ? 1 : 0 ?>">
        <div class="modal fade bs-example-modal-lg in" id="modalCrop" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Hình ảnh</h4>
                    </div>
                    <div class="modal-body">
                        <iframe id="iframecrop" src="" style="width:570px;height:570px; border: none; text-align: center"></iframe>
                        <div class="row-item text-right">
                            <button type="submit" id="cropimage" class="btn btn-blue" style="padding: 6px 12px; text-transform: none">Lưu</button>
                            <a type="submit" class="btn btn-default modal-cancel">Hủy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?=
        \Yii::$app->view->registerJs('$(document).ready(function ()
{

    var upload = {
        url: "' . Yii::$app->urlManager->createUrl(["gallery/upload"]) . '",
        method: "POST",
        allowedTypes: "jpg,png,jpeg,gif",
        fileName: "myfile",
        multiple: false,
        maxSize: 2024,
        onBeforeSend: function () {
            $(".loading").html("Đang tải...");
        },
        onSuccess: function (files, data, xhr)
        {
            var crop = $("#crop").val();
            if(crop == 1){
           $("#modalCrop iframe").attr({"src":"/gallery/crop?id="+data.data.img_id});
           $("#modalCrop").modal({show:true})
           } else {
           
           }
        },
        onError: function (files, status, errMsg)
        {
            $(".loading").html("Không đúng định dạng hoặc size không quá 2 MB");
        }
    };
        $("#upload").uploadFile(upload);

})');
        ?>
        <?=
        $this->getView()->registerJs("$(document).on('click', '#cropimage', function (event){
    event.preventDefault();
    var data = $('#iframecrop').contents().find('form').serialize();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["gallery/crop"]) . "',
            type: 'post',
            data: data,
            success: function(data) {
           if(data){
                $('#preview-img')
               }
            }
        });
});")
        ?>
        <?php
    }

}
