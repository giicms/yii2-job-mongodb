<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use common\models\User;
use common\models\Job;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lí đánh giá';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ ĐÁNH GIÁ
                <!-- <small>
                    Some examples to get you started
                </small> -->
            </h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Top thành viên được đánh giá cao nhất</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?php 
                        Pjax::begin([
                            'id' => 'pjax_gridview_job'
                        ]);
                    ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' =>['id' => '','class' => ' table table-striped responsive-utilities jambo_table bulk_action'],
                        'rowOptions'=>function ($model, $key, $index, $grid){
                            $class=$index%2?'odd':'even';
                            return array('index'=>$index,'class'=>$class.' pointer');
                        },
                        'options'=>['class'=>'grid-view table-responsive'],
                        'columns' => [
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'multiple' => true,
                            ],
                            [   
                                'class' => 'yii\grid\SerialColumn'
                            ],
                            
                            [
                                'label' => 'Thành viên',
                                'attribute' => 'name',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return Html::a('<img class="avatar" style="width:45px;height:45px;margin-right:10px"  src="'.Yii::$app->params['url_file'].'/thumbnails/60-'.$data->avatar.'"/>', ['member/view', 'id'=>$data->_id]).Html::a('<b>'.$data->name.'</b>', ['member/view', 'id'=>$data->_id]).'<br><span><i class="fa fa-map-marker"></i>'.$data->location->name.', '.$data->location->city->name.'</span>';
                                },
                                        //'headerOptions' => ['class' => 'sorting'],
                            ],
                            [
                                'label' => 'Đánh giá',
                                'attribute' => 'rating',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return '<div class="rating-star">
                                                '.$data->getPoint($data->_id).'
                                                <span class="star text-yellow">
                                                    '.$data->getRating((string)$data->_id).'
                                                </span>
                                            </div>
                                            <div class="total">
                                                <i class="fa fa-user"></i>'.$data->getCountReview($data->_id).' Lượt đánh giá 
                                            </div>';
                                },
                                        //'headerOptions' => ['class' => 'sorting'],
                            ],
                            [
                                'label' => '',
                                'attribute' => 'rating',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return '<a href="/review/view/'.$data->_id.'" title="Xem"><i class="fa fa-eye"></i></a>';
                                },
                                        //'headerOptions' => ['class' => 'sorting'],
                            ],
                        ],    
                    ]); ?>
                    <?php  
                        Pjax::end();
                    ?>

                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Những đánh giá mới nhất</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="tableNotexport" class="table table-striped responsive-utilities jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                                <th>Stt</th>
                                <th>Reviewer</th>
                                <th>Rating</th>
                                <th>Công việc</th>
                                <th class=" no-link last"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($review as $key => $value) {
                                    if($value->user->role == 'boss'){ $link = 'boss';}else{ $link = 'member';}
                                    if($value->findowner->role == 'boss'){ $link2 = 'boss';}else{ $link2 = 'member';}
                            ?>
                            <tr>
                                <td><?=$key+1?></td>
                                <td>
                                    <a href="/<?=$link?>/view/<?=$value->user->_id?>"><img class="avatar" src="<?=Yii::$app->params['url_file'].'/thumbnails/60-'.$value->user->avatar?>"/></a>
                                    <a href="/<?=$link2?>/view/<?=$value->findowner->_id?>"><img class="avatar" src="<?=Yii::$app->params['url_file'].'/thumbnails/60-'.$value->findowner->avatar?>"/></a>
                                </td>
                                <td>
                                    <span class="star text-yellow"><?=$value->user->getRating((string)$value->user->_id)?></span>
                                    <small><?=date('H:i d-m-Y', $value->created_at)?></small>
                                    <p><?=$value->comment?></p>
                                </td>
                                <td><a href="/job/view/<?=$value->findAssignment->job->_id?>"><?=$value->findAssignment->job->name?></a></td>
                                <td><a href="#" title="Xem"><i class="fa fa-eye"></i></a> - <a href="#" title="Sửa"><i class="fa fa-edit fa-lg"></i></a> - <a href="#" title="Xóa"><i class="fa fa-trash-o fa-lg"></i></a></td>
                            </tr>
                            <?php
                                }
                            ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>        


