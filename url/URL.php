<?php
namespace classes\url;

/**
 * the idea of this class is to manipulate url
 * @author António Lira Fernandes
 * @version 1.2
 * @updated 2024-03-12
 */


class URL{

    private $aux;
    //class constructor 
    public function __construct(){
        if (isset($_REQUEST['uri'])){
            $this->aux=explode("/",$_REQUEST['uri']);
        }else{
            $this->aux=explode("/",$_SERVER['REQUEST_URI']);
        }
        //print_r($this->aux);
    }

    public function getUrlPart($pos,$order="normal"){
        //$aux=explode("/",$_REQUEST['uri']);
        if ($order=="normal"){
            return $this->aux[$pos]=="" ? 0 : $this->aux[$pos];
        }else{
            return $this->aux[sizeof($this->aux)-$pos];
        }
        
    }


}
