<?php

$access_token = 'WBprEIEdmn/9vZJw+q3NcTQxUk/HdMcReUObJ1dkjOWzDX3X07ASeOkbPI21hKk4eCpZ2aw0HDs+Oa2FjmX6vN1UtzBic3gUxzdS1OgYQ52SYnKuu6E8qlD4c0sgjPHN6P86VymSKnYPxX/B8hWz6gdB04t89/1O/w1cDnyilFU=';
$proxy = 'http://fixie:vkd7AP4Z3dnMLIA@velodrome.usefixie.com:80';
$proxyauth = '5303phanat@gmail.com:tffunelee01';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$text = "สอนไม้หนึ่ง[สวัสดีจ้า สวัสดีครับ]";
$extra = str_replace("สอนไม้หนึ่ง","", $text);
    			$words = explode(" ", $ex_tra);
    			$_question = $words[0];
    			$_answer = $words[1];
echo $words[1];
echo $_question;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
