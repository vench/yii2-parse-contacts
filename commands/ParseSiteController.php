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
     * @var string
     */
    public $delimiter = ',';

    /**
     * @param string $sites List sites
     */
    public function actionIndex($sites)
    {
        $list = explode($this->delimiter, $sites);

        foreach ($list as $site) {
            $this->parse($site);
        }
    }

    /**
     * @param $site
     */
    protected function parse($site) {
        $this->stdout("Start parse site: " . $site . PHP_EOL);
        if(($val = filter_var($site, FILTER_VALIDATE_URL)) === false) {

        }

        var_dump($val);
        $this->stdout("End parse site: " . $site . PHP_EOL);
    }
}

