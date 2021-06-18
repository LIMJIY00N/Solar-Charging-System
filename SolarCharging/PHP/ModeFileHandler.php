<?php

class ModeFileHandler
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

        $stmt = $this->con->prepare("SELECT Mode FROM States");
        $stmt->execute();
        $stmt->bind_result($Mode);

        $mode = array();
 
        while ($stmt->fetch()) {
 
            $temp = array();
            $temp['Mode'] = $Mode;
        
            array_push($mode, $temp);
        }
 
        return $mode;
    }
 
}
 
?>