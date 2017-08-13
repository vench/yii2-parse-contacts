<?php
/**
 * Created by PhpStorm.
 * User: vench
 * Date: 13.08.17
 * Time: 16:19
 */

namespace Vench\ParseContacts\Parsers;


use Vench\ParseContacts\Models\PCSite;

class PregMathParse extends AbParser
{

    /**
     * @param PCSite $model
     * @return boolean
     */
    public function parse(PCSite $model)
    {
        $content = $this->getContent($model->site);
        $dom = new DOMDocument;
        $dom->loadHTML($content);
        foreach ($dom->getElementsByTagName('a') as $node) {
            echo $dom->saveHtml($node), PHP_EOL;
        }

        return false;
    }

    /**
     * @param $url
     * @return bool|string
     */
    private function getContent($url) {
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "Accept-language: en\r\n"
            ]
        ];

        $context = stream_context_create($opts);

        return file_get_contents($url, false, $context);
    }
}