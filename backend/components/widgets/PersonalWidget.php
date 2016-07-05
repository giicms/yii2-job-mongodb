<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\db\Query;
use common\models\User;
use yii\widgets\Menu;

class PersonalWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        if (!Yii::$app->user->isGuest) {
            
                            echo Menu::widget([
                                'items' => [
                                    ['label' => 'Công việc của tôi', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['membermanage/index']), 'visible' => Yii::$app->user->identity->role == User::ROLE_MEMBER, 'options' => ['class' => 'nav-item']],
                                    ['label' => 'Lưu việc', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['membermanage/savejob']), 'visible' => Yii::$app->user->identity->role == User::ROLE_MEMBER, 'options' => ['class' => 'nav-item']],
                                    ['label' => 'Thông tin cá nhân', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['membership/profile']), 'visible' => Yii::$app->user->identity->role == User::ROLE_MEMBER, 'options' => ['class' => 'nav-item']],
                                    ['label' => 'Kiểm tra bài test', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['test/index']), 'visible' => Yii::$app->user->identity->role == User::ROLE_MEMBER, 'options' => ['class' => 'nav-item']],
                                    ['label' => 'Công việc của tôi', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['bossmanage/jobmanage']), 'visible' => Yii::$app->user->identity->role == User::ROLE_BOSS, 'options' => ['class' => 'nav-item']],
                                    ['label' => 'Đăng việc', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['job/create']), 'visible' => Yii::$app->user->identity->role == User::ROLE_BOSS, 'options' => ['class' => 'nav-item']],
                                    ['label' => 'Danh sách lưu nhân viên', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['bossmanage/member']), 'visible' => Yii::$app->user->identity->role == User::ROLE_BOSS, 'options' => ['class' => 'nav-item']],
                                    ['label' => 'Thông tin cá nhân', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['boss/profile']), 'visible' => Yii::$app->user->identity->role == User::ROLE_BOSS, 'options' => ['class' => 'nav-item']],
                                    ['label' => 'Tin nhắn', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['messages/index']), 'options' => ['class' => 'nav-item']],
                                    ['label' => 'Lịch sử thanh toán', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['paymenthistory/paymenthistory']), 'visible' => Yii::$app->user->identity->role == User::ROLE_BOSS, 'options' => ['class' => 'nav-item']],
                                ],
                                'options' => ['class' => 'nav-list list-unstyled']
                            ]);
                          
        }
    }

}
