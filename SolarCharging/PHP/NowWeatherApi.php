<?php

require_once dirname(__FILE__) . '/NowWeatherFileHandler.php';
 
$response = array();
 
if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
    
        case 'getinfo':

                $upload = new NowWeatherFileHandler();
                $response['weather'] = $upload->getinfo();
 
                break;
         
 
    }
}

//$result = shell_exec('python C:\Users\82108\NowWeather.py' . escapeshellarg(json_encode($response)));
//$resultData = json_decode($result, true);
//echo $resultData;
//$data = 'hello';
//$result = shell_exec('C:\Users\82108\NowWeather.py' .$data);
//echo $result;

echo json_encode($response)

?>