<?php

class SolarGraphFileHandler
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

        $stmt = $this->con->prepare("SELECT solar FROM SolarPower order by Timer");
        $stmt->execute();
        $stmt->bind_result($solar);
       

        $SolarGraph = array();
 
        while ($stmt->fetch()) {
 
            $temp = array();
            $temp['solar'] = $solar;
           
            array_push($SolarGraph, $temp);
        }
 
        return $SolarGraph;
    }
 
}
 
?>