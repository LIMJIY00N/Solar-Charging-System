<?php


include('dbcon.php');


$response = array();
 
if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
    
        case 'getinfo':
            
               $power = $_POST['power'];
              
               if(date("H")==0){
                    $statement = mysqli_prepare($con, " UPDATE Weather SET Powerpower = ?");
                    mysqli_stmt_bind_param($statement, "d", $power);
                    mysqli_stmt_execute($statement);
               }
                
                $response = array();
                $response["success"] = true;
                
                echo json_encode($response);
             
                break;
         

    

    
}
}
?>