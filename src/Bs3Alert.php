<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2020
 * @package yii2-widgets
 * @subpackage yii2-widget-alert
 * @version 1.1.4
 */

namespace kartik\alert;

use Yii;
use yii\bootstrap\Alert;

/**
 * Alert widget extends the [[Alert]] widget with an easier configuration and additional styling options including
 * auto fade out.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class Bs3Alert extends Alert implements AlertInterface
{
    use AlertMethodsTrait;
}
