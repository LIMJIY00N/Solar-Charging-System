<?php

require_once dirname(__FILE__) .  '/SolarGraphFileHandler.php';
 
$response = array();
 
if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
    
        case 'getinfo':

                $upload = new SolarGraphFileHandler();
                $response['error'] = false;
                $response['SolarGraph'] = $upload->getinfo();
 
                break;
         
 
    }
}
 
echo json_encode($response);

?>