<?php

namespace common\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class IframeAutoHeight
 *
 * This widget generates an iframe object in the dom that adjusts it's height automatically based on the height of the
 * iframes content. The result is that it looks like the iframe content is normal page content, it won't look like 
 * there is an iframe at all.
 * 
 * Note, this only works on iframes on the same domain.
 *
 * Usage:
 *
 * echo IframeAutoHeight::widget([
 *     'intervalTime' => 500,
 *     'noIframeSupportText' => 'Your browser does not support iframes.',
 *     'iframeOptions' => [
 *         'id' => 'my-iframe',
 *         'src' => 'http://mydomain.com/iframe.html',
 *         'width' => '100%',
 *         'height' => '500px',
 *         'frameborder' => '0',
 *         'scrolling' => 'no'
 *     ]
 * ]);
 */
class Iframe extends Widget {

    /**
     * @var int the interval time in milliseconds to check the iframes content height and setting it on the iframe.
     */
    public $intervalTime = 1000;

    /**
     * @var array the HTML tag attributes (HTML options) in terms of name-value pairs.
     */
    public $iframeOptions = [];

    /**
     * @var string to show when iframes are not supported in the client browser.
     */
    public $noIframeSupportText = '';

    /**
     * Initialize the widget.
     */
    public function init() {
        parent::init();

        if (!isset($this->iframeOptions['id'])) {
            throw new InvalidConfigException('The "id" property must be set in iframeOptions.');
        }

        $this->registerAssets();
    }

    /**
     * Executes the widget.
     */
    public function run() {
        parent::run();

        echo Html::tag('iframe', $this->noIframeSupportText, $this->iframeOptions);
    }

    /**
     * Registers the necessary js.
     */
    protected function registerAssets() {
        $js = "
        $('#" . $this->iframeOptions['id'] . "').load(function () {
            setInterval(function(){
                $('#" . $this->iframeOptions['id'] . "').height($('#" . $this->iframeOptions['id'] . "').contents().height());
            }, " . $this->iframeOptions['id'] . ");
        });";

        $this->getView()->registerJs($js);
    }

}
