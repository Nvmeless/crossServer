<?php 


class UserModel extends Model{

public $table = 'users';

function getPage($params = null){
    if($params !== null){

        $this->get(['id' => $params['id']]);

        echo $this->username;
    }
    function createUser($data){
        echo 'User Créé'; 
        $this->post($data);
    }
}