<?php
namespace classes\gallery;
use classes\galeria\SimpleImage;
use classes\files\File;
//include_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
//include_once $_SERVER['DOCUMENT_ROOT'] . "/classes/ClassSimpleImage.php";
//include_once "classes/ClassAlbum.php";
/**
 * @author alf
 * @copyright 2017
 */
 
 
 /* Faz a gestão das fotos*/
 /* comprtamentos (acçao):
        rodar - roda uma foto
        
 */


class Foto{
    
    private $id=0;
    private $accao="accao";
    public $resposta;
    private $textos=array(
                "racio" => "Rácio Largura/Altura= ",
                "altura" =>"Altura= ",
                "tipo" =>"Tipo= ",
                "orienta" =>"Orientação= ",
                "largura" =>"Largura= ",
                "remember" =>"",
                "validar" =>""
    );
		private $ficherioResize;
		private $ficherioThumb;
		private $ficherioResizeHD;
		private $ficherio;
    private $info;
    private $resumo;
    
  
    private $carimboTexto="ESM GALERIA";
    private $carimboImagem="/imagens/gal.png";
    private $fonte="./fonts/HomeSchool.otf";
    private $fundo="imagens/resize.png";
    private $fundoHD="imagens/resizeHD.png";
    private $fundot="imagens/thumb.png";
    
    public function __construct($accao, $ficheiro){
    //contrutor de classe
      //echo "<br>foto imagem: " . $ficheiro;
      //echo "<br>foto url: " . _URL;
      //if (str_contains($ficheiro, 'http://')){
      $ficheiro=str_replace(_URL,$_SERVER['DOCUMENT_ROOT'],$ficheiro);
      //echo "<br>foto imagem: " . $ficheiro;
      
      //}
      $this->ficherio=$ficheiro;
			$this->ficherioResize=str_replace("albums","resizes",$ficheiro);
			$this->ficherioThumb=str_replace("albums","thumbs",$ficheiro);
			$this->ficherioResizeHD=str_replace("albums","resizeshd",$ficheiro);;
      
      //echo "entrei na foto";
      //echo $this->ficherio;
        switch($accao){
           	case "flipH":  
								$this->flip("x");
                //echo "ficheiro=".$this->ficherio;
                break;
           	case "flipV":  
								$this->flip("y");
                //echo "ficheiro=".$this->ficherio;
                break;
            case "flipB":  
								$this->flip("both");
                //echo "ficheiro=".$this->ficherio;
                break;
						case "rodarDir": 
            case "rd": 
								$this->rodar(90);
                //echo "ficheiro=".$this->ficherio;
                break;
            case "re": 
            case "rodarEsq": 
								$this->rodar(-90);
                //echo "ficheiro=".$this->ficherio;
                break;
						case "rodarA":    
								//echo "<h2>entrei no rodar</h2>";
                $this->rodarAutomatico();
								//echo "cheguei ao fim";
								//$album= new ClassAlbum("ReAlbum",$id);
                break;
            case "info":    
								//echo "<h2>entrei no rodar</h2>";
                $this->formato();
								//echo "cheguei ao fim";
								//$album= new ClassAlbum("ReAlbum",$id);		
                break;
            case "rc":
                $this->backup($this->ficherio);
                $this->backup($this->ficherioResize);
                $this->backup($this->ficherioThumb);
                $this->backup($this->ficherioResizeHD);
                $this->maxColors(2);
               break;
            case "sep":
                $this->backup($this->ficherio);
                $this->backup($this->ficherioResize);
                $this->backup($this->ficherioThumb);
                $this->backup($this->ficherioResizeHD);
                $this->sepia();
               break;
           case "ma":
                $this->backup($this->ficherio);
                $this->backup($this->ficherioResize);
                $this->backup($this->ficherioThumb);
                $this->backup($this->ficherioResizeHD);
                $this->carimbo();
               break;  
           case "mt":
                $this->backup($this->ficherio);
                $this->backup($this->ficherioResize);
                $this->backup($this->ficherioThumb);
                $this->backup($this->ficherioResizeHD);        
                $this->carimboTexto();
               break;  
            case "bl":
                //echo "blur";
                $this->backup($this->ficherio);
                $this->backup($this->ficherioResize);
                $this->backup($this->ficherioThumb);
                $this->backup($this->ficherioResizeHD);
                $this->blur("gaussian",1);
               break;  
            case "br":
                $this->backup($this->ficherio);
                $this->backup($this->ficherioResize);
                $this->backup($this->ficherioThumb);
                $this->backup($this->ficherioResizeHD);
                $this->brilho(10);
               break; 
             case "brm":
                $this->backup($this->ficherio);
                $this->backup($this->ficherioResize);
                $this->backup($this->ficherioThumb);
                $this->backup($this->ficherioResizeHD);
                $this->escurecer(10);
                break; 
            case "thumb":
                $this->thumbs();
                break;
            case "bkd":
                $this->backup($this->ficherio);
                $this->backup($this->ficherioResize);
                $this->backup($this->ficherioThumb);
                $this->backup($this->ficherioResizeHD);
                break;
            case "rt":
                $this->restore($this->ficherio);
                $this->restore($this->ficherioResize);
                $this->restore($this->ficherioThumb);
                $this->restore($this->ficherioResizeHD);
                break;
            default:
								break;
        }
    }

  
//##########################################################################################################

 	
	public function adjustar($maxWidth, $maxHeight, $ficheiroOriginal, $ficheiroDestino){
		// reduz uma imagem ajustando-a a uma dimensão
			error_reporting(E_ALL & ~E_NOTICE);
			try {
					// Create a new SimpleImage object
					$image = new SimpleImage();
					//echo "criei a class";
					// Manipulate it
					$image
						->fromFile($ficheiroOriginal)              // load parrot.jpg
					  ->bestFit($maxWidth, $maxHeight)                         // rodar 90
						->toFile($ficheiroDestino); 
				
					//echo "cheguei ao fim";
					//$album= new ClassAlbum("ReAlbum",$id);		
					} catch(Exception $err) {
					// Handle errors
						echo $err->getMessage();
					}
	}


  
     //##########################################################################################################
 
 	
	public function backup($ficheiroOriginal){
		// faz uma cópia da imagem
    
			$this->copia($ficheiroOriginal, $ficheiroOriginal."b");
	}
 
       //##########################################################################################################
 
 	
	public function brilhox($lightColor, $darkColor){
		// reduz uma imagem ajustando-a a uma dimensão
			///$this->copia($ficheiroOriginal, $ficheiroOriginal."b");
	}
  
       //##########################################################################################################
    
	
	public function blur($type = 'gaussian', $passes = 1){
		// inverter imagem
			error_reporting(E_ALL & ~E_NOTICE);
			try {
					// Create a new SimpleImage object
					$image = new SimpleImage();

				$image
						->fromFile($this->ficherioResizeHD)              // load parrot.jpg
					  ->blur($type, $passes)                            
						->toFile($this->ficherioResizeHD); 
					//echo "cheguei ao fim";
					//$album= new ClassAlbum("ReAlbum",$id);		
					} catch(Exception $err) {
					// Handle errors
						echo $err->getMessage();
					}
	}
		
  
  
     //##########################################################################################################
    
	
	public function brilho($percentagem){
		// tornar brilhante uma imagem
			error_reporting(E_ALL & ~E_NOTICE);
			try {
					// Create a new SimpleImage object
					$image = new SimpleImage();
					//echo "criei a class";

				$image
						->fromFile($this->ficherioResizeHD)              // load parrot.jpg
					  ->brighten($percentagem)                            // brilho
						->toFile($this->ficherioResizeHD); 
					//echo "cheguei ao fim";
					//$album= new ClassAlbum("ReAlbum",$id);		
					} catch(Exception $err) {
					// Handle errors
						echo $err->getMessage();
					}
	}
		
  
   //##########################################################################################################
    
	
	public function carimbo(){
		// inverter imagem
			error_reporting(E_ALL & ~E_NOTICE);
			try {
					// Create a new SimpleImage object
					$image = new SimpleImage();
        //throw new \Exception(new SimpleImage(), self::ERR_FILE_NOT_FOUND);
	        //echo "Carimbar: ".$this->ficherioResizeHD . " fim do carimbar<br>";
        $this->carimboImagem=$_SERVER['DOCUMENT_ROOT'] ."/" . $this->carimboImagem;
				$image
						->fromFile($this->ficherioResizeHD)              // load parrot.jpg
					  ->overlay($this->carimboImagem, "bottom right")                            // carimbo 90
						->toFile($this->ficherioResizeHD); 
        
        $image
						->fromFile($this->ficherio)              // load parrot.jpg
					  ->overlay($this->carimboImagem, "bottom right")                         // rodar 90
						->toFile($this->ficherio); 
				
					$image
						->fromFile($this->ficherioResize)              // load parrot.jpg
					  ->overlay($this->carimboImagem, "bottom right")                    // rodar 90
						->toFile($this->ficherioResize); 
				
					$image
						->fromFile($this->ficherioThumb)              // load parrot.jpg
					  ->overlay($this->carimboImagem, "bottom right")                        // rodar 90
						->toFile($this->ficherioThumb); 
				
				
        
					//echo "cheguei ao fim";
					//$album= new ClassAlbum("ReAlbum",$id);		
					} catch(Exception $err) {
					// Handle errors
						echo $err->getMessage();
					}
	}
		
  //##########################################################################################################
  
  	public function carimboTexto(){
		// inverter imagem
			error_reporting(E_ALL & ~E_NOTICE);
			try {
					// Create a new SimpleImage object
					$image = new SimpleImage();

        $option['anchor']="bottom right";
        $option['fontFile']=$this->fonte;
				$image
						->fromFile($this->ficherioResizeHD)              // load parrot.jpg
					  ->text($this->carimboTexto, $option)                            // rodar 90
						->toFile($this->ficherioResizeHD); 
					//echo "cheguei ao fim";
					//$album= new ClassAlbum("ReAlbum",$id);		
					} catch(Exception $err) {
					// Handle errors
						echo $err->getMessage();
					}
	}
 	
  //##########################################################################################################
  
	public function copia($ficheiroOriginal, $ficheiroDestino){
		// reduz uma imagem ajustando-a a uma dimensão
			error_reporting(E_ALL & ~E_NOTICE);
			try {
					// Create a new SimpleImage object
					$image = new SimpleImage();
          $fc= new File();
          //verifica se o ficheiro origem existe
          if ($fc->existeFicheiro($ficheiroOriginal)){
            //se existir
            //echo "Ficheiro original existe";
            //verifica se o ficheiro destino existe
            if ($fc->existeFicheiro($ficheiroDestino)){
              //se existir apaga o ficheiro destino
              //echo "Ficheiro Destino existe";
              $fc->deleteFiles($ficheiroDestino);
              //echo "tentar apagar: " . $fc->getMsg();
            }
					  $image
						  ->fromFile($ficheiroOriginal)              // load parrot.jpg                        // rodar 90
						  ->toFile($ficheiroDestino); 
				
					//echo "cheguei ao fim";
					
          }
            
            
					
					} catch(Exception $err) {
					// Handle errors
						echo $err->getMessage();
					}
	}
  
      //##########################################################################################################
    
	
	public function escurecer($percentagem){
		// tornar escura uma imagem
			error_reporting(E_ALL & ~E_NOTICE);
			try {
					// Create a new SimpleImage object
					$image = new SimpleImage();
					//echo "criei a class";

				$image
						->fromFile($this->ficherioResizeHD)              // load parrot.jpg
					  ->darken($percentagem)                            // brilho
						->toFile($this->ficherioResizeHD); 
					//echo "cheguei ao fim";
					//$album= new ClassAlbum("ReAlbum",$id);		
					} catch(Exception $err) {
					// Handle errors
						echo $err->getMessage();
					}
	}
  
  
  //##########################################################################################################
	
	public function flip($dir){
		// inverter imagem
			error_reporting(E_ALL & ~E_NOTICE);
			try {
					// Create a new SimpleImage object
					$image = new SimpleImage();
					//echo "criei a class";
					// Manipulate it
					$image
						->fromFile($this->ficherio)              // load parrot.jpg
					  ->flip($dir)                         // rodar 90
						->toFile($this->ficherio); 
				
					$image
						->fromFile($this->ficherioResize)              // load parrot.jpg
					  ->flip($dir)                         // rodar 90
						->toFile($this->ficherioResize); 
				
					$image
						->fromFile($this->ficherioThumb)              // load parrot.jpg
					  ->flip($dir)                         // rodar 90
						->toFile($this->ficherioThumb); 
				
				$image
						->fromFile($this->ficherioResizeHD)              // load parrot.jpg
					  ->flip($dir)                         // rodar 90
						->toFile($this->ficherioResizeHD); 
					//echo "cheguei ao fim";
					//$album= new ClassAlbum("ReAlbum",$id);		
					} catch(Exception $err) {
					// Handle errors
						echo $err->getMessage();
					}
	}
		
  
   //##########################################################################################################
  
	public function formato(){
		// Rodar para a direita
			// Create a new SimpleImage object
			$image = new SimpleImage();
			//echo "criei a class";
					// Manipulate it
    
      $image->fromFile($this->ficherio) ;
      $this->setInfo('racio', $this->textos['racio'] . $image->getAspectRatio()); 
      $this->setInfo('altura', $this->textos['altura'] . $image->getHeight()); 
      $this->setInfo('largura', $this->textos['largura'] . $image->getWidth()); 
      $this->setInfo('tipo', $this->textos['tipo'] . $image->getMimeType()); 
      $this->setInfo('orienta', $this->textos['orienta'] . $image->getOrientation()); 
      $this->setInfoResumo();
      //$this->getInfoResumo();
	}
		
   //##########################################################################################################
	
	public function sepia(){
		// reduz as cores
			error_reporting(E_ALL & ~E_NOTICE);
			try {
					// Create a new SimpleImage object
					$image = new SimpleImage();
	
				$image
						->fromFile($this->ficherioResizeHD)              // load parrot.jpg
					  ->sepia()                            // rodar 90
						->toFile($this->ficherioResizeHD); 
					//echo "cheguei ao fim";
					//$album= new ClassAlbum("ReAlbum",$id);		
					} catch(Exception $err) {
					// Handle errors
						echo $err->getMessage();
					}
	}
		
  
   //##########################################################################################################
	
	public function maxColors($max){
		// reduz as cores
			error_reporting(E_ALL & ~E_NOTICE);
			try {
					// Create a new SimpleImage object
					$image = new SimpleImage();
	
				$image
						->fromFile($this->ficherioResizeHD)              // load parrot.jpg
					  ->maxColors($max)                            // rodar 90
						->toFile($this->ficherioResizeHD); 
					//echo "cheguei ao fim";
					//$album= new ClassAlbum("ReAlbum",$id);		
					} catch(Exception $err) {
					// Handle errors
						echo $err->getMessage();
					}
	}
		
  
  //##########################################################################################################
	
	public function getInfo($param){
		// devolve um parametro da imagem
    
    return $this->Info[$param];
	}
	
//##########################################################################################################
	
	public function getInfoResumo(){
		// devolve a informação de resumo da imagem
   return $this->resumo;
	}
  
  //##########################################################################################################
 
 	
	public function restore($ficheiroOriginal){
		// reduz uma imagem ajustando-a a uma dimensão
			$this->copia($ficheiroOriginal."b", $ficheiroOriginal);
	}
 
 
  
  
  
//##########################################################################################################
	
	public function rodarDir(){
		// Rodar para a direita
			$this->rodar(90);
	}
		
 
 //##########################################################################################################
	
	public function rodarAutomatico(){
		// Rodar para a direita
			error_reporting(E_ALL & ~E_NOTICE);
			try {
					// Create a new SimpleImage object
					$image = new SimpleImage();
					//echo "criei a class";
					// Manipulate it
					$image
						->fromFile($this->ficherio)              // load parrot.jpg
					  ->autoOrient()                         // rodar 90
						->toFile($this->ficherio); 
				
					$image
						->fromFile($this->ficherioResize)              // load parrot.jpg
					  ->autoOrient()                         // rodar 90
						->toFile($this->ficherioResize); 
				
					$image
						->fromFile($this->ficherioThumb)              // load parrot.jpg
					  ->autoOrient()                         // rodar 90
						->toFile($this->ficherioThumb); 
				
				$image
						->fromFile($this->ficherioResizeHD)              // load parrot.jpg
					  ->autoOrient()                         // rodar 90
						->toFile($this->ficherioResizeHD); 
					//echo "cheguei ao fim";
					//$album= new ClassAlbum("ReAlbum",$id);		
					} catch(Exception $err) {
					// Handle errors
						echo $err->getMessage();
					}
	}
		 
  
//##########################################################################################################
	
	public function rodar($angulo=90){
		// Rodar para a direita
			error_reporting(E_ALL & ~E_NOTICE);
			try {
					// Create a new SimpleImage object
					$image = new SimpleImage();
					//echo "criei a class";
					// Manipulate it
					$image
						->fromFile($this->ficherio)              // load parrot.jpg
					  ->rotate($angulo)                         // rodar 90
						->toFile($this->ficherio); 
				
					$image
						->fromFile($this->ficherioResize)              // load parrot.jpg
					  ->rotate($angulo)                         // rodar 90
						->toFile($this->ficherioResize); 
				
					$image
						->fromFile($this->ficherioThumb)              // load parrot.jpg
					  ->rotate($angulo)                         // rodar 90
						->toFile($this->ficherioThumb); 
				
				$image
						->fromFile($this->ficherioResizeHD)              // load parrot.jpg
					  ->rotate($angulo)                         // rodar 90
						->toFile($this->ficherioResizeHD); 
					//echo "cheguei ao fim";
					//$album= new ClassAlbum("ReAlbum",$id);		
					} catch(Exception $err) {
					// Handle errors
						echo $err->getMessage();
					}
	}
		

//##########################################################################################################
	
	public function setInfo($param, $valor){
		// Adiciona informação sobre a imagem
    
    $this->Info[$param]=$valor;
	}
	
//##########################################################################################################
	
	public function setInfoResumo(){
		// Adiciona informação sobre a imagem
    $txt="";
    //print_r($this->Info);
    foreach ($this->Info as $info1){
      $txt.=$info1 . "\n";
    }
    
     $this->resumo=$txt;
	}

  
   //##########################################################################################################
	
	public function thumbs(){
		// inverter imagem
			error_reporting(E_ALL & ~E_NOTICE);
			try {
					// Create a new SimpleImage object
					$image = new SimpleImage();
					//echo "criei a class";
					// Manipulate it
					//$image
						//->fromFile($this->ficherio)              // load parrot.jpg
					  //->thumbnail(_RESIZE_LARGURA,_RESIZE_ALTURA)                         // rodar 90
						//->toFile($this->ficherio); 
				  //echo $this->ficherio;
					//$image
						$image->fromFile($this->ficherio);              // load parrot.jpg
            //echo "passo 2";
        //echo _RESIZE_ALTURA;
					  $image->fitIn(_RESIZE_LARGURA,_RESIZE_ALTURA); 
        //echo "passo 3";// rodar 90
            //->toFile($this->ficherioResize) 
            //->fromFile($this->fundo)
            //->overlay($this->ficherioResize)  
            $image->toFile($this->ficherioResize);
           //echo "<br>detino: ". $this->ficherioResize;
					$image
						->fromFile($this->ficherio)              // load parrot.jpg
					  ->fitIn(_THUMB_LARGURA,_THUMB_ALTURA)    
            
						//->toFile($this->ficherioThumb) 
				    //->fromFile($this->fundot)
            //->overlay($this->ficherioThumb)  
            ->toFile($this->ficherioThumb);
         //echo $this->ficherioThumb;
				$image
						->fromFile($this->ficherio)              // load parrot.jpg
					  //->fitIn(_RESIZEHD_LARGURA,_RESIZEHD_ALTURA)   
             ->thumbnail(_RESIZEHD_LARGURA,_RESIZEHD_ALTURA,'top' ) 
						//->toFile($this->ficherioResizeHD)
            //->fromFile($this->fundoHD)
            //->overlay($this->ficherioResizeHD)  
            ->toFile($this->ficherioResizeHD);
					//echo "cheguei ao fim";
					//$album= new ClassAlbum("ReAlbum",$id);		
					} catch(Exception $err) {
					// Handle errors
						echo $err->getMessage();
					}
	}
		 
  
  
}
//###########################################################################################################
// Casos de utilização
// 
//echo "ok";

?>
