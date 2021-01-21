<?php 
class Controller {
    
    var $vars = array();
    var $layout = 'default';

    function __construct(){
        if(RR::eiset($_POST)){
            $this->posted_data = $_POST;
        }
        if(RR::eiset($this->models)){
            foreach($this->models as $v){
                $this->loadModel($v);
            }

        }
    }
    public function set($d){
        $this->vars = array_merge($this->vars,$d);
    }

    public function render(string $filename){
        extract($this->vars);
        ob_start();
        require(VIEW.get_class($this).'/'.$filename.'.php');    
        $contentForLayout = ob_get_clean();
        if($this->layout == false){
            echo $contentForLayout;
        }
        else{
            require(VIEW.'Layouts/'.$this->layout.'.php');
        }
    }
    public function loadModel( string $name){
        $this->$name = Model::load($name);
    }

}