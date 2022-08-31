<?php
namespace classes\errors;

/**
 * the idea of this class is provide a log system that writes on a file.
 * @author António Lira Fernandes
 * @version 1.0
 * @updated 2022-08-31
 * https://github.com/alfZone/DataBase/blob/main/Database.php
 */

// problems detected
// 

// roadmap
// 

//news of version: 
//   

// REQUIRES
	
// MISSION: provide a log system that writes on a file
  
// METHODS
// __construct($user, $pass, $dbname, $host="localhost") - Class Constructor. $user is the database username, $pass is the database password, $dbname is the database name, 
//                                                         and $host is an optional parameter for the location of the database server (usually this is localhost)
// listTables()  - prepare a list of existing tables in the database.
// resultset() -  return an array with the last result for an action


class Log{
      
    private $file= "/2do/log/log.txt";

    //class constructor 
    public function __construct($msg){
        $this->file=$_SERVER['DOCUMENT_ROOT'] . $this->file; 
        //echo $this->file;
        //print_r($_SERVER);
        file_put_contents($this->file, date("Y-m-d H:i:s") . " - " . $_SERVER['REQUEST_URI'] . " - " . $msg . PHP_EOL, FILE_APPEND);
    }

    //#########################################################################################################################################
    // set file path and name
    public function setFile($file){
        $this->file=$file;
    }

     //#########################################################################################################################################
    // delete log file
    public function deleteFile(){
        unlink($this->file);
    }
    
     
}
