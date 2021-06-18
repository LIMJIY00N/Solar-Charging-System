<?php


include('dbcon.php');


$response = array();
 
if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
    
        case 'getinfo':
            

               $Dayday = $_POST['Dayday'];
               $T = $_POST['T'];
               $Rain = $_POST['Rain'];
               $Wind = $_POST['Wind'];
               $H = $_POST['H'];
               $Iljo = $_POST['Iljo'];
               $Cloud = $_POST['Cloud'];
 

                if(date("H")==0){
                    $statement = mysqli_prepare($con, "UPDATE NowWeather SET Dayday = ?,T = ?,Rain=?,Wind=?,H=?,Iljo=?,Cloud=?");
                    mysqli_stmt_bind_param($statement, "idddddd", $Dayday,$T,$Rain,$Wind,$H,$Iljo,$Cloud);
                    mysqli_stmt_execute($statement);
                }
                
                $response = array();
                $response["success"] = true;
                
                echo json_encode($response);
             
                break;
         

    

    
}
}
?>