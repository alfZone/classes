<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../autoload.php';

use classes\errors\Log;


$l=new Log("aaaa");

$l->deleteFile();

$l=new Log("aaaa");

?>
