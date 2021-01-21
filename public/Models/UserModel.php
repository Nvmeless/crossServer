<?php 


class UserModel extends Model{

    public $table = 'users';

    function getPage($params = null){
        if($params !== null){
            $this->get(['id' => $params['id']]);
        }
    }
    function getAll($params = array() ){
        return $this->find();
    }
    function createUser($data){
        $this->post($data);
    }
}