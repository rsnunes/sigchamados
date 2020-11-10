<?php

class Sql extends PDO {
    private $conn;
    
    public function __construct(){        
        $this->conn = new PDO("mysql:host=127.0.0.1;dbname=sigchamados",'sigchamados','nopass');
    }
    
    private function setParams($statment,$params){
        foreach($params as $key => $value){
            $this->setParam($statment,$key,$value);
        }
    }
    private function setParam($statment, $key, $value){
        $statment->bindParam($key,$value);
    }
    
    public function query($query, $params = null){
        $stmt = $this->conn->prepare($query);
        $this->setParams($stmt,$params);
        $stmt->execute();
        return $stmt;
    }
    
    public function inserir($query, $params = null){
        $stmt = $this->conn->prepare($query);
        $this->setParams($stmt,$params);
        $stmt->execute();
        $_SESSION['last_id'] = $this->conn->lastInsertId();
        return $stmt;
    }
    
    public function select($query, $params = array()):array{
        $stmt = $this->query($query,$params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
