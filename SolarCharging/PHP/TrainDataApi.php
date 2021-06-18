<?php

require_once dirname(__FILE__) . '/TrainDataHandler.php';
 
$response = array();
 
if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
    
        case 'getinfo':

                $upload = new TrainDataHandler();
                $response['error'] = false;
                $response['TrainData'] = $upload->getinfo();
 
                break;
         
    }
}

echo json_encode($response)

?>
