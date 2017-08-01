<?php

$access_token = 'WBprEIEdmn/9vZJw+q3NcTQxUk/HdMcReUObJ1dkjOWzDX3X07ASeOkbPI21hKk4eCpZ2aw0HDs+Oa2FjmX6vN1UtzBic3gUxzdS1OgYQ52SYnKuu6E8qlD4c0sgjPHN6P86VymSKnYPxX/B8hWz6gdB04t89/1O/w1cDnyilFU=';
$proxy = 'http://fixie:vkd7AP4Z3dnMLIA@velodrome.usefixie.com:80';
$proxnueng = '5303phanat@gmail.com:tffunelee01';

$conn = new mysqli($server, $username, $password, $db);

$content = file_get_contents('php://input');

$events = json_decode($content, true);

if (!is_null($events['events'])) {

	foreach ($events['events'] as $event) {

		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			$text = $event['message']['text'];

			$api_key="KQwfH7eNH_WLCmVVENPPyl2kWYflYa5u";
			$urlMlab = 'https://api.mlab.com/api/1/databases/mianueng/collections/LineBot?apiKey='.$api_key.'';
			$json = file_get_contents('https://api.mlab.com/api/1/databases/mianueng/collections/LineBot?apiKey='.$api_key.'&q={"question":"'.$text.'"}');
			$dataMlab = json_decode($json);
			$isData=sizeof($dataMlab);

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

					$data = [
					'replyToken' => $replyToken,
					'messages' => [$messages,$messages2,$messages3],
			
					];
			}

			elseif (strpos($text, 'สอนไม้หนึ่ง') !== false) {
				$extra = str_replace("สอนไม้หนึ่ง","", $text);
    			$words = explode("|", $extra);
    			$_question = str_replace("[","",$words[0]);
    			$_answer = str_replace("]","",$words[1]);

    			$newData = [
        				'question' => $_question,
        				'answer'=> $_answer
      				];
    			$newData = json_encode($newData);

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
    					'stickerId' => '2'
				];

				$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages,$messages2,$messages3]
			
				];
			}	

			else {

				if($isData > 0){
   					foreach($dataMlab as $rec){

   					$replyToken = $event['replyToken'];
					$messages = [
						'type' => 'text',
						'text' => $rec->answer
					]; 

					$data = [
					'replyToken' => $replyToken,
					'messages' => [$messages]
						];

					}

				}
				else{
				$replyToken = $event['replyToken'];
					$messages = [
					'type' => 'text',
					'text' => "ไม้หนึ่งไม่เข้าใจ สอนไม้หนึ่งได้ไหม"
					]; 

					$messages2 = [
					'type' => 'text',
					'text' => "สามารถสอนไม้หนึ่งได้โดย สอนไม้หนึ่ง[ถาม|ตอบ]"
					];

					$messages3 = [
					'type' => 'sticker',
					'packageId' => '1',
    				'stickerId' => '3'
				];

					$data = [
					'replyToken' => $replyToken,
					'messages' => [$messages,$messages2,$messages3]
						];
				}		
			}

			$urlLine = 'https://api.line.me/v2/bot/message/reply';
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