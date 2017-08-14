<?php

namespace Vench\ParseContacts\Parsers;

use Vench\ParseContacts\Models\PCSite;
use Vench\ParseContacts\Models\PCSiteEmail;
use Vench\ParseContacts\Models\PCSitePhone;
use Vench\ParseContacts\Models\PCSiteAddress;

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

    /**
     * @param PCSite $model
     * @param attay $adrs array of string
     */
    protected function addAddrs(PCSite $model, $adrs) {

        $issets = [];
        foreach ($model->pcSiteAddresses as $item) {
            $issets[$item->address] = true;
        }
        foreach ($adrs as $adr) {
            if(!isset($issets[$adr])) {
                $newItem = new PCSiteAddress();
                $newItem->address = $adr;
                $newItem->site_id = $model->id;
                $newItem->sessia = 1;
                $newItem->save();
            }
        }
    }

    /**
     * @param PCSite $model
     * @param array $tels array of string
     */
    protected function addTels(PCSite $model, $tels) {
        $issets = [];
        foreach ($model->pcSitePhones as $item) {
            $issets[$item->phone] = true;
        }
        foreach ($tels as $tel) {
            if (!isset($issets[$tel])) {
                $newItem = new PCSitePhone();
                $newItem->phone = $tel;
                $newItem->site_id = $model->id;
                $newItem->sessia = 1;
                $newItem->save();
            }
        }
    }


    /**
     * @param PCSite $model
     * @param array $emails array of string
     */
    protected function addEmails(PCSite $model, $emails) {

        $issets = [];
        foreach ($model->pcSiteEmails as $item) {
            $issets[$item->email] = true;
        }
        foreach ($emails as $email) {
            if (!isset($issets[$email])) {
                $newItem = new PCSiteEmail();
                $newItem->email = $email;
                $newItem->site_id = $model->id;
                $newItem->sessia = 1;
                $newItem->save();
            }
        }
    }

    /**
     * @param string $url
     * @return bool|string
     */
    protected function getContent($url) {
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "Accept-language: en\r\n" .
                    "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.109 Safari/537.36\r\n"
            ]
        ];

        $context = stream_context_create($opts);

        return file_get_contents($url, false, $context);
    }

    /**
     * @param string $phone
     * @return string
     */
    protected function normallyPhone($phone) {
        return preg_replace('/[^0-9\+]/', '', $phone);
    }
}