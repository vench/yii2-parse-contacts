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
                $newItem->save();
            }
        }
    }
}