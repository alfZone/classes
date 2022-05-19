<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../bootstrap.php';
//echo __DIR__;
use classes\files\File;
use classes\galeria\SimpleImage;

/*
$f=new File();

if ($f->existeFicheiro(__DIR__ . "../../fotos/resizes/2021/bbbn")){
  echo "existe o ficheiro";
}else {
  echo "não existe o ficheiro";
}

$f->makeDir("../../fotos/resizes/2021/bbbns");
*/

$image = new SimpleImage();

$image->fromFile("/var/www/html/galeriaview/fotos/albums/2021/hhhh/15530837_ggfiD.jpeg"); 
$image->toFile("/var/www/html/galeriaview/fotos/albums/2021/hhhh/aaabbbcc.jpeg"); 

?>
