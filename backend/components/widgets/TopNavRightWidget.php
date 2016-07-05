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
use yii\widgets\Menu;
use common\models\User;
use common\models\Job;
use common\models\Assignment;

class TopNavRightWidget extends Widget
{

    public function init()
    {
        
    }

    public function run()
    {
        $jobs = Job::find()->where(['publish' => Job::PROJECT_PUBLISH])->count();
        $member = User::find()->where(['role' => User::ROLE_MEMBER])->andWhere(['NOT IN', 'step', [User::STEP_COMPLE, User::STEP_SUCCESS]])->count();
        $boss = User::find()->where(['role' => User::ROLE_BOSS])->andWhere(['NOT IN', 'step', [User::STEP_COMPLE, User::STEP_SUCCESS]])->count();
        $deposit = Assignment::find()->where(['status_boss' => Assignment::STATUS_GIVE])->count();
        $payment = Assignment::find()->where(['status_boss' => Assignment::STATUS_COMMITMENT])->count();
        ?>

        <div class="nav_menu">
            <nav class="" role="navigation">
                <div class="nav toggle">
                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <ul class="nav navbar-nav navbar-right">

                    <li>
                        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="<?= !empty(Yii::$app->user->identity->avatar) ? Yii::$app->user->identity->avatar : '/images/icon/avatar.png' ?>" alt=""><?= Yii::$app->user->identity->name ?>
                            <span class=" fa fa-angle-down"></span>
                        </a>
                        <?php
                        echo Menu::widget([
                            'encodeLabels' => false,
                            'items' => [
                                ['label' => 'Thông tin cá nhân', 'url' => ['account/profile']],
                                ['label' => '<i class="fa fa-sign-out pull-right"></i>  Thoát', 'url' => ['site/logout']],
                            ],
                            'options' => [
                                'class' => 'dropdown-menu dropdown-usermenu animated fadeInDown pull-right',
                            ],
                        ]);
                        ?>
                    </li>
                    <li>
                        <a href="/member/index?step=cd" class="info-number" title="Nhân viên chưa duyệt">
                            <span class="fa fa-user fa-2x"></span>
                            <span class="badge bg-green"><?= $member ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="/boss/index?step=cd" class="info-number" title="Người đăng việc chưa duyệt">
                            <span class="fa fa-user fa-2x"></span>
                            <span class="badge bg-green"><?= $boss ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="/job/index?publish=1" class="info-number" title="Công việc chưa duyệt">
                            <span class="fa fa fa-pencil-square-o fa-2x"></span>
                            <span class="badge bg-green"><?= $jobs ?></span>
                        </a>
                    </li>
                    <?php
//                        echo Menu::widget([
//                            'encodeLabels' => false,
//                            'items' => [
//                                ['label' => 'Nhân viên chưa duyệt <span class="badge bg-green pull-right">' . $member . '</span>', 'url' => ['member/index?step=cd'], 'visible' => \Yii::$app->user->can('/member/index')],
//                                ['label' => 'Người đăng việc chưa duyệt <span class="badge bg-green pull-right">' . $boss . '</span>', 'url' => ['boss/index?step=cd'], 'visible' => \Yii::$app->user->can('/boss/index')],
//                                ['label' => 'Công việc chưa duyệt <span class="badge bg-green pull-right">' . $jobs . '</span>', 'url' => ['job/index?publish=1'], 'visible' => \Yii::$app->user->can('/job/index')],
//                                ['label' => 'Công việc chưa đặt cọc <span class="badge bg-green pull-right">' . $deposit . '</span>', 'url' => ['job/index?publish=deposit'], 'visible' => \Yii::$app->user->can('/job/index')],
//                                ['label' => 'Công việc chưa thanh toán <span class="badge bg-green pull-right">' . $payment . '</span>', 'url' => ['job/index?publish=payment'], 'visible' => \Yii::$app->user->can('/job/index')],
//                            ],
//                            'options' => [
//                                'class' => 'dropdown-menu dropdown-usermenu animated fadeInDown pull-right',
//                                'style' => 'min-width: 250px'
//                            ],
//                        ]);
                    ?>


                </ul>
            </nav>
        </div>
        <?php
    }

}
?>