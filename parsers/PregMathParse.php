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

        list($links, $phones, $emails) = $this->parseLinks($content, $model->site);

        $this->addEmails($model, $emails);
        $this->addTels($model, $phones);

        $contentNoHtml = strip_tags($content);

        $this->addEmails($model, $this->parseEmail($contentNoHtml));
        $this->addTels($model, $this->parsePhone($contentNoHtml));
        $this->addAddrs($model, $this->parseAddress($contentNoHtml));

        foreach ($links as $link) {
            $content = $this->getContent($link);
            $contentNoHtml = strip_tags($content);

            $this->addEmails($model, $this->parseEmail($contentNoHtml));
            $this->addTels($model, $this->parsePhone($contentNoHtml));
            $this->addAddrs($model, $this->parseAddress($contentNoHtml));
        }

        return false;
    }


    /**
     * @param string $content
     * @return array
     */
    private function parseEmail($content) {
        $regexp = '[A-Za-z\d._%+-]+@[A-Za-z\d.-]+\.[A-Za-z]{2,4}\b';
        $result = [];
        if(preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $result[$match[0]] = 1;
            }
        }

        return array_keys($result);
    }

    /**
     * @param string $content
     * @return array
     */
    private function parsePhone($content) {
        return [];
    }

    /**
     * @param string $content
     * @return array
     */
    private function parseAddress($content) {
        $names = [
            'г\.', 'Станция метро:', 'пр\.', 'бульвар', 'ул\.', 'д\.', 'к\.', 'оф\.', 'БЦ'
        ];
        $regexps = [
            '('.join('|', $names).')\s{1,2}.+(\,|\s{2})'
        ];
        $result = [];

        foreach($regexps as $regexp) {
            if(preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) {

                foreach ($matches as $match) {
                    $val = trim($match[0]);
                    $key = trim($match[1]);
                    if($val && $key) {
                        if(substr($val, -1) === ',') {
                            $val = substr($val, 0, -1);
                        }
                        $index = array_search(str_replace('.', '\.', $key), $names);
                        $result[$index] = $val;
                    }
                }
            }
        }

        ksort($result);
        return !empty($result) ? [join(', ', $result)] : [];
    }


    /**
     * @param $content
     * @param string $site
     * @return array list($links, $phones, $emails)
     */
    private function parseLinks($content, $site = 'http://base.site') {
        $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
        $links = [];
        $emails = [];
        $phones = [];
        if(preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) {
            foreach($matches as $match) {
                $url = $match[2];
                if( strpos($url, '#') !== false) {
                    continue;
                }
                if(strpos($url, 'tel:') !== false) {
                    $phones[] = substr($url, 4);
                    continue;
                }
                if(strpos($url, 'mailto:') !== false) {
                    $emails[] = substr($url, 7);
                    continue;
                }

                if(strpos($url, 'http') === false) {//local path
                    $url = rtrim($site, '/') . '/' .
                        ltrim(str_replace('\'', '', $url), '/');
                }
                $links[] = $url;
            }
        }

        return array_map('array_unique',  [  $links, $phones, $emails ]);
    }


}