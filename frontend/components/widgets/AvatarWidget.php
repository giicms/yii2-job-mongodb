<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class AvatarWidget extends Widget {

    public $crop;
    public $setValue;

    public function init() {
        
    }

    public function run() {
        $detect = new \Mobile_Detect();
        ?>

        <input type="hidden" id="crop" value="<?= $this->crop ? 1 : 0 ?>">
        <input type="hidden" id="setValue" value="<?= $this->setValue ?>">
        <input type="hidden" id="detect" value="<?= ($detect->isMobile() ? 1 : 0) ?>">
        <div class="profile-item no-border">
            <div class="profile">
                <img id="rs-avatar" src="<?= Yii::$app->params['url_file'] ?>thumbnails/<?= !empty(Yii::$app->user->identity->avatar) ? '150-' . Yii::$app->user->identity->avatar : "avatar.png" ?>" style="width:150px" class="fa avatar-16 img-circle">
            </div>
            <div class="profile-content" style="text-align: left">
                <ul>
                    <li><b>Ảnh đại diện của bạn</b></li>
                    <li>Hãy tạo cảm giác thân thiện và gần gũi với khách hàng <br> bằng ảnh đại diện của bạn.</li>
                    <li>
                        <a href="javascript:void(0)" id="upload"><i class="icon icon-add"></i> <span class="fix">Thay ảnh đại diện</span></a>
                    </li>
                    <li class="loading"></li>
                </ul>

            </div>
        </div>
        <div class="modal fade bs-example-modal-lg in" id="modalCrop" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Hình ảnh</h4>
                    </div>
                    <div class="modal-body">
                        <iframe id="iframecrop" src="" style="width:570px; height:525px; border: none; text-align: center"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-default" data-dismiss="modal">Hủy</button>
                        <button type="button"  id="cropimage" class="btn btn-primary">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
        <?=
        \Yii::$app->view->registerJs('$(document).ready(function ()
{

      $("#upload").uploadFile({
        url: "' . Yii::$app->urlManager->createUrl(["gallery/upload"]) . '",
        method: "POST",
        allowedTypes: "jpg,png,jpeg,gif",
        fileName: "myfile",
        multiple: false,
        onBeforeSend: function () {
            $(".loading").html("<img src=\'/images/loader.gif\'>");
        },
        onSuccess: function (files, data, xhr)
        {
        if(data.data.error){
             $(".loading").html("<p class=\'text-danger\'><i class=\"fa fa-exclamation-triangle\" style=\"color:red\"></i> "+data.data.error+"</p>");
} else {
            var crop = $("#crop").val();
            var detect = $("#detect").val();
            if(crop == 1){
            if(detect == 1){
           $("#modalCrop iframe").attr({"src":"/gallery/crop?id="+data.data.img_id});
           }else{
           $("#modalCrop .modal-body").load("/gallery/crop?id="+data.data.img_id);
           }
           $("#modalCrop").modal({show:true})
           } else {
           
           }
           $(".loading").html("");
           }
        },
        onError: function (files, status, errMsg)
        {
            $(".resultFile").html("Không đúng định dạng hoặc size không quá 2 MB");
        }
    });

})');
        ?>
        <?=
        $this->getView()->registerJs("$(document).on('click', '#cropimage', function (event){
    event.preventDefault();
    if(detect == 1){
    var data = $('#iframecrop').contents().find('form').serialize();
    } else {
    var data = $('#form_cropimage').serialize();
}
    var setValue = $('#setValue').val();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["gallery/crop"]) . "',
            type: 'post',
            data: data,
            success: function(data) {
           if(data){
                $('#'+setValue).val(data.name);
                $('#rs-avatar').attr('src', data.url);
                $('#modalCrop').modal('hide');
               }
            }
        });
});")
        ?>
        <?php
    }

}
