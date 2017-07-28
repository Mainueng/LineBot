<?php
$access_token = 'WBprEIEdmn/9vZJw+q3NcTQxUk/HdMcReUObJ1dkjOWzDX3X07ASeOkbPI21hKk4eCpZ2aw0HDs+Oa2FjmX6vN1UtzBic3gUxzdS1OgYQ52SYnKuu6E8qlD4c0sgjPHN6P86VymSKnYPxX/B8hWz6gdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken


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
					$replyToken = $event['replyToken'];
					$messages = [
						'type' => 'text',
						'text' => $cal
				]; 
				}

					/*if($symbol[1] == "+"){
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
					}*/



			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";