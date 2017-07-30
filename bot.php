<?php
$access_token = 'WBprEIEdmn/9vZJw+q3NcTQxUk/HdMcReUObJ1dkjOWzDX3X07ASeOkbPI21hKk4eCpZ2aw0HDs+Oa2FjmX6vN1UtzBic3gUxzdS1OgYQ52SYnKuu6E8qlD4c0sgjPHN6P86VymSKnYPxX/B8hWz6gdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data

$url = parse_url(getenv("mysql://b92d9507302d3f:83435ac5@us-cdbr-iron-east-03.cleardb.net/heroku_f10f824e36ff3bf?reconnect=true"));

$server = $url["us-cdbr-iron-east-03.cleardb.net"];
$username = $url["b92d9507302d3f"];
$password = $url["83435ac5"];
$db = substr($url["heroku_f10f824e36ff3bf"], 1);

$conn = new mysqli($server, $username, $password, $db);

CREATE TABLE employees (
    employee_id SERIAL,
    last_name VARCHAR(30),
    first_name VARCHAR(30),
    title VARCHAR(50)
);

INSERT INTO employees (last_name, first_name, title) VALUES
    ('Abreu', 'Mark', 'Project Coordinator'),
    ('Nyman', 'Larry', 'Security Engineer'),
    ('Simmons', 'Iris', 'Software Architect'),
    ('Miller', 'Anthony', 'Marketing Manager'),
    ('Leigh', 'Stephen', 'UI Developer'),
    ('Lee', 'Sonia', 'Business Analyst');

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
				
				if ($cal <= 999999999999999999 ) {
					$replyToken = $event['replyToken'];
					$messages = [
						'type' => 'text',
						'text' => $text." ก็เท่ากับ ".$cal." ไง"
				]; 
					$messages2 = [
						'type' => 'text',
						'text' => "มียากกว่านี้ไหม MaiNueng เบื่อ"
				];
					$messages3 = [
						'type' => 'sticker',
						'packageId' => '1',
    					'stickerId' => '1' //11
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
						'text' => "เลขเยอะเกินไป MaiNueng คิดไม่ไหว"
				];
					$messages3 = [
						'type' => 'sticker',
						'packageId' => '1',
    					'stickerId' => '16'
						];
				}
			}

			else {
				$messages = [
						'type' => 'text',
						'text' => $text
				];
				/*$messages2 = [
						'type' => 'text',
						'text' => $text
				]; 
				$messages3 = [
						'type' => 'text',
						'text' => $text
				];*/  
			}	
			


			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages,$messages2,$messages3],
			
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