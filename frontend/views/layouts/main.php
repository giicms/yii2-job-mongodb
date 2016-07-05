<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\components\widgets\PersonalWidget;
use frontend\components\widgets\NotificationWidget;
use frontend\components\widgets\MessagesWidget;
use frontend\components\widgets\CounterWidget;
use frontend\components\widgets\OnlinedailyWidget;
use common\models\User;
use common\models\Posts;
use yii\widgets\Menu;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="shortcut icon" href="<?= Yii::$app->urlManager->createAbsoluteUrl('/images/icon/favicon.ico') ?>">
        <meta id="metaDes" content="<?= Yii::$app->setting->value("site_description"); ?>" name="description">
        <meta id="metakeywords" content="<?= Yii::$app->setting->value("site_key"); ?>" name="keywords">
        <?php $this->head() ?>
    </head>
    <body >
        <?php $this->beginBody() ?>
        <?= OnlinedailyWidget::widget(); ?>
        <?= CounterWidget::widget() ?>
        <div id="outer-wrap">
            <div id="inner-wrap">
                <header>
                    <div class="container header-top">
                        <div class="row">
                            <div class="div-responsive  col-sm-2 col-xs-2">
                                <div class="menu-responsive">
                                    <a class="nav-btn" id="nav-open-btn" href="#nav"><i class="fa fa-bars"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-8 col-xs-8 logo">
                                <h1>
                                    <a href="<?= 'http://' . $_SERVER['HTTP_HOST']; ?>" title="giao nhận việc">
                                        <?= Html::img(Yii::$app->urlManager->createAbsoluteUrl('/images/giaonhanviec.png'), ['alt' => 'giao nhận việc']); ?>
                                        <div class="clear-fix"></div>
                                    </a>
                                </h1>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 menu-main">
                                <nav>
                                    <ul class="list-unstyled">
                                        <li>         
                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['membership/index']) ?>">danh sách nhân viên <i class="fa fa-angle-down"></i></a>
                                        </li>
                                        <li>
                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/index']) ?>">danh sách công việc <i class="fa fa-angle-down"></i></a>
                                        </li>
                                        <li class="last-child"><a href="#" title="">tin tức</a></li>
                                        <div class="clear-fix"></div>
                                    </ul>
                                </nav>
                            </div>
                            <?php
                            if (\Yii::$app->user->isGuest)
                            {
                                echo '<div class="col-md-3 col-sm-12 col-xs-12 login text-right">';
                                echo Html::a('<i class="fa fa-sign-in"></i>Đăng nhập', Yii::$app->urlManager->createAbsoluteUrl('/site/login'));
                                echo '</div>';
                            }
                            else
                            {
                                if (!empty(Yii::$app->user->identity->avatar))
                                    $avatar = Yii::$app->setting->value('url_file') . 'thumbnails/150-' . Yii::$app->user->identity->avatar;
                                else if (!empty(Yii::$app->user->identity->fbid))
                                    $avatar = '//graph.facebook.com/' . Yii::$app->user->identity->fbid . '/picture?type=large';
                                else
                                    $avatar = Yii::$app->setting->value('url_file') . 'avatar.png';
                                ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 top-bar">
                                    <ul class="list-unstyled">

                                        <li class="btn-account">
                                            <!-- Single button -->
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <?= Html::img($avatar, ["alt" => Yii::$app->user->identity->name, "class" => "fa avatar-16 img-circle"]); ?>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <div class="img-avatar">
                                                            <?= Html::img($avatar, ["alt" => Yii::$app->user->identity->name, "width" => "100", "class" => "avatar-16 img-circle"]); ?>
                                                        </div>
                                                        <div class="user-name">
                                                            <strong><?= Yii::$app->user->identity->name ?></strong><br>
                                                            <small><?= Yii::$app->user->identity->email ?></small><br>
                                                            <div>
                                                                <a class="btn btn-blue" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['user/info']) ?>">Tài khoản của tôi</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li role="separator" class="divider"></li>
                                                    <li>
                                                        <div class="col-sm-6">
                                                            <a class="btn" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['user/changepassword']) ?>"><i class="fa fa-key"></i>Thay đổi mật khẩu </a>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <?= Html::a('<i class="fa fa-sign-out"></i>Đăng xuất', ['site/logout'], ['class' => 'btn']); ?>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="btn-notify">
                                            <!-- button bell-->
                                            <?= NotificationWidget::widget() ?>
                                            <!--End button bell-->
                                        </li>
                                        <li>
                                            <?= MessagesWidget::widget() ?>
                                        </li>
                                        <li class="btn-search">
                                            <!-- button search-->
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-search"></i></button>
                                                <div class="dropdown-menu">
                                                    <form id="frmSearch" name="frmSearch" class="frm-search" action="#" method="post" accept-charset="utf-8">
                                                        <input class="txt-keysearch form-control" name="txt-keysearch" type="text" value="" placeholder="Tìm kiếm...">
                                                        <button type="submit" class="btn-search"><i class="fa fa-search"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                            <!--End button search-->
                                        </li>

                                    </ul>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    if (!\Yii::$app->user->isGuest)
                    {
                        ?>
                        <!-- menu personal -->
                        <div class="menu-personal">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <nav class="nav">
                                                <?= PersonalWidget::widget() ?>
                                            </nav>
                                            <!-- /Nav -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    <?php } ?> 
                </header>

                <?php
                if (\Yii::$app->user->isGuest)
                {
                    ?>
                    <nav id="nav" role="navigation">
                        <div class="block">
                            <a class="close-btn" id="nav-close-btn" href="#top"><i class="fa fa-times-circle"></i></a>
                            <ul>
                                <li class="is-active">
                                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['membership/index']) ?>">danh sách nhân viên</a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/index']) ?>">danh sách công việc</a>
                                </li>
                                <li>
                                    <a href="#">Tin tức</a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['site/login']) ?>"><i class="fa fa-sign-in"></i> Đăng nhập</a>
                                </li>
                            </ul>

                        </div>
                    </nav>
                    <?php
                }
                else
                {
                    ?>
                    <nav id="nav" role="navigation">
                        <div class="block">
                            <a class="close-btn" id="nav-close-btn" href="#top"><i class="fa fa-times-circle"></i></a>
                            <ul class="nav-responsive">
                                <li class="menutem">
                                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['membership/index']) ?>">danh sách nhân viên</a>
                                </li>
                                <li class="menutem">
                                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['job/index']) ?>">danh sách công việc</a>
                                </li>
                                <li class="menutem">
                                    <a href="#">Tin tức</a>
                                </li>
                                <li class="menutem">
                                    <a>Quản lý cá nhân </a>
                                    <?= PersonalWidget::widget() ?>
                                </li>
                                <li class="menutem">
                                    <?= Html::a('<i class="fa fa-sign-out"></i>Đăng xuất', ['site/logout']); ?>
                                </li>
                            </ul>

                        </div>
                    </nav>
                <?php } ?>

                <?= $content ?>
                <footer>
                    <div class="container">
                        <!-- slide partner -->
                        <div class="partners">
                            <h3>Được tin tưởng và sử dụng bởi nhiều khách hàng</h3>
                            <div id="owl-example" class="owl-carousel">
                                <?php
                                $partner = Posts::find()->where(['alias' => 'gal', 'category_id' => '56f4c722f0d125b22605c3f0', 'publish' => Posts::STATUS_ACTIVE])->orderBy(['updated_at' => SORT_DESC])->all();
                                if (!empty($partner))
                                {
                                    foreach ($partner as $value)
                                    {
                                        ?>
                                        <div class="item darkCyan">
                                            <img src="<?= $value->thumbnail; ?>" alt="<?= $value->name; ?>">
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <!-- End partner -->

                        <!-- footer top -->
                        <div class="footer-top">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <h4>về giaonhanviec.com</h4>
                                    <div>
                                        <ul class="list-unstyled">
                                            <li><?= Html::a('Giới thiệu', ['page/about']); ?></li>
                                            <li><a href="#">tin tức</a></li>

                                            <li><a href="/giao-nhan-viec#co-hoi-nghe-nghiep">tuyển dụng</a></li>
                                            <li><?= Html::a('điều khoản sử dụng', ['page/termsofuse']); ?></li>
                                            <li><?= Html::a('chính sách bảo mật', ['page/privacy']); ?></li>

                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <h4>dịch vụ bổ sung</h4>
                                    <div>
                                        <ul class="list-unstyled">
                                            <li><?= Html::a('Quản lí dự án', ['page/dich-vu-quan-ly-du-an']); ?></li>
                                        </ul>
                                    </div>
                                    <h4>liên hệ với chúng tôi</h4>
                                    <div>
                                        <ul class="list-unstyled">
                                            <li><a href="/giao-nhan-viec#lien-he">thông tin liên hệ</a></li>
                                            <li><?= Html::a('hỗ trợ - hướng dẫn', ['help/manual']); ?></li>
                                            <li><a href="/giao-nhan-viec#doi-tac">đối tác</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <h4>tìm theo danh mục</h4>
                                    <div>
                                        <ul class="list-unstyled">
                                            <li><a href="#">nhân viên theo ngành nghề</a></li>
                                            <li><a href="#">nhân viên theo năng lực</a></li>
                                            <li><a href="#">nhân viên ở miền bắc</a></li>
                                            <li><a href="#">nhân viên ở miền trung</a></li>
                                            <li><a href="#">nhân viên ở miền nam</a></li>
                                            <li><a href="#">tìm việc</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- End footer top -->

                        <!-- social -->
                        <div class="social">
                            <div class="social-box">
                                <ul class="list-unstyled">
                                    <li><a href="#" title=""><?= Html::img('/images/icon/facebook.png', ['alt' => 'facebook']); ?></a></li>
                                    <li><a href="#" title=""><?= Html::img('/images/icon/twinter.png', ['alt' => 'twinter']); ?></a></li>
                                    <li><a href="#" title=""><?= Html::img('/images/icon/google_plus.png', ['alt' => 'google_plus']); ?></a></li>
                                    <li><a href="#" title=""><?= Html::img('/images/icon/in.png', ['alt' => 'in']); ?></a></li>
                                    <div class="clear-fix"></div>
                                </ul> 
                            </div>
                        </div>
                        <!-- End social -->

                        <!-- copirignt -->
                        <div class="copiright text-center">
                            &copy; 2015 giaonhanviec.com
                        </div>
                    </div>
                </footer>


            </div>
        </div>
        <div class="scroll-top">
            <a id="Scrolltop" href="#" title="">
                <i class="fa fa-arrow-up"></i>
            </a>
        </div>

        <?= $this->registerJs('window._sbzq||function(e){e._sbzq=[];var t=e._sbzq;t.push(["_setAccount",10283]);var n=e.location.protocol=="https:"?"https:":"http:";var r=document.createElement("script");r.type="text/javascript";r.async=true;r.src=n+"//static.subiz.com/public/js/loader.js";var i=document.getElementsByTagName("script")[0];i.parentNode.insertBefore(r,i)}(window);') ?>

        <?php $this->endBody() ?>

        <script>
            $(document).ready(function ($) {
                $("#owl-example").owlCarousel({
                    items: 4,
                    autoPlay: true,
                    responsive: true
                });
            });
        </script>

        <script type="text/javascript">
<?php
if (!Yii::$app->user->isGuest)
{
    ?>
                window.setInterval(function () {
                    $.ajax({
                        url: '/client/server',
                        type: 'post',
                        success: function (data) {
                            if (data.set.length > 0) {
                                $('.notify-active').html('<i class=\"fa fa-circle text-red\"></i>');
                                //                                for (i = 0; i < data.set.length; i++) {
                                //                                    var item = data.set[i];
                                //                                    $.notify({
                                //                                        // options
                                //                                        icon: "fa fa-exclamation-triangle",
                                //                                        message: item.content
                                //                                    }, {
                                //                                        // settings
                                //                                        type: "danger"
                                //                                    });
                                //                                }
                            }
                            if (data.messages.length > 0) {
                                $('.mact').html('<i class=\"fa fa-circle text-red\"></i>');
                            }
                            return false;
                        }
                    });
                }, 1000);

<?php } ?>
        </script>
        <!-- scroll to top -->
        <script type="text/javascript">
            $(document).ready(function () {

                //Check to see if the window is top if not then display button
                $(window).scroll(function () {
                    if ($(this).scrollTop() > 300) {
                        $('.scroll-top').fadeIn();
                    } else {
                        $('.scroll-top').fadeOut();
                    }
                });

                //Click event to scroll to top
                $('#Scrolltop').click(function () {
                    $('html, body').animate({scrollTop: 0}, 500);
                    return false;
                });

            });
        </script>
        <script id="message-tmpl" type="text/x-jQuery-tmpl">
            <div class="media ">
            <div class="media-left">
            <a href="/membership/user/${data.conver.user_id}">
            <img class="img-circle avatar" width="50" src="${data.user.avatar}">
            </a>
            </div>
            <div class="media-body">
            <h4 class="media-heading">${data.user.name}</h4>
            <small>${data.conver.content}</small>
            </div>
            </div>
        </script>
        <script id="notify-tmpl" type="text/x-jQuery-tmpl">
            <li>
            <a href="${item.url"><img class="avatar-32" src=${item.avatar}>
            <div class="not-inf>${item.content}<p><i class="fa fa-commenting"></i><small>${item.created_at}</small></div>
            </a>
            </li>;
        </script>
        <script type='text/x-tmpl' id="list-messages">
            <div class="media ">
            <div class="media-left">
            <a href="${user_url}">
            <img class="avatar" width="50" src="${user_avatar}">
            </a>
            </div>
            <div class="media-body">
            <h4 class="media-heading">${user_name}</h4>
            <p style="font-size:13px; margin-bottom:5px">${content} <small class="pull-right">${user_time}</small></p>
            <div class="conversation_${order}"></div>
            <div class="conversation_last">
            <input type="hidden" name="conversation_owner" id="conversation_owner" value="${user_slug}">
            <input type="hidden" name="conversation_date" id="conversation_date" value="${date}">
            <input type="hidden" name="conversation_order" id="conversation_order" value="${order}">
            </div>
            </div>
            </div>
        </script>
        <script type='text/x-tmpl' id="messages-header">
            <a href="${user_url}" title="${user_name}"> <h4 class="title">${user_name}</h4></a>
            <p class="time">${message_date}</p>
        </script>
        <script>
            var markup = "<div class='media'>\n\
                   <div class='media-left'><a href='/user/${user_id}'><img class='img-circle avatar' width='50' src='${avatar}'></a></div>\n\
    <div class='media-body'><h4 class='media-heading'>${name}</h4><small>${content}</small></div></div>";
        </script>

    </body>
</html>
<?php $this->endPage() ?>
