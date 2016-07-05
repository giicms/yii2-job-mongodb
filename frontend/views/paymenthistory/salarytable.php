<!-- introduce -->
        <section>
            <div class="introduce payment-history">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <div class="title-container">
                                <h3>Bảng lương cá nhân </h3>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="list-project">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#sectionA">
                                            Dự án đang làm  <br> 
                                            <b>
                                            <?php 
                                            if(!empty($making)){
                                                $total = 0;
                                                foreach ($making as $paymt) {
                                                    $total += $paymt->bid->price;
                                                }
                                                echo number_format($total, 0, '', '.') . 'VNĐ';
                                            }
                                            ?>
                                            </b>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#sectionC">
                                            Lương tháng này  <br> 
                                            <b>
                                            <?php 
                                            if(!empty($job_thismonth)){
                                                $total = 0;
                                                foreach ($job_thismonth as $paymt) {
                                                    $total += $paymt->bid->price;
                                                }
                                                echo number_format($total, 0, '', '.') . 'VNĐ';
                                            }
                                            ?>
                                            </b>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#sectionD">
                                            Tổng lương đã nhận  <br> 
                                            <b>
                                            <?php 
                                            if(!empty($completed)){
                                                $total = 0;
                                                foreach ($completed as $paymt) {
                                                    $total += $paymt->bid->price;
                                                }
                                                echo number_format($total, 0, '', '.') . 'VNĐ';
                                            }
                                            ?>
                                            </b>
                                        </a>
                                    </li>
                                     
                                </ul>
                                <div class="tab-content">
                                    <div id="sectionA" class="tab-pane fade in active">
                                        <p>Danh sách dự án đang làm </p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Tên dự án</th>
                                                        <th>Trạng thái</th>
                                                        <th>Ngày giao việc </th>
                                                        <th>Ngày bắt đầu</th>
                                                        <th>Chủ dự án </th>
                                                        <th class="text-right">Ngân sách dự án</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if (!empty($making)) {
                                                    foreach ($making as $value) {
                                                        $job = $value->job;
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?=$job->getStatus($job->_id);?></td>
                                                        <td><?= date('d/m/Y', $job->assignment->created_at) ?></td>
                                                        <td><?= date('d/m/Y', $job->assignment->startday) ?></td>
                                                        <td><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $job->user->slug) ?>"><b><?= $job->user->name ?></b></a></td>
                                                        <td class="text-right"><?= number_format($job->assignment->bid->price, 0, '', '.') . ' VNĐ' ?></td>
                                                    </tr>
                                                <?php }}?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="sectionC" class="tab-pane fade">
                                        <p>Công việc bạn đã hoàn thành trên hệ thống Giaonhanviec.com</p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Tên dự án</th>
                                                        <th>Trạng thái</th>
                                                        <th>Ngày giao việc </th>
                                                        <th>Ngày bắt đầu</th>
                                                        <th>Ngày kết thúc</th>
                                                        <th>Chủ dự án </th>
                                                        <th class="text-right">Ngân sách dự án</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                if (!empty($job_thismonth)) {
                                                    foreach ($job_thismonth as $val) {
                                                        $month = $val->job;
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $month->slug . '/' . (string) $month->_id) ?>"><b><?= $month->name ?></b></a>
                                                            <p class="text-gray"><?= $month->category->name ?></p>
                                                        </td>
                                                        <td><?=$month->getStatus($month->_id);?></td>
                                                        <td><?= date('d/m/Y', $month->assignment->created_at) ?></td>
                                                        <td><?= date('d/m/Y', $month->assignment->startday) ?></td>
                                                        <td><?= date('d/m/Y', $month->assignment->endday) ?></td>
                                                        <td><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $month->user->slug) ?>"><b><?= $month->user->name ?></b></a></td>
                                                        <td class="text-right"><?= number_format($month->assignment->bid->price, 0, '', '.') . ' VNĐ' ?></td>
                                                    </tr>
                                                    
                                                <?php }}?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="sectionD" class="tab-pane fade">
                                        <p>Công việc bạn đã hoàn thành trên hệ thống Giaonhanviec.com</p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Tên dự án</th>
                                                        <th>Trạng thái</th>
                                                        <th>Ngày giao việc </th>
                                                        <th>Ngày bắt đầu</th>
                                                        <th>Ngày kết thúc</th>
                                                        <th>Chủ dự án </th>
                                                        <th class="text-right">Ngân sách dự án</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                if (!empty($completed)) {
                                                    foreach ($completed as $value) {
                                                        $job = $value->job;
                                                ?>    
                                                    <tr>
                                                        <td>
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a>
                                                            <p class="text-gray"><?= $job->category->name ?></p>
                                                        </td>
                                                        <td><?=$job->getStatus($job->_id);?></td>
                                                        <td><?= date('d/m/Y', $job->assignment->created_at) ?></td>
                                                        <td><?= date('d/m/Y', $job->assignment->startday) ?></td>
                                                        <td><?= date('d/m/Y', $job->assignment->endday) ?></td>
                                                        <td><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $job->user->slug) ?>"><b><?= $job->user->name ?></b></a></td>
                                                        <td class="text-right"><?= number_format($job->assignment->bid->price, 0, '', '.') . ' VNĐ' ?></td>
                                                    </tr>
                                                <?php }}?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- End introduce -->