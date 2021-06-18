<?php


include('dbcon.php');


$response = array();

if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
            
        case 'getinfo':
            

            $power = $_POST['power'];
            $port1 = $_POST['port1'];
            $port2 = $_POST['port2'];
            $port3 = $_POST['port3'];
            $Mode = $_POST['Mode'];

            $timer = date("H");
            $timer_h = date("H");
            $timer_m = date("i");
            $timer_s = date("s");

            if($timer_s ==0 && $timer_m!=0){
                $total += power;
            }


            if(date("H")==0){
                $statement = mysqli_prepare($con, "DELETE FROM  SolarPower");
                mysqli_stmt_execute($statement);
             }
           
         

            
            $statement = mysqli_prepare($con, "UPDATE States SET Mode = ?");
            mysqli_stmt_bind_param($statement, "i", $Mode);
            mysqli_stmt_execute($statement);
         
            
               
            $statement = mysqli_prepare($con, "UPDATE PortInfo SET StatusInfo = ? where Port_num = 1");
            mysqli_stmt_bind_param($statement, "i", $port1);
            mysqli_stmt_execute($statement);
         
                        
            $statement = mysqli_prepare($con, "UPDATE PortInfo SET StatusInfo = ? where Port_num = 2");
            mysqli_stmt_bind_param($statement, "i", $port2);
            mysqli_stmt_execute($statement);
         
                        
            $statement = mysqli_prepare($con, "UPDATE PortInfo SET StatusInfo = ? where Port_num = 3");
            mysqli_stmt_bind_param($statement, "i", $port3);
            mysqli_stmt_execute($statement);
         
            if(date("i")==0){
                $a = $total /= 59;
                $statement = mysqli_prepare($con, "INSERT INTO SolarPower VALUES (?,?)");
                mysqli_stmt_bind_param($statement, "id", $timer,$a);
                mysqli_stmt_execute($statement);
                $total = 0;
             }
            
             
            $response = array();
            $response["success"] = true;
            
            echo json_encode($response);
            
            break;
            
            
            
            
            
    }
}
?>
