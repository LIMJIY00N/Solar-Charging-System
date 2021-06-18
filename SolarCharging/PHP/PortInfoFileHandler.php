<?php

class PortInfoFileHandler
{
 
    private $con;
 
    public function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
 
        $db = new DbConnect();
        $this->con = $db->connect();
    }
 
 
    public function getinfo()
    {

        $stmt = $this->con->prepare("SELECT Port_num,Report,Broken,StatusInfo,Product_Product_ID FROM PortInfo");
        $stmt->execute();
        $stmt->bind_result($Port_num,$Report,$Broken,$StatusInfo,$Product_Product_ID);
       

        $port = array();
 
        while ($stmt->fetch()) {
 
            $temp = array();
            $temp['Port_num'] = $Port_num;
            $temp['Report'] = $Report;
            $temp['Broken'] = $Broken;
            $temp['StatusInfo'] = $StatusInfo;
            $temp['Product_Product_ID'] = $Product_Product_ID;

            array_push($port, $temp);
        }
 
        return $port;
    }
 
}
 
?>