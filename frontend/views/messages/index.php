<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

if (!empty($messages))
    $this->title = 'Tin nhắn-' . $actor->name;
else
    $this->title = 'Không có tin nhắn nào';
?>
<section>
    <?php $form = ActiveForm::begin(['id' => 'formMessages']); ?>  
    <div class="introduce">
        <div class="container">

            <div class="row">

                <!-- introduce item -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="title-container">
                        <h3>Tin nhắn</h3>
                    </div>
                    <div class="message">
                        <?php
                        if (!empty($messages)) {
                            ?>
                            <div class="col-md-3 col-sm-4 col-xs-12 select-item">
                                <select id="basic" class="selectpicker show-tick form-control">
                                    <option>Hộp thư (<?= count($messages) ?>)</option>
                                </select> 
                                <div class="list-profile">
                                    <div class="scroll scroll-messages">
                                        <?php
                                        foreach ($messages as $value) {

                                            if ($value->owner == (string) \Yii::$app->user->identity->id)
                                                $user = $value->useractor;
                                            else
                                                $user = $value->userowner;
                                            if ((string) $user->_id != (string) \Yii::$app->user->identity->id) {
                                                ?>

                                                <div class="media <?= ((string) $messages_user->_id == (string) $value->_id) ? "active" : "" ?>" id="idm-<?= (string) $value->_id ?>">
                                                    <a  href="<?= Yii::$app->urlManager->createAbsoluteUrl('tin-nhan/' . $user->slug) ?>">
                                                        <div class="media-left">
                                                            <img class=" avatar" width="50" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($user->avatar) ? '150-' . $user->avatar : "avatar.png" ?>">

                                                        </div>
                                                        <div class="media-body  <?= ((string) $messages_user->_id == (string) $value->_id) ? "active" : "" ?>">
                                                            <h4 class="media-heading"><?= $user->name ?></h4>
                                                            <small>
                                                                <?php
                                                                $content = $value->conversation((string) $value->_id);
                                                                if (!empty($content))
                                                                    echo $content[count($content) - 1]->content;
                                                                ?>
                                                            </small>
                                                        </div>
                                                    </a>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12 select-item">
                                <div class="message-content">
                                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $actor->slug) ?>"><h4 class="title"><?= $actor->name ?></h4></a>
                                    <!--<p class="time"><?php // Yii::$app->convert->get_date($messages_user->created_at);                                                                                                                                  ?></p>-->
                                    <div class="comment user-messages scrollTo" style="max-height: 500px; min-height: 500px">
                                        <div class="comment-list list-messages">
                                            <?php
                                            if (!empty($conversation)) {
                                                $count = count($conversation) - 1;
                                                $tam = (string) $conversation[0]->owners->id;
                                                $h = date('dmy', $conversation[0]->created_at);
                                                ?>
                                                <div class="media"  id="m.<?= $conversation[0]->order ?>">
                                                    <div class="media-left">
                                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . (string) $conversation[0]->owners->slug) ?>">
                                                            <img class="avatar" width="50" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/150-<?= $conversation[0]->owners->avatar ?>">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading" style="margin-bottom:10px"><?= $conversation[0]->owners->name ?>
                                                        </h4>
                                                        <?php
                                                        foreach ($conversation as $key => $value) {
                                                            if ($tam == (string) $value->owners->id) {
                                                                ?>
                                                                <p style="font-size:13px; margin-bottom:5px">
                                                                    <?= $value->content ?>
                                                                    <small class="pull-right"><?= ($value->date != 0) ? date('h:i A d/m/Y', $value->created_at) : "" ?></small>
                                                                </p> <?php
                                                            } else {
                                                                $tam = (string) $value->owners->id;
                                                                ?>
                                                            </div></div><div class="media"  id="m.<?= $value->order ?>">
                                                            <div class="media-left">
                                                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . (string) $value->owners->slug) ?>">
                                                                    <img class="avatar" width="50" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/150-<?= $value->owners->avatar ?>">
                                                                </a>
                                                            </div>
                                                            <div class="media-body">
                                                                <h4 class="media-heading" style="margin-bottom:10px"><?= $value->owners->name ?>
                                                                </h4>
                                                                <p style="font-size:13px; margin-bottom:5px">
                                                                    <?= $value->content ?>
                                                                    <small class="pull-right"><?= ($value->date != 0) ? date('h:i A d/m/Y', $value->created_at) : "" ?></small>
                                                                </p>
                                                                <?php
                                                            }
                                                            if ($key == $count) {
                                                                echo ' <div class="conversation_' . $value->order . '"></div>';
                                                                echo '<div class="conversation_last"><input type="hidden" name="conversation_owner" id="conversation_owner" value="' . (string) $value->owners->id . '">';
                                                                echo '<input type="hidden" name="conversation_date" id="conversation_date" value="' . date('d', $value->created_at) . '">'
                                                                . '<input type="hidden" name="conversation_order" id="conversation_order" value="' . $value->order . '">' . '</div>';
                                                            }
                                                        }
                                                        echo '</div>';
                                                    } else {
                                                        echo '<div class="conversation_last"><input type="hidden" name="conversation_owner" id="conversation_owner" value="' . (string) Yii::$app->user->id . '">';
                                                        echo '<input type="hidden" name="conversation_date" id="conversation_date" value="' . date('d', time()) . '">';
                                                    }
                                                    ?>

                                                </div>
                                                <input type="hidden" id="page-index-messages" value="2">
                                                <div class="load-index-messages"></div>
                                            </div>

                                        </div>
                                        <div style="border-left:1px solid #ccc; overflow: hidden; padding-top: 15px">
                                            <div class="form-group col-sm-12">
                                                <input type="hidden" name="message_id" id="message-id" value="<?= (string) $messages_user->_id ?>">
                                                <input type="hidden" name="user_id" id="actor" value="<?= (string) $actor->_id ?>">
                                                <textarea class="form-control auto-height" id="commentMessage" autofocus="autofocus" name="content" style="height: 35px;" placeholder="Viêt tin nhắn..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } else {
                                echo '<p style="text-align:center; padding:100px 0">Hộp thư rỗng</p>';
                            }
                            ?>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
</section>
<?php
if (!empty($messages)) {
    ?>
    <!-- End introduce -->
    <?=
    $this->registerJs("$(document).on('keypress', '#commentMessage', function (event) {
    var code = (event.keyCode ? event.keyCode : event.which);

    if (code == '13' && !event.shiftKey)
    {
        var data = $('form#formMessages').serialize();
        var content = $('#commentMessage').val();
        var conversation_owner = $('#conversation_owner').val();
        var conversation_date = $('#conversation_date').val();
        var conversation_order = $('#conversation_order').val();
        if(content){
            $.ajax({
                type: 'POST',
                      url: '" . Yii::$app->urlManager->createUrl(["messages/create"]) . "',
                      data: $('form#formMessages').serialize(),
                cache: false,
                success: function (data) {
                $('#idm-'+data.message_id+ ' small').html(data.content);
                $('#commentMessage').val('');
                  if ((data.order==conversation_order)){
                        $('.conversation_'+data.order).append('<p style=\"font-size:13px; margin-bottom:5px\">'+data.content+'</p>');
                        } else {
                         $('.conversation_last').remove();
                         $('#list-messages').tmpl(data).appendTo('.comment-list');
                        $('.m.'+data.order+' .media-body').append('');
                    }
                 $('.scrollTo').mCustomScrollbar('scrollTo', 'bottom');
                }
            });
        }
    }
    //return false;
});
window.setInterval(function(){
    var conversation_owner = $('#conversation_owner').val();
        var conversation_date = $('#conversation_date').val();
        var conversation_order = $('#conversation_order').val();
        $.ajax({
            url: '/messages/conversation?id=" . $messages_user->_id . "',
            type: 'get',
            success: function(data) {
            if(data){
            if(data.active==2){
            $('.mact').html('');
            }
            var messages = '<li><a href='+data.url+'><img class=avatar-32 src=' + data.user_avatar + '><div class=not-inf>'+data.user_name+' đã nhắn tin \"' + data.content + '\"<p><i class=\'fa fa-commenting\'></i><small>' + data.user_time + '</small></p></div></a></li>';
                      $('.messages-bar').prepend(messages);
                if (data.order==conversation_order){
                        $('.conversation_'+data.order).append('<p style=\"font-size:13px; margin-bottom:5px\">'+data.content+'</p>');
                        } else {
                         $('.conversation_last').remove();
                       $('#list-messages').tmpl(data).appendTo('.comment-list');
                        $('.m.'+data.order+' .media-body').append('');
                    }
                $('.scrollTo').mCustomScrollbar('scrollTo', 'bottom');
             }
            }
          
        });
}, 1000);
$('textarea.auto-height').textareaAutoSize();
");
}
?>

<?= $this->registerCss('.message .message-content h4.title {padding:15px 10px; }') ?>
<?= $this->registerCss('.scroll-messages {max-height: 500px; min-height: 500px; padding: 10px 0; border-top: 1px solid #dadada; margin-top: 9px}') ?>
<?= $this->registerCss('.scroll-messages .media {padding:10px; margin:0; border-bottom: 1px solid #dadada}') ?>
<?= $this->registerCss('.scroll-messages .active h4 {background-color:#03a8e0; color:#fff}') ?>
<?= $this->registerCss('.scroll-messages .active {background-color:#03a8e0; color:#fff}') ?>
<?=
$this->registerCss('.scroll-messages .media:hover {background-color:#03a8e0; color:#fff}')?>
