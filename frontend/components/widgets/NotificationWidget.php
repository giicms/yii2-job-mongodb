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
use common\models\Notification;

class NotificationWidget extends Widget
{

    public function init()
    {
        
    }

    public function run()
    {
        $notify = Notification::find()->where(['actor' => (string) Yii::$app->user->identity->id])->orderBy(['created_at' => SORT_DESC])->limit(10)->all();
        $active = Notification::find()->where(['actor' => (string) Yii::$app->user->identity->id, 'active' => 1])->all();
        ?>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell-o"></i>
                <span class="notify-active">
                    <?php
                    if (!empty($active))
                        echo '<i class="fa fa-circle text-red"></i>';
                    ?>
                </span>
            </button>

            <ul class="dropdown-menu">
                <li class="text-notify">Thông báo</li>
                <li>

                    <div class="scroll-notify scrollTo" style="max-height: 450px;">
                        <ul class="notify-bar">
                            <?php
                            if (!empty($notify))
                            {

                                foreach ($notify as $value)
                                {

                                    if ($value->type == 'job')
                                    {
                                        $url = Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $value->job->slug . '-' . (string) $value->job->_id . '?notify=' . (string) $value->_id);
                                    }
                                    else
                                    {
                                        $url = Yii::$app->urlManager->createAbsoluteUrl('user/' . $value->user->slug . '?notify=' . (string) $value->_id);
                                    }
                                    ?>
                                    <li>
                                        <a href="<?= $url ?>" class="<?= $value->status == 2 ? "active" : "" ?>">
                                            <img class="avatar-32" src="<?= Yii::$app->setting->value('url_file') ?>/thumbnails/150-<?= $value->user->avatar ?>">
                                            <div class="not-inf">
                                                <?= $value->content ?>
                                                <p><i class="fa fa-commenting"></i><small><?= Yii::$app->convert->time($value->created_at) ?></small></p>
                                            </div>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>

                    </div>
                    <input type="hidden" id="page-notify" value="2">
                    <div id="loadding"></div>
                </li>
                <!--                    <li class="text-center notify-all"><a href="#">Xem tất cả </a></li>-->

            </ul>

        </div>
        <?php
    }

}
?>
