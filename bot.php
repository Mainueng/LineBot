<?php
$access_token = 'WBprEIEdmn/9vZJw+q3NcTQxUk/HdMcReUObJ1dkjOWzDX3X07ASeOkbPI21hKk4eCpZ2aw0HDs+Oa2FjmX6vN1UtzBic3gUxzdS1OgYQ52SYnKuu6E8qlD4c0sgjPHN6P86VymSKnYPxX/B8hWz6gdB04t89/1O/w1cDnyilFU=';

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

			if ($text == "ปิดไฟห้องนอน"  ){
				$replyToken = $event['replyToken'];
			// Build message to reply back
				$ch = curl_init("https://api.anto.io/channel/set/a67sMedxyPSvQ8Lo1ZEc2DrItGgYpiATFnqkzbJK/NodeMCU/Bed_Room/0");
				curl_exec($ch);

/*				$messages = [
					'type' => 'text',
					'text' => "ปิดไฟห้องนอนเรียบร้อย"
				];
*/				$messages = [
					'type' => 'sticker',
					'packageId': '10..176',
    				'stickerId': '2.5.99'//
    			];
			}
			else if ($text == "เปิดไฟห้องนอน"){
				$replyToken = $event['replyToken'];
				$ch = curl_init("https://api.anto.io/channel/set/a67sMedxyPSvQ8Lo1ZEc2DrItGgYpiATFnqkzbJK/NodeMCU/Bed_Room/1");
				curl_exec($ch);

				$messages = [
					'type' => 'text',
					'text' => "เปิดไฟห้องนอนเรียบร้อย" 
				];
			}
			else if ($text == "ปิดไฟห้องนั่งเล่น"){
				$replyToken = $event['replyToken'];
				$ch = curl_init("https://api.anto.io/channel/set/a67sMedxyPSvQ8Lo1ZEc2DrItGgYpiATFnqkzbJK/NodeMCU/Living_Room/0");
				curl_exec($ch);

				$messages = [
					'type' => 'text',
					'text' => "ปิดไฟห้องนั่งเล่นเรียบร้อย"
				];
			}
			else if ($text == "เปิดไฟห้องนั่งเล่น"){
				$replyToken = $event['replyToken'];
				$ch = curl_init("https://api.anto.io/channel/set/a67sMedxyPSvQ8Lo1ZEc2DrItGgYpiATFnqkzbJK/NodeMCU/Living_Room/1");
				curl_exec($ch);

				$messages = [
					'type' => 'text',
					'text' => "เปิดไฟห้องนั่งเล่นเรียบร้อย"
				];
			}
			else{
				$replyToken = $event['replyToken'];
				$messages = [
					'type' => 'text',
					'text' => $text
				];
			}



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