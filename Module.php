<?php
 
namespace Vench\ParseContacts;
/**
 * Base module class for Krajee extensions
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.8.9
 */
class Module extends \yii\base\Module
{
  
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init(); 

	var_dump(__METHOD__);
    }

