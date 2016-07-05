
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AjaxAsset;

AjaxAsset::register($this);
?>
<?php $this->beginPage() ?>
<html lang="<?= Yii::$app->language ?>">
    <body>
        <?php
        $this->beginBody();
        echo $content;
        $this->endBody();
        ?>
    </body>
</html>
<?php $this->endPage() ?>