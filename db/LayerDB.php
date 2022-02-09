<?php
namespace classes\db;
use classes\db\Database;

/**
 * this classe implements a generic web service able to read a sql query and return an array or a json string.
 * @author António Lira Fernandes
 * @version 1.3
 * @updated 2021-12-24
 */

//Methods
//public function __construct($action, $parameters="") - Class constructor where which $action is a string with the name of an action and $parameters an array 
//                                                       with the parameters we want to pass to be used in the query
//public function doAction($accao, $parameters="") - executing an action, typically reading a SQL string and applying the parameters as filters.
//public function execQuery($query, $parameters) - execute a sql query (insert, delete and update) with the parameters
//public function execQueryTrace($query, $parameters) - execute a sql query with debug (insert, delete and update) with the parameters
//private function findParameters($text, $sep=":")  - decompose a string (text) into an array, using sep as a separator
//public function getQuery($query, $parameters) - read a sql query (select) with the parameters
//public function lastInsertId() - last insert key
//public function webService() takes the result array and creates a json

//changes:
// documentations    

//2do
// improve Action's method to look at SQL and decide whether to execute or read query. Make the decision based on the use of select or insert, update or delete

ini_set("error_reporting", E_ALL);

//include_once $_SERVER['DOCUMENT_ROOT'] . "/forum/config.php";
//include_once $_SERVER['DOCUMENT_ROOT'] . "/classes/ClassDatabase.php";


abstract class LayerDB {
 
  public $instrucaoSQL = array ("ActionName" => 'SELECT * FROM tableName;');
  public $results;  
  public $lastId;
  public $rowCount;
 
 public function __construct($accao="", $parameters=""){
    $this->doAction($accao, $parameters);
  } 
  
  
 abstract   public function doAction($accao, $parameters="");
 /*
 {
  switch ($accao){
      case "ActionName":
            $this->execQuery($accao, $parameters);
            break;
      case "ActionName2":
            $this->getQuery($accao, $parameters);
            break;
      case "ActionName3":
      case "listUsAct":
            //Other functions
            break;  
      default:
          break;
    }

  }*/
 
  
  //##########################################################################################################################################################################
  
    private function findParameters($text, $sep=":"){
      $parts=explode($sep, $text);
      //echo ($text);
      //print_r($parts);
      $parameters=[];
      for ($i=1; $i< sizeof($parts); $i++){
        $aux=explode(" ", $parts[$i]);
        $aux=explode(",", $aux[0]);
        $aux=explode(")", $aux[0]);
        $aux=explode("%", $aux[0]);
        $aux=explode('"', $aux[0]);
        $aux=explode(';', $aux[0]);
        $parameters[$i-1]=$aux[0];
      }
      return $parameters;
    }
  
   
  public function getLastId(){
    return $this->lastId;
  }
  
 //##########################################################################################################################################################################
  
  public function webService(){
    
    return json_encode($this->results, JSON_UNESCAPED_UNICODE);
    
  }
  
 //##########################################################################################################################################################################
  
  public function execQuery($query, $parameters){
    $database = new Database(_BDUSER, _BDPASS, _BD);
    $database->query($this->instrucaoSQL[$query]);
    
    //bind
    //echo "abc"; 
    //echo $this->instrucaoSQL[$query];
    $par=$this->findParameters($this->instrucaoSQL[$query], ":");
    //print_r($par);
    //print_r($parameters);
    foreach ($par as $para){
      $database->bind(':' . $para, $parameters[$para]);
    }
 
    $database->execute();
    //echo $database->debugDumpParams();
    $this->lastId=$database->lastInsertId();
    $this->rowCount=$database->rowCount();
    $this->results[0]['lastId']=$database->lastInsertId();
    $this->results[0]['numRows']=$database->rowCount();
    //$this->lastId=
  }
  
 //##########################################################################################################################################################################
  
  public function getQuery($query, $parameters){
    $database = new Database(_BDUSER, _BDPASS, _BD);
    $database->query($this->instrucaoSQL[$query]);
    
    //bind
    //echo "abc"; 
    $par=$this->findParameters($this->instrucaoSQL[$query], ":");
    //print_r($par);
    //print_r($parameters);
    //print_r($this->instrucaoSQL[$query]);
    if ($par!=""){
      foreach ($par as $para){
        //print_r($para);
        $database->bind(':' . $para, $parameters[$para]);
      }  
    }
    
    //$database->execute();
        
//echo $database->debugDumpParams();
    $rs=$database->resultset();
    $i=0;
    //echo "aqui"; `idAccount`, `account`
    foreach ($rs as $linha){
      //echo "aqui";
      $this->results[$i]=$linha;
      $i++;
    }
    $this->results[0]['numElements']=$i;
    
  }
    
 

//#########################################################################################################################################################################################################
  public function execQueryTrace($query, $parameters){
    $database = new Database(_BDUSER, _BDPASS, _BD);
    $database->query($this->instrucaoSQL[$query]);
    
    //bind
    //echo "abc"; 
    //echo $this->instrucaoSQL[$query];
    $par=$this->findParameters($this->instrucaoSQL[$query], ":");
    //print_r($par);
    //print_r($parameters);
    foreach ($par as $para){
      $database->bind(':' . $para, $parameters[$para]);
    }
 
    $database->execute();
    //echo $database->debugDumpParams();
    $this->lastId=$database->lastInsertId();
    $this->rowCount=$database->rowCount();
    $this->results[0]['lastId']=$database->lastInsertId();
    $this->results[0]['numRows']=$database->rowCount();
    $database->debugDumpParams();
    
  }

}

?>
