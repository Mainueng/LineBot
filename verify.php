<?php

$access_token = 'WBprEIEdmn/9vZJw+q3NcTQxUk/HdMcReUObJ1dkjOWzDX3X07ASeOkbPI21hKk4eCpZ2aw0HDs+Oa2FjmX6vN1UtzBic3gUxzdS1OgYQ52SYnKuu6E8qlD4c0sgjPHN6P86VymSKnYPxX/B8hWz6gdB04t89/1O/w1cDnyilFU=';
$proxy = 'http://fixie:vkd7AP4Z3dnMLIA@velodrome.usefixie.com:80';
$proxyauth = '5303phanat@gmail.com:tffunelee01';

$url2 = parse_url(getenv("mysql://b92d9507302d3f:83435ac5@us-cdbr-iron-east-03.cleardb.net/heroku_f10f824e36ff3bf?reconnect=true"));
$server = $url2["us-cdbr-iron-east-03.cleardb.net"];
$username = $url2["b92d9507302d3f"];
$password = $url2["83435ac5"];
$db = substr($url2["heroku_f10f824e36ff3bf"], 1);

$conn = new mysqli($server, $username, $password, $db);
	if ($conn) {
		echo "Connected successfully (".$conn->host_info.")";
	}

	$sql = "SELECT * FROM heroku_f10f824e36ff3bf.learn;";
	echo "<br> Answer:".["ID"]."<br>";


$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
$result = curl_exec($ch);
curl_close($ch);

echo $result;