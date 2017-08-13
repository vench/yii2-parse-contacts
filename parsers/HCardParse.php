<?php
/**
 * Created by PhpStorm.
 * User: vench
 * Date: 13.08.17
 * Time: 16:19
 */

namespace Vench\ParseContacts\Parsers;


use Vench\ParseContacts\Models\PCSite;
use Mf2;




class HCardParse extends AbParser
{

    /**
     * @param PCSite $model
     * @return boolean
     */
    public function parse(PCSite $model)
    {
        $mf = Mf2\fetch($model->site);
        if(isset($mf['items'])) {
            foreach ($mf['items'] as $item) {
                if(isset($item['h-card'][0]) && $item['h-card'][0] === 'h-card') {
                    return $this->fetchData($item['properties'], $model);
                }
            }
        }

        return false;
    }

    private function fetchData($properties, PCSite $model) {
        print_r($properties);
        return false;
    }
}