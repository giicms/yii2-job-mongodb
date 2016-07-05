<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng việc';
$this->params['breadcrumbs'][] = $this->title;
?>
<section>
    <div class="introduce published_work">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-container">
                        <h3>Đăng việc > Xem trước</h3>
                    </div>
                </div>
                <!-- introduce item -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>  
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tiêu đề công việc</label>
                        <div class="col-sm-6">
                            <?= $model->name ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Thuộc danh mục công việc</label>
                        <div class="col-sm-6">
                            <?= $model->category->name ?>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Mô tả nôi dung công việc</label>
                        <div class="col-sm-9">
                            <?= nl2br($model->description) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Ngân sách cho dự án</label>
                        <div class="col-sm-6">
                            <?php
                            echo 'Từ ' . number_format($model->budget->min, 0, '', '.') . ' đến ' . number_format($model->budget->max, 0, '', '.') . ' VNĐ';
                            ?>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Thời gian kết thúc nhận việc</label>
                        <div class="col-sm-3">
                            <?= date('d/m/Y', $model->deadline) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Chế độ nhân viên</label>
                        <div class="col-sm-6">
                            <?= $model->findlevel->name ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Số lượng nhân viên</label>
                        <div class="col-sm-2">
                            <?= $model->num_bid ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">File đính kèm</label>
                        <div class="col-sm-3">
                            <?= count($model->file)
                            ?> File đính kèm
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="submit-form-boss">
                                <button type="submit" class="btn btn-blue" name="post-work">Đăng việc</button>
                                <button type="submit" class="btn btn-square" name="save-draft">Lưu nháp</button>
                                <?= Html::a('Sửa dổi', ['update', 'id' => (string) $model['_id']]) ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>    
            </div>
        </div>
    </div>
</section>
<!-- End introduce -->
