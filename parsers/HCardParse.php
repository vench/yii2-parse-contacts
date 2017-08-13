<?php
/**
 * Created by PhpStorm.
 * User: vench
 * Date: 13.08.17
 * Time: 16:19
 */

namespace Vench\ParseContacts\Parsers;


use Vench\ParseContacts\Models\PCSite;
use Vench\ParseContacts\Ext\hKit;

class HCardParse extends AbParser
{

    /**
     * @param PCSite $model
     * @return boolean
     */
    public function parse(PCSite $model)
    {
        $hKit = new hKit();
        $result = $hKit->getByURL('hcard', $model->site);

        var_dump($result);
        return false;
    }
}