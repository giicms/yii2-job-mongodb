<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'Không tìm thấy trang này.';
?>
<section>
    <div class="introduce">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <h1><?= Html::encode($this->title) ?></h1>

                    <div class="alert alert-danger">
                        <?= nl2br(Html::encode($message)) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>