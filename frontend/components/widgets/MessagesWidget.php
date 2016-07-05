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
use common\models\Conversation;

class MessagesWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        $model = Conversation::find()->where(['actor' => (string) Yii::$app->user->identity->id])->orderBy(['created_at' => SORT_DESC])->limit(20)->all();
        $active = Conversation::find()->where(['actor' => (string) Yii::$app->user->identity->id, 'active' => 1])->all();
        ?>
        <div class="btn-group btn-notify">
            <button type="button" class="btn btn-default dropdown-toggle btn-messages" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-envelope-o"></i>
                <span class="mact">
                    <?php
                    if (!empty($active))
                        echo '<i class="fa fa-circle text-red"></i>';
                    ?>
                </span>
            </button>

            <ul class="dropdown-menu">
                <li class="text-notify">Tin nhắn</li>
                <li>

                    <div class="scroll-messages scrollTo" style="max-height: 450px;">
                        <ul class="messages-bar">
                            <?php
                            if (!empty($model)) {
                                foreach ($model as $value) {
                                    ?>
                                    <li>
                                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('tin-nhan/' . $value->owners->slug . '?notify=' . (string) $value->_id) ?>"  class="<?= $value->status == 2 ? "active" : "" ?>">
                                            <img class="avatar-32" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($value->owners->avatar) ? '150-' . $value->owners->avatar : "avatar.png" ?>">
                                            <div class="not-inf">
                                                <?= $value->owners->name . ' đã nhắn tin "' . $value->content . '".' ?>
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
                    <input type="hidden" id="page-messages" value="2">
                    <div class="load-messages"></div>
                </li>
                <?php
                if (!empty($model)) {
                    ?>
                    <li class="text-center notify-all"><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('tin-nhan') ?>">Xem tất cả </a></li>
                    <?php }
                    ?>

            </ul>

        </div>
        <?php
    }

}
?>
