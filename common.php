<?php
    
require_once dirname(__DIR__).'../vendor/autoload.php';

function createClient($accountId, $appName, $token) {

  $client = new \Basecamp\Client([
    'accountId' => $accountId, // Basecamp account ID
    'appName' => $appName, // Application name (used as User-Agent header)
    'token' => $token,
    ]);

  return $client;
  }
 
 function successResponse($data){
 	$result = ["status" => "success", "data" => $data];
 	echo json_encode($result);
	exit;
 }

 function missingPath() {
 	$result = ["status" => "fail", "error_code" => 404, "error_message" => "Missed Path"];
	echo json_encode($result);
	exit;
 }

 function missingParam() {
 	$result = ["status" => "fail", "error_code" => 500, "error_message" => "Missed Parameters"];
	echo json_encode($result);
	exit;
 }

  function errorResponse() {
 	$result = ["status" => "fail", "error_code" => 401, "error_message" => "Not found data"];
	echo json_encode($result);
	exit;
 }

 function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }


    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HEADER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

?>