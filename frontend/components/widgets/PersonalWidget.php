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
use common\models\Bid;
use common\models\Level;
use common\models\User;
use yii\widgets\Menu;

class PersonalWidget extends Widget
{

    public function init()
    {
        
    }

    public function run()
    {

        $first_day = (int) \Yii::$app->convert->date(date('d/m/Y', strtotime(date('Y-m-01', strtotime("now")))));
        $last_day = (int) \Yii::$app->convert->date(date('t/m/Y'));
        $count_bid = Bid::find()->where(['between', 'created_at', $first_day, $last_day])->andWhere(['actor' => (string) Yii::$app->user->identity->id])->count();
        if (!Yii::$app->user->isGuest)
        {

            echo Menu::widget([
                'items' => [
                    ['label' => 'Công việc của tôi', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['membermanage/index']), 'visible' => Yii::$app->user->identity->role == User::ROLE_MEMBER, 'options' => ['class' => 'nav-item']],
                    ['label' => 'Lưu việc', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['membermanage/savejob']), 'visible' => Yii::$app->user->identity->role == User::ROLE_MEMBER, 'options' => ['class' => 'nav-item']],
                    ['label' => 'Danh sách khách hàng', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['membermanage/boss']), 'visible' => Yii::$app->user->identity->role == User::ROLE_MEMBER, 'options' => ['class' => 'nav-item']],
                    ['label' => 'Thông tin cá nhân', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['membership/profile']), 'visible' => Yii::$app->user->identity->role == User::ROLE_MEMBER, 'options' => ['class' => 'nav-item']],
                    ['label' => 'Kiểm tra bài test', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['test/index']), 'visible' => Yii::$app->user->identity->role == User::ROLE_MEMBER, 'options' => ['class' => 'nav-item']],
                    ['label' => 'Công việc của tôi', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['bossmanage/jobmanage']), 'visible' => Yii::$app->user->identity->role == User::ROLE_BOSS, 'options' => ['class' => 'nav-item']],
                    ['label' => 'Đăng việc', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['job/create']), 'visible' => Yii::$app->user->identity->role == User::ROLE_BOSS, 'options' => ['class' => 'nav-item']],
                    ['label' => 'Danh sách lưu nhân viên', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['bossmanage/member']), 'visible' => Yii::$app->user->identity->role == User::ROLE_BOSS, 'options' => ['class' => 'nav-item']],
                    ['label' => 'Danh sách book nhân viên', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['bossmanage/bookuser']), 'visible' => Yii::$app->user->identity->role == User::ROLE_BOSS, 'options' => ['class' => 'nav-item']],
                    ['label' => 'Thông tin cá nhân', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['boss/profile']), 'visible' => Yii::$app->user->identity->role == User::ROLE_BOSS, 'options' => ['class' => 'nav-item']],
                    ['label' => 'Tin nhắn', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['messages/index']), 'options' => ['class' => 'nav-item']],
                    ['label' => 'Lịch sử thanh toán', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['paymenthistory/paymenthistory']), 'visible' => Yii::$app->user->identity->role == User::ROLE_BOSS, 'options' => ['class' => 'nav-item']],
                    ['label' => 'Lịch sử lương', 'url' => Yii::$app->urlManager->createAbsoluteUrl(['paymenthistory/salarytable']), 'visible' => Yii::$app->user->identity->role == User::ROLE_MEMBER, 'options' => ['class' => 'nav-item']],
                ],
                'options' => ['class' => 'nav-list list-unstyled']
            ]);
            ?>
            <ul class="list-unstyled pull-right wallet">
                <?php
                if (Yii::$app->user->identity->role == User::ROLE_MEMBER)
                {
                    ?>
                    <li class="pull-right"><label class="label label-info"><i class="fa fa-inbox" aria-hidden="true"></i> <?= Yii::$app->user->identity->findlevel->count_bid - $count_bid . '/' . Yii::$app->user->identity->findlevel->count_bid ?></label></li>
                <?php } ?>    
                <li class="pull-right"><label class="label label-success"><i class="fa fa-usd" aria-hidden="true"></i> <?= number_format(Yii::$app->user->identity->wallet, 0, '', '.'); ?> vnđ</label></li>
            </ul>
            <?php
        }
    }

}
