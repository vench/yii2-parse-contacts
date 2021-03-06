<?php
/**
 * Created by PhpStorm.
 * User: vench
 * Date: 13.08.17
 * Time: 16:19
 */

namespace Vench\ParseContacts\Parsers;


use Vench\ParseContacts\Models\PCSite;
use Vench\ParseContacts\Models\PCSiteAddress;
use Vench\ParseContacts\Models\PCSiteEmail;
use Vench\ParseContacts\Models\PCSitePhone;
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
                if(isset($item['type'][0]) && $item['type'][0] === 'h-card') {
                    return $this->fetchData($item['properties'], $model);
                }
            }
        }

        return false;
    }

    /**
     * @param $properties
     * @param PCSite $model
     * @return bool
     */
    private function fetchData($properties, PCSite $model) {


        if(isset($properties['adr'])) {
            $adrs = !is_array($properties['adr']) ? [$properties['adr']] : $properties['adr'];
            $this->addAddrs($model,
                array_map(function($a){ return isset($a['value']) ? $a['value'] : json_encode($a); }, $adrs));
        } else {
            return false;
        }

        if(isset($properties['tel'])) {
            $tels = !is_array($properties['tel']) ? [$properties['tel']] : $properties['tel'];
            $this->addTels($model, $tels);
        } else {
            return false;
        }

        if(isset($properties['email'])) {
            $emails = !is_array($properties['email']) ? [$properties['email']] : $properties['email'];
            $this->addEmails($model, $emails);
        } else {
            return false;
        }

        return true;
    }


}