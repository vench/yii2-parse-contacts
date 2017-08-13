<?php
/**
 * Created by PhpStorm.
 * User: vench
 * Date: 13.08.17
 * Time: 16:18
 */

namespace Vench\ParseContacts\Parsers;


use Vench\ParseContacts\Models\PCSite;

/**
 * Class YandexParser
 * @package Vench\ParseContacts\Parsers
 * @see https://tech.yandex.ru/maps/doc/geosearch/concepts/request-docpage/
 */
class YandexParser extends AbParser
{
    const YA_BASE_URL = 'https://search-maps.yandex.ru/v1/';

    /**
     * @param PCSite $model
     * @return boolean
     */
    public function parse(PCSite $model)
    {

        $url = self::YA_BASE_URL . '?'. http_build_query([
                'apikey'    => $this->getApiKey(),
                'lang'      => 'ru_RU',
                'text'      => $model->site,
                'type'      => 'biz',
            ]);
        echo $url, PHP_EOL;
        $result = $this->getContent($url);

        if($result && ($data = json_decode($result, true)) && isset($result['features'])) {
            foreach ($result['features'] as $feature) {
                if(!isset($feature['properties']['CompanyMetaData'])) {
                    continue;
                }

                $data = $feature['properties']['CompanyMetaData'];
                $this->addAddrs($model, [$data['address']]);
                if(!empty($data['Phones'])) {
                    $this->addTels( $model, array_map(function($p){
                        return $p['formatted'];
                    }, $data['Phones']));
                }
            }
        }

        //тк нет email
        return false;
    }


    /**
     * @return string
     */
    private function getApiKey() {
        return isset(\Yii::$app->params['yandex']['apikey']) ?
            \Yii::$app->params['yandex']['apikey'] : 'xxxxxxxxxx';
    }
}