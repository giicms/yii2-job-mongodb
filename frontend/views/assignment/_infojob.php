<div class="col-md-8 col-sm-12 col-xs-12">
    <h2 class="job-title text-blue"><?= $job->name ?></h2>
    <p><label class="button"><?= $job->category->name ?></label> Đăng cách đây <?= Yii::$app->convert->time($job->created_at) ?></p>
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <p><b>Gía cố định </b> <br>Thời gian book việc: <?= date('d/m/Y', $job->deadline) ?></p>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <p><b>    <?php
                    if ($job->project_type == common\models\Job::WORK_HOURS) {
                        echo number_format($job->price, 0, '', '.');
                    } else {
                        echo $job->budget->name;
                    }
                    ?></b><br>Ngân sách dự kiến </p>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <p><b><?= count($job->getBId()) ?> </b><br>Nhân viên book việc </p>
        </div>
    </div> 
   
</div>
