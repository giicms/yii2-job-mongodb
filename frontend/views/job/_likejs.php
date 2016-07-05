<?= $this->registerJs("$(document).on('click', '.like', function (event){
        event.preventDefault();
        var job_id = $(this).attr('data-bind');
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/savejob"]) . "',
            type: 'post',
            data: {job_id:job_id},
            success: function(data) {
                if(data==2){
                $('.like-'+job_id+' span').html('Đã lưu');
                } else {
                $('.like-'+job_id+' span').html('Lưu việc');
                
}
            }
        });

});") ?>


