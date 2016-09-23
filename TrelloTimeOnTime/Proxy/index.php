<?php
$url = urldecode($_GET['URL']);

if (isset($_GET['params'])) $params = urldecode($_GET['params']);
else $params = "";

$url = $url . $params;
//$myvars = http_build_query(json_decode($_POST["data"], true));

$ch = curl_init($url);

if (isset($_POST["data"])) {
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST["data"]);
} else {
    
}

//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//curl_setopt($ch, CURLOPT_HEADER, 0);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER,
    array(
        'Content-Type: application/json'
    ));

$response = curl_exec($ch);

//echo $response;
?>