<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/style.css',
        'css/font.css',
        'css/jquery-ui.css',
        'font_awesome/css/font-awesome.min.css',
        'css/jquery.mCustomScrollbar.css',
        'css/owl.carousel.css',
        'css/icon.css',
        'css/slide_main_custom.css',
        'css/slide_main.css',
        'css/slider-pro.min.css',
        'css/slider-pro-examples.css',
        'css/menu-responsive.css',
        'css/select2.min.css',
        'css/bootstrap-select.css',
        'css/jquery.Jcrop.css',
        'css/jquery-sliding-menu.css',
        'css/responsive-tabs.css',
        'css/animate.min.css',
	'css/jquery.mmenu.all.css',
	'css/fontawesome-stars.css',
        'fancybox/jquery.fancybox.css',
        'fancybox/helpers/jquery.fancybox-buttons.css',
        'fancybox/helpers/jquery.fancybox-thumbs.css'
    ];
    public $js = [
        'js/jquery-ui.min.js',
        'js/modernizr.custom.js',
        'js/moment.js',
        'js/bootstrap.min.js',
        'js/jquery.tmpl.min.js',
        'js/bootstrap-select.js',
        'js/select2.min.js',
        'js/timecircles.js',
        'js/jquery.mCustomScrollbar.js',
        'js/jquery.textarea_autosize.min.js',
        'js/owl.carousel.min.js',
        'js/jquery.uploadfile.min.js',
        'js/jquery.ba-cond.min.js',
        'js/jquery.slitslider.js',
        'js/jquery.sliderPro.min.js',
        'js/jquery.Jcrop.js',
        'js/jquery.responsiveTabs.js',
        'js/jquery-sliding-menu.js',
        'js/bootstrap-notify.min.js',
        'js/tinymce/tinymce.min.js',
        'js/main.js',
	'js/jquery.mmenu.min.all.js',
	'js/jquery.barrating.js',
    	'js/rating-css.js',
        'fancybox/jquery.fancybox.js',
        'fancybox/helpers/jquery.fancybox-buttons.js',
        'fancybox/helpers/jquery.fancybox-thumbs.js',
        'fancybox/helpers/jquery.fancybox-media.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
