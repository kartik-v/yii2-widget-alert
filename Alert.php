<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2017
 * @package yii2-widgets
 * @subpackage yii2-widget-alert
 * @version 1.1.1
 */

namespace kartik\alert;

use Yii;
use yii\bootstrap\Alert as BsAlert;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Alert widget extends the [[BsAlert]] widget with an easier configuration and additional styling options including
 * auto fade out.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class Alert extends BsAlert
{
    /**
     * information alert
     */
    const TYPE_INFO = 'alert-info';
    /**
     * danger/error alert
     */
    const TYPE_DANGER = 'alert-danger';
    /**
     * success alert
     */
    const TYPE_SUCCESS = 'alert-success';
    /**
     * warning alert
     */
    const TYPE_WARNING = 'alert-warning';
    /**
     * primary alert
     */
    const TYPE_PRIMARY = 'bg-primary';
    /**
     * default alert
     */
    const TYPE_DEFAULT = 'well';
    /**
     * custom alert
     */
    const TYPE_CUSTOM = 'alert-custom';

    /**
     * @var string the type of the alert to be displayed. One of the `TYPE_` constants. Defaults to [[TYPE_INFO]].
     */
    public $type = self::TYPE_INFO;

    /**
     * @var string the icon type. Can be either 'class' or 'image'. Defaults to 'class'.
     */
    public $iconType = 'class';

    /**
     * @var string the class name for the icon to be displayed. If set to empty or null, will not be displayed.
     */
    public $icon = '';

    /**
     * @var array the HTML attributes for the icon.
     */
    public $iconOptions = [];

    /**
     * @var string the title for the alert. If set to empty or null, will not be displayed.
     */
    public $title = '';

    /**
     * @var array the HTML attributes for the title. The following options are additionally recognized:
     *
     * - `tag`: _string_, the HTML tag to render the title. Defaults to `span`.
     */
    public $titleOptions = ['class' => 'kv-alert-title'];

    /**
     * @var boolean show the title separator. Only applicable if [[title]] is set.
     */
    public $showSeparator = false;

    /**
     * @var integer the delay in microseconds after which the alert will be displayed. Will be useful when multiple
     * alerts are to be shown.
     */
    public $delay;

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo $this->getTitle();
        parent::run();
    }

    /**
     * Gets the title section
     *
     * @return string
     */
    protected function getTitle()
    {
        $icon = '';
        $title = '';
        $separator = '';
        if (!empty($this->icon) && $this->iconType == 'image') {
            $icon = Html::img($this->icon, $this->iconOptions);
        } elseif (!empty($this->icon)) {
            $this->iconOptions['class'] = $this->icon . ' ' . (empty($this->iconOptions['class']) ? 'kv-alert-title' : $this->iconOptions['class']);
            $icon = Html::tag('span', '', $this->iconOptions) . ' ';
        }
        if (!empty($this->title)) {
            $tag = ArrayHelper::remove($this->titleOptions, 'tag', 'span');
            $title = Html::tag($tag, $this->title, $this->titleOptions);
            if ($this->showSeparator) {
                $separator = '<hr class="kv-alert-separator">' . "\n";
            }
        }
        return $icon . $title . $separator;
    }

    /**
     * @inheritdoc
     */
    protected function initOptions()
    {
        parent::initOptions();
        if (empty($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        $this->registerAssets();
        Html::addCssClass($this->options, 'kv-alert ' . $this->type);
    }

    /**
     * Register the client assets for the [[Alert]] widget.
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        AlertAsset::register($view);

        if ($this->delay > 0) {
            $js = 'jQuery("#' . $this->options['id'] . '").fadeTo(' . $this->delay . ', 0.00, function() {
				$(this).slideUp("slow", function() {
					$(this).remove();
				});
			});';
            $view->registerJs($js);
        }
    }
}
