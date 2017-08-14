<?php


function getContent($url) {
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

function parseLinks($content, $site = 'http://base.site') {
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

function parseEmails($content) {
    $regexp = '[A-Za-z\d._%+-]+@[A-Za-z\d.-]+\.[A-Za-z]{2,4}\b';
    $result = [];
    if(preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            $result[$match[0]] = 1;
        }
    }

    return array_keys($result);
}


function parsePhone($content) {
    $regexps = [
        '(\+\d\s)?  \(?  (\d{3})?  \)?  (?(1)  [\-\s] ) \d{3}-\d{4}',
        '(\+\d\s)? \(?  (\d{3})?  \)?  (?(1)  [\-\s] ) \d{3}-\d{2}-\d{2}',
        '(\d\s)? \(?  (\d{3})?  \)?  (?(1)  [\-\s] ) \d{3}-\d{2}-\d{2}',
        '\(?  (\d{3})?  \)?  (?(1)  [\-\s] ) \d{3}-\d{2}-\d{2}'
        ];
    $result = [];

    foreach($regexps as $regexp) {
        if(preg_match_all("/$regexp/x", $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $result[$match[0]] = 1;
            }
        }
    }

    return   array_map('normallyPhone',  array_keys($result));
}

function normallyPhone($phone) {
    return preg_replace('/[^0-9\+]/', '', $phone);
}



function parseAddress($content) {
    $names = [
        'г\.', 'ул\.', 'д\.', 'оф\.'
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
    return  join(', ', $result);
}

function parse($site)
{
    $content = getContent($site);
    $result = parseLinks($content, $site);
    $contentNoHtml = strip_tags($content);

    $emails = parseEmails($contentNoHtml);

    $phones = parsePhone($contentNoHtml);

    var_dump($phones);


    $address = parseAddress($contentNoHtml);

    var_dump($address);

    foreach ($emails as $email) {
        echo "Email: ", $email, PHP_EOL;
    }

    foreach ($result as $url) {
     //   echo $url, PHP_EOL;
    }
}




$url = 'http://www.okna98.ru/contacts/';// 'https://pv-okna.ru/kontakty/';
parse($url);