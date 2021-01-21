<?php


class User extends Controller {

    var $models = array('User');

    function index(){
        $d =array();
        
        $d['Users'] = $this->User->getAll();
        $this->set($d);
        $this->render('index');
        
    }

    function page($id){
        $d['User'] = $this->User->find([
            'conditions' => '`id` = "'.$id.'"',
            ]);
            $this->set($d);
            $this->render('page');
    }
    function delete($id){
        $this->User->delete(['id' => $id]);
    }


}