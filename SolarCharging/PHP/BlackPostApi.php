<?php


include('dbcon.php');


$response = array();

if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
            
        case 'getinfo':
            
     
            $Blackout = $_POST['Blackout'];
            
            
            $statement = mysqli_prepare($con, "UPDATE States SET Blackout = ?");
            mysqli_stmt_bind_param($statement, "i", $Blackout);
            mysqli_stmt_execute($statement);
            
            
            $response = array();
            $response["success"] = true;
            
            echo json_encode($response);
            
            break;
            
            
            
            
            
    }
}
?>
