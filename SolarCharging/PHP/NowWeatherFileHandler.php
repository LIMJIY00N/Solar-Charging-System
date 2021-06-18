<?php

class NowWeatherFileHandler
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

        $stmt = $this->con->prepare("SELECT Dayday,T,Rain,Wind,H,Iljo,Cloud FROM NowWeather");
        $stmt->execute();
        $stmt->bind_result($Dayday,$T,$Rain,$Wind,$H,$Iljo,$Cloud);

        $weather = array();
 
        while ($stmt->fetch()) {
 
            $temp = array();
            $temp['Dayday'] = $Dayday;
            $temp['T'] = $T;
            $temp['Rain'] = $Rain;
            $temp['Wind'] = $Wind;
            $temp['H'] = $H;
            $temp['Iljo'] = $Iljo;
            $temp['Cloud'] = $Cloud;

        
            array_push($weather, $temp);
        }
 
        return $weather;
    }
 
}
 
?>