<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\Menu;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý yêu cầu';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ YÊU CẦU
                <!-- <small>
                    Some examples to get you started
                </small> -->
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách đã xóa</h2>
                    <?php
                    echo Menu::widget([
                        'items' => [
                            ['label' => 'Danh sách', 'template' => '<a href="{url}">{label}</a>', 'url' => [ 'index'], 'visible' => \Yii::$app->user->can('/sectoroption/index')],
                            ['label' => 'Thêm mới', 'template' => '<a href="{url}" class="btn-success">{label}</a>', 'url' => [ 'create'], 'visible' => \Yii::$app->user->can('/sectoroption/create')]
                        ],
                        'options' => [ 'class' => 'nav navbar-right panel_toolbox'],
                    ]);
                    ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                    GridView::widget([
                        'id' => 'sectoroption',
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'columns' => [
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'multiple' => true,
                            ],
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'name',
                                'format' => 'html',
                                'value' => function ($data)
                                {

                                    return $data->name . '<br><small>' . $data->sector->name . '</small>';
                                },
                            ],
                            [
                                'label' => 'Yêu cầu',
                                'format' => 'html',
                                'value' => function ($data)
                                {
                                    $options = $data->options;
                                    $html = '';
                                    if (!empty($options))
                                    {
                                        foreach ($options as $value)
                                        {
                                            $html .= $value . '<br>';
                                        }
                                    }
                                    return $html;
                                },
                            ],
                            [
                                'class' => 'backend\components\columns\ActionColumn',
                                'template' => '{update}',
                            ],
                        ],
                        'tableOptions' => ['class' => 'table table-striped responsive-utilities jambo_table bulk_action'],
                    ]);
                    ?>
                    <?= Html::a("Xóa", "javascript:void(0)", ["class" => "btn_delete_multiple btn btn-danger"]) ?> 

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->registerJs('
    $(".btn_delete_multiple").click(function () {
    var keys = $("#sectoroption").yiiGridView("getSelectedRows");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có muốn xóa các mẫu tin này không (s)");
        }
     if (msg == true) {
     if(keys!=""){
      var url = "' . Yii::$app->urlManager->createUrl(["sectoroption/remove"]) . '";  
        window.location.href = url + "/?id=" + keys;  
         }
    }
    return false;
});
');
?>