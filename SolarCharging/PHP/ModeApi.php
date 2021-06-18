<?php

require_once dirname(__FILE__) . '/ModeFileHandler.php';
 
$response = array();
 
if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
    
        case 'getinfo':

                $Product_Product_ID = $_POST['Product_Product_ID'];

                $upload = new ModeFileHandler();
                $response['error'] = false;
                $response['mode'] = $upload->getinfo();
 
                break;
         
 
    }
}
 
echo json_encode($response);

?>