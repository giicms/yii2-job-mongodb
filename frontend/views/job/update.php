<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;
?>

<?=

$this->render('_form', ['model' => $model, 'district' => $district, 'options' => $options, 'budget' => $budget, 'sector' => $sector])?>