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

        foreach ($mf['items'] as $microformat) {
            echo "A {$microformat['type'][0]} called {$microformat['properties']['name'][0]}\n";
        }


        return false;
    }
}