<?php

include('dbcon.php');


$response = array();
 
if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
    
        case 'getinfo':
     

                $Port_num = $_POST['Port_num'];
       
    
               
                    $statement = mysqli_prepare($con, "UPDATE PortInfo SET Report = 0,Broken = 0 where Port_num = ?");
                    mysqli_stmt_bind_param($statement, "i", $Port_num);
                    mysqli_stmt_execute($statement);
    
                
                $response = array();
                $response["success"] = true;
                
                echo json_encode($response);
             
                break;
         
    

    
}
}
?>