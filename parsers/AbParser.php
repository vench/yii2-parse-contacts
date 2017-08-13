<?php

namespace Vench\ParseContacts\Parsers;

use Vench\ParseContacts\Models\PCSite;

/**
 * Created by PhpStorm.
 * User: vench
 * Date: 13.08.17
 * Time: 16:17
 */
abstract class AbParser
{

    /**
     * @return AbParser[]
     */
    public static function getListParsers() {
        return [
            new YandexParser(),
            new HCardParse(),
            new PregMathParse(),
        ];
    }

    /**
     * @param PCSite $model
     * @return boolean
     */
    abstract public function parse(PCSite $model);

}