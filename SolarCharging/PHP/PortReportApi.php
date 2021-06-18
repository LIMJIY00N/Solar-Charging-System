<?php


include('dbcon.php');


$response = array();
 
if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
    
        case 'getinfo':
            if (isset($_POST['Port_num']) > 0 && isset($_POST['Report'])) {

                $Port_num = $_POST['Port_num'];
                $Report = $_POST['Report'];
                $m = $_POST['m'];

                if($m==0){
                    $statement = mysqli_prepare($con, "UPDATE PortInfo SET Report = ? where Port_num = ?");
                    mysqli_stmt_bind_param($statement, "ii",$Report, $Port_num);
                    mysqli_stmt_execute($statement);
    
                }else{
                    $statement = mysqli_prepare($con, "UPDATE PortInfo SET Broken = ? where Port_num = ?");
                    mysqli_stmt_bind_param($statement, "ii",$Report, $Port_num);
                    mysqli_stmt_execute($statement);
                }
            
                $response = array();
                $response["success"] = true;
                
                echo json_encode($response);
             
                break;
         

    }

    
}
}
?>