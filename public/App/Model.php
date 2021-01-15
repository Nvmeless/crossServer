<?php

class Model{
    
    private $db;
    public $id;
    private $dbPrefix = 'crossServer_';

    
    public function get($params = null){
        $table = $this->table ?? null;
        if($table ===null){
            $table = $params['table'] ?? null;
        }
        $id = $params['id'] ?? '*' ;
        if($table !== null){
            $q = $this->dbPrefix . $table;
            $sql = "SELECT * FROM `$q`"; 
            if($id !== '*'){
                $sql .=" WHERE id = $id"; 
            }
            try {                      
                $db = getDB();
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $raw = $stmt->fetchAll(PDO::FETCH_OBJ);

                if($id !== '*'){

                        foreach ($raw[0] as $key => $value) {
                        $this->$key = $value;

                        }
                    
                }
                
                $db = null;
                
                return true;       
            } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}';
                return false;
            }
        }
    }
    
    
    public function post($params = null){

        if($params['table'] !== null){

            $table = $this->dbPrefix . $params['table'];
            $tables = "(";
            $datas = "(";
            foreach ($params as $key => $value) {
                if($key !== 'table'){
                    $tables .= " `$key`,";
                    $datas .= " " . '"'.$value. '"'.",";
                }
            }
            $tables .= "`id`)";
            $datas .= "NULL)";
            $insert = "INSERT INTO `$table` ". $tables . " VALUES " . $datas; 
            $sql = &$insert;
            try {                      
                    $db = getDB();
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                    $db = null;
                    return true;       
            } catch(PDOException $e) {
                    echo '{"error":{"text":'. $e->getMessage() .'}}';
                    return false;
            }
            
        }
    }
    
    static function load($name){
        
        $name.="Model";
        require(MODEL."$name.php");
        return new $name;
    }
}