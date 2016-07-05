<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng việc';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=

$this->render('_form', ['model' => $model, 'options' => $options, 'budget' => $budget, 'sector' => $sector])?>