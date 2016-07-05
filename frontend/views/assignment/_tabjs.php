<?= $this->registerJs("$(document).on('keypress', '#commentMessage', function (event) {
    var code = (event.keyCode ? event.keyCode : event.which);
    if (code == '13' && !event.shiftKey)
    {
            $.ajax({
                type: 'POST',
                        url: '" . Yii::$app->urlManager->createUrl(["ajax/message"]) . "',
                      data: $('form#formJob').serialize(),
                cache: false,
                success: function (data) {
             $('#message-tmpl').tmpl(data).appendTo('.comment .mCustomScrollBox .mCSB_container');
             $('#commentMessage').val('');
                }
            });
     
    }
    //return false;
});") ?>
<?=

$this->registerJs("$(document).ready(function()
{
    var refreshId = setInterval( function() 
    {
      $('#mCSB_2_container').load('" . Yii::$app->urlManager->createUrl(["messages/lists", "id" => (string) $job->_id]) . "');
    }, 500);
});")
?>
