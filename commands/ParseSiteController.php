<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace Vench\ParseContacts\Commands;

use Vench\ParseContacts\Models\PCSite;
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

        $url = $this->normallyUrl($site);

        if(($val = filter_var($url, FILTER_VALIDATE_URL)) === false) {

            $this->stderr("Invalid value: ". $url . PHP_EOL);
            return;
        }

        $model = PCSite::find()->where('site=:site', $url);
        if(is_null($model)) {
            $model = new PCSite();
            $model->site = $url;
            $model->title = $site;
            $model->save();
        }

        echo $model->id, PHP_EOL;


        $this->stdout("End parse site: " . $site . PHP_EOL);
    }

    /**
     * @param string $url
     * @return string
     */
    protected function normallyUrl($url) {
        if ( $parts = parse_url($url) ) {
            if ( !isset($parts["scheme"]) )  {
                return 'http://' . $parts['path'];
            }

            return $parts['scheme'] . '://' . $parts['host'];
        }
        return $url;
    }
}

