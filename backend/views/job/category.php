<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng việc';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="job-create">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $this->title ?></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_content">
                    <?php
                    foreach ($category as $value)
                    {
                        ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label><?= $value->name ?></label>
                            <?php
                            $sector = $value->sectors;
                            if (!empty($sector))
                            {
                                foreach ($sector as $value)
                                {
                                    ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12"><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/create', 'id' => $value->id]) ?>"><?= $value->name ?></a></div>
                                        <?php
                                    }
                                }
                                ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
