<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<div class="col-md-12">
    <div class="col-middle">
        <div class="text-center text-center">
            <h1 class="error-number"><?= Html::encode($this->title) ?></h1>
            <p> <?= nl2br(Html::encode($message)) ?></p>
          
        </div>
    </div>
</div>