<div class="modal fade bs-example-modal-sm" id="modal" tabindex="-1" role="dialog">    
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= !Yii::$app->user->isGuest ? 'Book việc' : 'Đăng nhập' ?></h4>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>    


<?= $this->registerJs("$(document).on('submit', '#formBid', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["bid/create"]) . "',
            type: 'post',
            data: $('form#formBid').serialize(),
            success: function(data) {
            if(data){
                   window.location.href = '/cong-viec/'+data.job_slug+'-'+data.job_id;
                }
            }
        });

});") ?>
<?=
$this->registerJs("$(document).on('click', '.book', function (event){
        event.preventDefault();
        var id = $(this).attr('data-id');
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["bid"]) . "',
            type: 'post',
            data: {id:id},
            success: function(data) {
                    $('#modal').modal('show');
                    $('#modal').find('.modal-body').html(data);                                
            }
        });

});");
?>
<?=
$this->registerJs("$(document).on('click', '.book', function (event){
        event.preventDefault();
        var id = $(this).attr('data-id');
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["bid"]) . "',
            type: 'post',
            data: {id:id},
            success: function(data) {
                    $('#modal').modal('show');
                    $('#modal').find('.modal-body').html(data);                                
            }
        });

});");
?>
<?= $this->registerJs("$(document).on('click', '.update', function (event){
        event.preventDefault();
        var id = $(this).attr('data-id');
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["bid/update"]) . "',
            type: 'get',
            data: {id:id},
              success: function(data) {
                    $('#modal').modal('show');
                    $('#modal').find('.modal-body').html(data);                                
            }
        });

});") ?>


<?= $this->registerJs("$(document).on('click', '.btn-delete', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/removebid"]) . "',
            type: 'post',
             data: $('form#frmComfirm').serialize(),
            success: function(data) {
                if(data.message=='ok'){
                   // $('.option-'+data.job_id).html('<a class=\"btn btn-blue book\" data-id='+data.job_id+'>Book việc</a>');
                     $('#confirm-delete').modal('hide');
                            window.location.href = '" . $_SERVER['REQUEST_URI'] . "';    
                }
            }
        });

});") ?>