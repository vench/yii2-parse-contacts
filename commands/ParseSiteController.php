<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace Vench\ParseContacts\Commands;

use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ParseSiteController extends Controller
{
    /**
     * @param array $sites
     */
    public function actionIndex($sites = [])
    {
        var_dump($sites);
        echo __METHOD__ . "\n";
    }
}

