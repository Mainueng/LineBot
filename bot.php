<?php

$access_token = 'WBprEIEdmn/9vZJw+q3NcTQxUk/HdMcReUObJ1dkjOWzDX3X07ASeOkbPI21hKk4eCpZ2aw0HDs+Oa2FjmX6vN1UtzBic3gUxzdS1OgYQ52SYnKuu6E8qlD4c0sgjPHN6P86VymSKnYPxX/B8hWz6gdB04t89/1O/w1cDnyilFU=';
$proxy = 'http://fixie:vkd7AP4Z3dnMLIA@velodrome.usefixie.com:80';
$proxnueng = '5303phanat@gmail.com:tffunelee01';

$urlDB = parse_url(getenv("mysql://b92d9507302d3f:83435ac5@us-cdbr-iron-east-03.cleardb.net/heroku_f10f824e36ff3bf?reconnect=true"));
$server = $urlDB["us-cdbr-iron-east-03.cleardb.net"];
$username = $urlDB["b92d9507302d3f"];
$password = $urlDB["83435ac5"];
$db = substr($urlDB["heroku_f10f824e36ff3bf"], 1);

$conn = new mysqli($server, $username, $password, $db);

$content = file_get_contents('php://input');

$events = json_decode($content, true);

if (!is_null($events['events'])) {

	foreach ($events['events'] as $event) {

		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			$text = $event['message']['text'];

			if (strpos($text, '=') !== false) {
				$symbol = explode(" ", $text);
					if($symbol[1] == "+"){
						$cal = intval($symbol[0]) + intval($symbol[2]);
					}
					else if($symbol[1] == "-"){
						$cal = intval($symbol[0]) - intval($symbol[2]);	
					}
					else if($symbol[1] == "*"){
						$cal = intval($symbol[0]) * intval($symbol[2]);	
					}
					else if($symbol[1] == "/"){
						$cal = intval($symbol[0]) / intval($symbol[2]);	
					}

					$cal = (string)$cal;
				
				if ($cal <= 999999999999999999 ) {
					$replyToken = $event['replyToken'];
					$messages = [
						'type' => 'text',
						'text' => $text." ก็เท่ากับ ".$cal." ไง"
				]; 
					$messages2 = [
						'type' => 'text',
						'text' => "มียากกว่านี้ไหม ไม้หนึ่งเบื่อ"
				];
					$messages3 = [
						'type' => 'sticker',
						'packageId' => '1',
    					'stickerId' => '1'
						];
				}
				else if ($cal > 999999999999999999){
					$replyToken = $event['replyToken'];
					$messages = [
						'type' => 'text',
						'text' => "Error !!!"
				]; 
					$messages2 = [
						'type' => 'text',
						'text' => "เลขเยอะเกินไป ไม้หนึ่งคิดไม่ไหว"
				];
					$messages3 = [
						'type' => 'sticker',
						'packageId' => '1',
    					'stickerId' => '16'
						];
				}
			}

			if (strpos($text, 'สอนไม้หนึ่ง') !== false) {
				$extra = str_replace("สอนเป็ด","", $_msg);
    			$pieces = explode("|", $ex_tra);
    			$_question=str_replace("[","",$pieces[0]);
    			$_answer=str_replace("]","",$pieces[1]);

    			$newData = json_encode(array(
        				'question' => $_question,
        				'answer'=> $_answer
      				)
    			);

    			$opts = array(
      				'http' => array(
          			'method' => "POST",
          			'header' => "Content-type: application/json",
          			'content' => $newData
       				)
    			);

    			$context = stream_context_create($opts);
    			$returnValue = file_get_contents($urlMlab,false,$context);

    			$replyToken = $event['replyToken'];
					$messages = [
						'type' => 'text',
						'text' => "ไม้หนึ่งจำได้แล้ว"
				]; 
					$messages2 = [
						'type' => 'text',
						'text' => "ขอบคุณที่สอนไม้หนึ่ง"
				];
					$messages3 = [
						'type' => 'sticker',
						'packageId' => '1',
    					'stickerId' => '1'
				];
			}

  
		}	
			

			$urlLine = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages,$messages2,$messages3],
			
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($urlLine);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_PROXY, $proxy);
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxnueng);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";