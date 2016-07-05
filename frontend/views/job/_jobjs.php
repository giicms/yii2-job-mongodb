<?= $this->registerJs("$(document).on('submit', '#formBid', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/bid"]) . "',
            type: 'post',
            data: $('form#formBid').serialize(),
            success: function(data) {
            if(data){
                            $('.option-'+data.job_id).html('');
                $('#job-options-tmpl').tmpl(data).appendTo('.option-'+data.job_id);
                $('.item-'+data.job_id+' div a.invited').remove();
                $('#modal').modal('hide');
                }
            }
        });

});") ?>

<?= $this->registerJs("$(document).on('click', '.like', function (event){
        event.preventDefault();
        var job_id = $(this).attr('data-bind');
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/savejob"]) . "',
            type: 'post',
            data: {job_id:job_id},
            success: function(data) {
                if(data=='ok'){
                $('.like-'+job_id+' span').html('Đã lưu');
                   $('.like-'+job_id).removeClass('like');
                }
            }
        });

});") ?>

<?= $this->registerJs("$(document).on('click', '.liked', function (event){
        event.preventDefault();
        var job_id = $(this).attr('data-bind');
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/savejob"]) . "',
            type: 'post',
            data: {job_id:job_id},
            success: function(data) {
                if(data=='ok'){
                $('.like-'+job_id+' span').html('Đã lưu');
                   $('.like-'+job_id).remove();
                }
            }
        });

});") ?>

<?= $this->registerJs("$(document).on('click', '.book', function (event){
        event.preventDefault();
        var job_id = $(this).attr('data-id');
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/bid"]) . "',
            type: 'post',
            data: {job_id:job_id},
            success: function(data) {
               if(data){
                    $('#modal').modal('show');
                    $('#modal').find('.modal-body .title').text(data.name);
                    $('#modal').find('.modal-body input#bid-price').val();
                    $('#modal').find('.modal-body input#bid-period').val();
                    $('#modal').find('.modal-body textarea#bid-content').val();
                    $('#modal').find('.modal-body input#bid-job').val(data.job_id);
                    $('#modal').find('.modal-body input#bid').val();
               }
            }
        });

});") ?>

<?= $this->registerJs("$(document).on('click', '.update', function (event){
        event.preventDefault();
        var id = $(this).attr('data-id');
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/bid"]) . "',
            type: 'post',
            data: {id:id},
            success: function(data) {
               if(data){
                       $('#modal').modal('show');
                         $('#modal').find('.modal-body .title').text(data.name);
                           $('#modal').find('.modal-body input#bid-price').val(data.price);
                            $('#modal').find('.modal-body input#bid-period').val(data.period);
                             $('#modal').find('.modal-body textarea#bid-content').val(data.content);
                         $('#modal').find('.modal-body input#bid-job').val(data.job_id);
                          $('#modal').find('.modal-body input#bid').val(data.id);
               }
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
                    $('.option-'+data.job_id).html('<a class=\"btn btn-blue book\" data-id='+data.job_id+'>Book việc</a>');
                     $('#confirm-delete').modal('hide');
                }
            }
        });

});") ?>

<?= $this->registerJs("$('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.modal-body .alert').text($(e.relatedTarget).data('alert'));
        $(this).find('.modal-body input#confirm-id').val($(e.relatedTarget).data('id'));
    $(this).find('.btn-delete').attr('href', $(e.relatedTarget).data('href'));
});") ?>
