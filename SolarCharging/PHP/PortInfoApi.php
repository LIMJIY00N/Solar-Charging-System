<?php

require_once dirname(__FILE__) .  '/PortInfoFileHandler.php';
 
$response = array();
 
if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
    
        case 'getinfo':

                $upload = new PortInfoFileHandler();
                $response['error'] = false;
                $response['port'] = $upload->getinfo();
 
                break;
         
 
    }
}
 
echo json_encode($response);

?>