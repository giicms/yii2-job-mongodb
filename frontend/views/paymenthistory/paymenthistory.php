<?php 
use common\models\Job;
use common\models\Assignment;
use common\models\PaymentHistory;
?>
<!-- introduce -->
        <section>
            <div class="introduce payment-history">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <div class="title-container">
                                <h3>Trang thanh toán  </h3>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="list-project">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#sectionA">
                                            Dự án chờ đặt cọc <br> 
                                            <b>
                                            <?php 
                                            if(!empty($deposit)){
                                                $total = 0;
                                                foreach ($deposit as $depos) {
                                                    $deposit_price = $depos->category->deposit;
                                                    if ($deposit_price > 0 && $deposit_price <100) {
                                                        $price = $depos->assignment->bid->price * $deposit_price / 100;
                                                    }else{
                                                        $price = $depos->assignment->bid->price;
                                                    }
                                                    $total += $price;
                                                }
                                                echo number_format($total, 0, '', '.') . 'VNĐ';
                                            }
                                            ?>
                                            </b>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#sectionB">
                                            Đề nghị thanh toán <br> 
                                            <b>
                                            <?php 
                                            if(!empty($payment)){
                                                $total = 0;
                                                foreach ($payment as $paymt) {
                                                    $deposit_price = $paymt->category->deposit;
                                                    if (($deposit_price > 0)&&($deposit_price < 100)){
                                                        $price = $paymt->assignment->bid->price - $paymt->assignment->deposit->value;
                                                    }
                                                    if (($deposit_price == 0)&&(empty($deposit_price))) {
                                                        $price = $paymt->assignment->bid->price;
                                                    }
                                                    $total += $price;
                                                }
                                                echo number_format($total, 0, '', '.') . 'VNĐ';
                                            }
                                            ?>
                                            </b>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#sectionC">
                                            Lịch sử thanh toán <br> 
                                            <b>
                                            <?php
                                            if(!empty($payment_history)){
                                                $total =0;
                                                foreach($payment_history as $val){ 
                                                    $total += $val->value;
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
                                        <p>Danh sách dự án đang chờ thanh toán để công việc có thể bắt đầu ngay </p>
                                        <div class="table-responsive">
										<?php if(!empty($deposit)){?>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Tên dự án</th>
                                                        <th>Trạng thái</th>
                                                        <th>Ngày giao việc</th>
                                                        <th>Nhân viên</th>
                                                        <th>Ngân sách dự án</th>
                                                        <th>Đặt cọc</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                    if(!empty($deposit)){
                                                        foreach ($deposit as $depos) {
                                                ?>    
                                                    <tr>
                                                        <td>
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $depos->slug . '/' . (string) $depos->_id) ?>"><b><?=$depos->name?></b></a>
                                                            <p class="text-gray"><?=$depos->category->name;?></p>
                                                        </td>
                                                        <td><?=$depos->getStatus($depos->_id); ?></td>
                                                        <td><?=date('d/m/Y', $depos->assignment->created_at)?></td>
                                                        <td><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $depos->assignment->user->slug) ?>"><b><?=$depos->assignment->user->name; ?></b></a></td>
                                                        <td><?=number_format($depos->assignment->bid->price, 0, '', '.'); ?> VNĐ</td>
                                                        <td>
                                                            <?php 
                                                            $deposit_price = $depos->category->deposit;
                                                            if ($deposit_price > 0) {
                                                                 echo number_format($depos->assignment->bid->price * $deposit_price / 100, 0, '', '.') . 'VNĐ (' . $depos->assignment->bid->job->category->deposit . '%)';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $depos->slug . '/' . (string) $depos->_id) ?>" class="btn btn-blue">Đặt cọc </a>
                                                        </td>
                                                    </tr>
                                                <?php }}?>
                                                </tbody>
                                            </table>
										<?php }?>	
                                        </div>
                                    </div>
                                    <div id="sectionB" class="tab-pane fade">

                                        <p>Các dự án đã hoàn thành, hãy thanh toán để nghiệm thu và kết thúc công việc</p>
                                        <div class="table-responsive">
										<?php if(!empty($payment)){?>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Tên dự án</th>
                                                        <th>Trạng thái </th>
                                                        <th>Ngày giao việc </th>
                                                        <th>Nhân viên</th>
                                                        <th>Thanh toán</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                    if(!empty($payment)){
                                                        foreach ($payment as $paymt) {
                                                ?>    
                                                    <tr>
                                                        <td>
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $paymt->slug . '/' . (string) $paymt->_id) ?>"><b><?=$paymt->name?></b></a>
                                                            <p class="text-gray">Thiết kế đồ họa</p>
                                                        </td>
                                                        <td><?=$paymt->getStatus($paymt->_id); ?></td>
                                                        <td><?=date('d/m/Y', $paymt->assignment->created_at)?></td>
                                                        <td><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $paymt->assignment->user->slug) ?>"><b><?=$paymt->assignment->user->name; ?></b></a></td>
                                                        <td><?=number_format($paymt->assignment->bid->price, 0, '', '.'); ?> VNĐ</td>
                                                        <td>
                                                            <?php 
                                                            $deposit_price = $paymt->category->deposit;
                                                            if (($deposit_price > 0)&&($deposit_price < 100)) {?>
                                                            <?= number_format($paymt->assignment->bid->price - $paymt->assignment->deposit->value, 0, '', '.') ?>VNĐ
                                                            <?php }
															if (($deposit_price == 0)&&(empty($deposit_price))) {?>
															<?= number_format($paymt->assignment->bid->price, 0, '', '.') ?>VNĐ
															<?php }?>
															
                                                        </td>
                                                        <td class="text-right">
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $paymt->slug . '/' . (string) $paymt->_id) ?>" class="btn btn-blue">Thanh toán</a>
                                                        </td>
                                                    </tr>
                                                <?php }}?>
                                                </tbody>
                                            </table>
										<?php }?>	
                                        </div>
                                    </div>
                                    <div id="sectionC" class="tab-pane fade">
                                        <p>Danh sách các công việc bạn đã hoàn thành trên hệ thống Giaonhanviec.com</p>
                                        <div class="table-responsive">
										<?php if(!empty($payment_history)){?>
                                            <table class="table">
                                                <thead>
                                                    <tr><th>Thời gian</th><th>Số tiền</th><th>Lý do</th></tr>
                                                </thead>
                                                <tbody>
												<?php
													foreach($payment_history as $val){ 
												?>
                                                    <tr>
                                                        <td><?=date('H:i', $val->updated_at);?> Ngày <?=date('d/m/Y', $val->updated_at);?></td>
                                                        <td><?= number_format($val->value, 0, '', '.') ?>VNĐ</td>
                                                        <td>
														<?php 
															if($val->resion == PaymentHistory::RES_DEPOSIT){?>
																<p>Đặt cọc công việc <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $val->assignment->bid->job->slug . '/' . (string) $val->assignment->bid->job->_id) ?>">"<?=$val->assignment->bid->job->name?>"</a></p>
														<?php	}
															if($val->resion == PaymentHistory::RES_PAYMENT){?>
																<p>Thanh toán công việc <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $val->assignment->bid->job->slug . '/' . (string) $val->assignment->bid->job->_id) ?>">"<?=$val->assignment->bid->job->name?>"</a></p>
														<?php	}
														?>
														</td>
                                                    </tr>
												<?php }?>
                                                </tbody>
                                            </table>
										<?php }?>	
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
