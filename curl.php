<?php 
$ch = curl_init();

$url = "https://api.restcountries.com/countries/v5?q=canada&pretty=1";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer rc_live_560cf3bbfbfd43558a5a147a98268af7"));

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo "Curl Error: " . curl_error($ch);
}else{
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_code == 200) {
        echo "Request Successful";
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($response, $header_size);
        $countries = json_decode($body, true);
        print_r($countries);
    }else{
        print_r($response);
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Fetching all countries with curl</h1>
</body>
</html>