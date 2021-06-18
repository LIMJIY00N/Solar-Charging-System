<?php

class TrainDataHandler
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

        $stmt = $this->con->prepare("SELECT Day, T, Rain, Wind, H, Iljo, Ilsa, Cloud, Target FROM TrainData");
        $stmt->execute();
        $stmt->bind_result($Day,$T,$Rain,$Wind,$H,$Iljo,$Ilsa,$Cloud,$Target);

        $train = array();
 
        while ($stmt->fetch()) {
 
            $temp = array();
            $temp['Day'] = $Day;
            $temp['T'] = $T;
            $temp['Rain'] = $Rain;
            $temp['Wind'] = $Wind;
            $temp['H'] = $H;
            $temp['Iljo'] = $Iljo;
            $temp['Ilsa'] = $Ilsa;
            $temp['Cloud'] = $Cloud;
            $temp['Target'] = $Target;
        
            array_push($train, $temp);
        }
 
        return $train;
    }
 
}
 
?>
