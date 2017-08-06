<?php
 
namespace Vench\ParseContacts;

use yii\base\BootstrapInterface;


/**
 * Base module class for Krajee extensions
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.8.9
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
  
  
     /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app) {
    
        var_dump(__METHOD__);
    }
  
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init(); 

	var_dump(__METHOD__);
    }

