<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\db\Query;
use yii\widgets\Menu;
use common\models\User;

class SidebarWidget extends Widget
{

    public function init()
    {
        
    }

    public function run()
    {
        if (!Yii::$app->user->isGuest)
        {
            ?>
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;padding:15px 10px 15px 0;">
                    <a href="http://<?= $_SERVER['HTTP_HOST'] ?>" class="site_title">
                        <?= Html::img('/images/giaonhanviec.png', ['alt' => 'giao nhận việc', 'class' => 'img-responsive']); ?>
                    </a>
                    <a href="http://<?= $_SERVER['HTTP_HOST'] ?>" class="site_title site_title_sm">
                        <?= Html::img('/images/icon/favicon.png', ['alt' => 'giao nhận việc', 'class' => 'img-responsive']); ?>
                    </a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <?php
                        if (!empty(Yii::$app->user->identity->avatar))
                        {
                            echo '<img class="img-circle profile_img" width="150" src="' . Yii::$app->user->identity->avatar . '" alt="' . Yii::$app->user->identity->name . '">';
                        }
                        else
                        {
                            echo '<img class="img-circle profile_img" width="150" src="/images/icon/avatar.png" alt="' . Yii::$app->user->identity->name . '">';
                        }
                        ?>
                    </div>
                    <div class="profile_info">
                        <span>Xin chào,</span>
                        <h2><?= Yii::$app->user->identity->name ?></h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section ">
                        <?php
                        echo Menu::widget([
                            'items' => [
                                ['label' => '<i class="fa fa-tachometer"></i> Trang chủ', 'url' => ['site/index']],
                                ['label' => '<i class="fa fa-pencil-square-o"></i> Quản lý công việc <span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                                        ['label' => 'Danh mục', 'url' => ['/jobcategory/index'], 'visible' => \Yii::$app->user->can('/jobcategory/index')],
                                        ['label' => 'Thêm mới danh mục', 'url' => ['/jobcategory/create'], 'visible' => \Yii::$app->user->can('/jobcategory/create')],
                                        ['label' => 'Danh sách công việc', 'url' => ['/job/index'], 'visible' => \Yii::$app->user->can('/job/index')],
                                        ['label' => 'Danh sách skill', 'url' => ['/skill/index'], 'visible' => \Yii::$app->user->can('/skill/index')],
                                        ['label' => 'Danh sách gói', 'url' => ['/budgetpacket/index'], 'visible' => \Yii::$app->user->can('/budgetpacket/index')],
                                    ],
                                    'visible' => \Yii::$app->user->can('/job/*')
                                ],
                                ['label' => '<i class="fa fa-user"></i> Quản lý người dùng <span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                                        ['label' => 'Danh sách boss', 'url' => ['/boss/index'], 'visible' => \Yii::$app->user->can('/boss/index')],
                                        ['label' => 'Thêm mới boss', 'url' => ['/boss/create'], 'visible' => \Yii::$app->user->can('/boss/create')],
                                        ['label' => 'Danh sách nhân viên', 'url' => ['/member/index'], 'visible' => \Yii::$app->user->can('/member/index')],
                                        ['label' => 'Thêm mới', 'url' => ['/member/create'], 'visible' => \Yii::$app->user->can('/member/create')],
                                    ],
                                    'visible' => \Yii::$app->user->can('/boss/*') or \Yii::$app->user->can('/member/*')
                                ],
                                ['label' => '<i class="fa fa-user"></i> Quản lý book nhân viên', 'url' => ['bookuser/index'], 'visible' => \Yii::$app->user->can('/bookuser/*')],
                                ['label' => '<i class="fa fa-question-circle"></i> Quản lý hỗ trợ<span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                                        ['label' => 'Danh mục', 'url' => ['/category/index'], 'visible' => \Yii::$app->user->can('/category/index')],
                                        ['label' => 'Thêm mới danh mục', 'url' => ['/category/create'], 'visible' => \Yii::$app->user->can('/category/create')],
                                        ['label' => 'Danh sách', 'url' => ['/post/index'], 'visible' => \Yii::$app->user->can('/post/index')],
                                        ['label' => 'Thêm mới', 'url' => ['/post/create'], 'visible' => \Yii::$app->user->can('/post/create')],
                                    ],
                                    'visible' => \Yii::$app->user->can('/category/*') or \Yii::$app->user->can('/post/*')
                                ],
                                ['label' => '<i class="fa fa-thumb-tack"></i> Quản lý trang nội dung<span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                                        ['label' => 'Danh sách', 'url' => ['page/index'], 'visible' => \Yii::$app->user->can('/page/index')],
                                        ['label' => 'Thêm mới', 'url' => ['page/create'], 'visible' => \Yii::$app->user->can('/page/create')],
                                    ],
                                    'visible' => \Yii::$app->user->can('/page/*')
                                ],
                                ['label' => '<i class="fa fa-commenting"></i> Quản lý đánh giá', 'url' => ['review/index'], 'visible' => \Yii::$app->user->can('/statistical/review')],
                                ['label' => '<i class="fa fa-bar-chart"></i> Thống kê báo cáo <span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                                        ['label' => 'Công việc', 'url' => ['/statistical/job'], 'visible' => \Yii::$app->user->can('/statistical/job')],
                                        ['label' => 'Nhân viên', 'url' => ['/statistical/member'], 'visible' => \Yii::$app->user->can('/statistical/member')],
                                        ['label' => 'Boss', 'url' => ['/statistical/boss'], 'visible' => \Yii::$app->user->can('/statistical/boss')],
//                                        ['label' => 'Lịch sử thanh toán', 'url' => ['statistical/finacation'], 'visible' => \Yii::$app->user->can('/statistical/finacation')],
                                    ],
                                    'visible' => \Yii::$app->user->can('/statistical/*')
                                ],
                                ['label' => '<i class="fa fa-file-image-o"></i> Quản lý files', 'url' => ['/filemanager/index'], 'visible' => \Yii::$app->user->can('/filemanager/index')],
                                ['label' => '<i class="fa fa-picture-o"></i> Quản lý hình ảnh', 'url' => ['/gallery/index'], 'visible' => \Yii::$app->user->can('/gallery/index')],
                                ['label' => '<i class="fa fa-map-marker"></i> Quản lý địa điểm <span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                                        ['label' => 'Danh sách', 'url' => ['/city/index'], 'visible' => \Yii::$app->user->can('/city/index')],
                                        ['label' => 'Thêm mới', 'url' => ['/city/create'], 'visible' => \Yii::$app->user->can('/city/create')]
                                    ],
                                    'visible' => \Yii::$app->user->can('/city/*')
                                ],
                                ['label' => '<i class="fa fa-envelope"></i> Quản lý tin nhắn', 'url' => ['/messages/index'], 'visible' => \Yii::$app->user->can('/messages/index')],
                                ['label' => '<i class="fa fa-file"></i> Quản lý bài test <span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                                        ['label' => 'Danh sách', 'url' => ['/test/index'], 'visible' => \Yii::$app->user->can('/test/index')],
                                        ['label' => 'Thêm mới', 'url' => ['/test/create'], 'visible' => \Yii::$app->user->can('/test/create')]
                                    ],
                                    'visible' => \Yii::$app->user->can('/test/*') or \Yii::$app->user->can('/test/index')
                                ],
                                ['label' => '<i class="fa fa-user-secret"></i> Adminstrator <span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                                        ['label' => 'Danh sách', 'url' => ['/account/index'], 'visible' => \Yii::$app->user->can('/account/index')],
                                        ['label' => 'Thêm mới', 'url' => ['/account/create'], 'visible' => \Yii::$app->user->can('/account/create')],
                                    ],
                                    'visible' => \Yii::$app->user->can('/account/*')
                                ],
                                ['label' => '<i class="fa fa-share-alt-square"></i> Phân quyền <span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                                        ['label' => 'Quản lý role', 'url' => ['/role/index'], 'visible' => \Yii::$app->user->can('/role/index')],
                                        ['label' => 'Quản lý permission', 'url' => ['/permission/index'], 'visible' => \Yii::$app->user->can('/permission/index')],
                                        ['label' => 'Quản lý route', 'url' => ['route/index'], 'visible' => \Yii::$app->user->can('/route/index')]
                                    ],
                                    'visible' => \Yii::$app->user->can('/role/*') or \Yii::$app->user->can('/permission/*') or \Yii::$app->user->can('/route/*')
                                ],
                                ['label' => '<i class="fa fa fa-cogs"></i> Quản lý chung <span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                                        ['label' => 'Danh sách ngân hàng', 'url' => ['/bank/index'], 'visible' => \Yii::$app->user->can('/bank/index')],
                                        ['label' => 'Chi nhánh ngân hàng', 'url' => ['/bankbranch/index'], 'visible' => \Yii::$app->user->can('/bankbranch/index')],
                                        ['label' => 'Nhận xét của khách hàng', 'url' => ['/customer/index'], 'visible' => \Yii::$app->user->can('/customer/index')],
                                        ['label' => 'Cấp độ nhân viên', 'url' => ['/level/index'], 'visible' => \Yii::$app->user->can('/level/index')],
                                    ],
                                    'visible' => \Yii::$app->user->can('/bank/*') or \Yii::$app->user->can('/bankbranch/*') or \Yii::$app->user->can('/customer/*') or \Yii::$app->user->can('/level/*')
                                ],
                                ['label' => '<i class="fa fa-cog"></i> Cấu hình chung', 'url' => ['/setting/index'], 'visible' => \Yii::$app->user->can('/setting/index')],
                            ],
                            'encodeLabels' => false,
                            'submenuTemplate' => "\n<ul class='nav child_menu' style='display: none'>\n{items}\n</ul>\n",
                            'options' => array('class' => 'side-menu nav')
                        ]);
                        ?>

                    </div>


                </div>

            </div>
            <?php
        }
    }

}
