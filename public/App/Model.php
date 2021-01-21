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
    
    
    public function find($params = array()){
        $conditions = "1=1";
        $fields = "*";
        $limit = "";
        $order = "`id` DESC";
        
        $params = $this->tableChecker($params);
        if(RR::eiset($params['table'])){
            $params['table'] = $this->dbPrefix . $params['table'];
            if(RR::eiset($params['conditions'])){$conditions = $params['conditions'];}
            if(RR::eiset($params['fields'])){$conditions = $params['fields'];}
            if(RR::eiset($params['limit'])){$conditions = $params['limit'];}
            if(RR::eiset($params['order'])){$conditions = $params['order'];}
            $sql = "SELECT $fields FROM ".$params['table']." WHERE $conditions ORDER BY $order $limit"; 
            try {                      
                $db = getDB();
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $raw = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $db = null;
                //var_dump($raw);
                return $raw;       
            } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}';
                return false;
            }
        }
        else{
            //erreur
        }
    }
    public function delete($params = array()){
        if(RR::eiset($params['id'])){
            $sql = "DELETE FROM " . $this->dbPrefix . $this->table .  " WHERE `id` = \"".$params['id']."\"";
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
    public function save($params = array()){
        $params = $this->tableChecker($params);

        if(RR::eiset($params['table'])){
            $table = $this->dbPrefix . $params['table'];
            if((RR::eiset($params['id']))){
                $sql = "UPDATE ".$table." SET ";
                foreach($params as $key=>$value){

                    if($key !== 'table'){
                        $sql .="`$key`='$value',";
                    }
                }
                $sql = substr($sql, 0, -1);
                $sql .= " WHERE id=".$params['id'];
            }
            else{

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
            }
            try {            
                echo $sql;          
                $db = getDB();
                $stmt = $db->prepare($sql);
                $stmt->execute();
                if( true !== RR::eiset($params['id'])){
                   $this->id = $db->lastInsertId();
                    echo "Hey :". $this->id;
                }
                $db = null;
                return true;       
            } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}';
                return false;
            }
        }
    }

    public function tableChecker($params = array()){
        if(RR::eiset($params['table'])){
            unset($params['table']);
            return $params = ['table' => $this->table] + $params;
        }
        if(RR::eiset($this->table)){
            return $params = ['table' => $this->table] + $params;
        }
        else{
            //error
        }
    
    }
    static function load($name){
        
        $name.="Model";
        require(MODEL."$name.php");
        return new $name;
    }
}