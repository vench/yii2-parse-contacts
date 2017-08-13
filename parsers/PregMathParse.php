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
        $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
        if(preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) {
            foreach($matches as $match) {
                $url = $match[2];
                if(strpos($url, 'http') === false) {//local path
                    $url = $model->site . $url;

                    $content = $this->getContent($url);
                    if( $this->parseAddress($model, $content) &&
                        $this->parseEmail($model, $content) &&
                        $this->parsePhone($model, $content)) {
                        return true;
                    }

                }
            }
        }

        return false;
    }


    /**
     * @param PCSite $model
     * @param string $content
     * @return bool
     */
    private function parseEmail(PCSite $model, $content) {
        $regexp = '/[A-Za-z\d._%+-]+@[A-Za-z\d.-]+\.[A-Za-z]{2,4}\b/siU';
        if(preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) {
            print_r($matches);
        }
        return false;
    }

    /**
     * @param PCSite $model
     * @param string $content
     * @return bool
     */
    private function parsePhone(PCSite $model, $content) {
        return false;
    }

    /**
     * @param PCSite $model
     * @param string $content
     * @return bool
     */
    private function parseAddress(PCSite $model, $content) {
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