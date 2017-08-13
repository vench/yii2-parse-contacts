<?php

namespace Vench\ParseContacts;

use yii\base\BootstrapInterface;
use yii\console\controllers\MigrateController;



/**
 * Base module class for Krajee extensions
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.8.9
 */
class Module extends \yii\base\Module implements BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'Vench\ParseContacts\Commands';

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap( $app)
    {
        if ($app instanceof \yii\console\Application) {
            \Yii::$container->set(
                MigrateController::class,
                [
                    'migrationPath' => [
                        '@app/migrations',
                        '@vendor/vench/yii2-parse-contacts/migrations']
                ]
            );

            $app->controllerMap[$this->id] = [
                'class' => 'Vench\ParseContacts\Commands\ParseSiteController',
                //'module' => $this,
            ];
        }
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

    }
}


