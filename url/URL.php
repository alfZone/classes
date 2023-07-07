<?php
namespace classes\url;

/**
 * the idea of this class is to manipulate url
 * @author António Lira Fernandes
 * @version 1.1
 * @updated 2022-03-12
 */


class URL{

    private $aux;
    //class constructor 
    public function __construct(){
        $this->aux=explode("/",$_REQUEST['uri']);
    }

    public function getUrlPart($pos,$order="normal"){
        $aux=explode("/",$_REQUEST['uri']);
        if ($order=="normal"){
            return $this->aux[$pos];
        }else{
            return $this->aux[sizeof($this->aux)-$pos];
        }
        
    }


}

