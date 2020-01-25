<?php
class File{

    private $max_size;
    public $path;
    public $type;
    public $lines;

    function __construct($path){
        $this->max_size= 2000; // 2 Mb
        $this->path = $path;
        $this->type="txt";
        $this->lines = [];
    }

    public function validate(){
        if(file_exists($this->path) && is_file($this->path)){

            $size = filesize($this->path)/1000;
            $ext = pathinfo($this->path, PATHINFO_EXTENSION);
            
            if($size > $this->max_size){
                die("El archivo no puede ser mayor a 2Mb \n");
            }
            if($ext != $this->type){
                die("El archivo debe tener extensión .txt \n");
            }
        }else{
            die("No existe el archivo {$this->path} \n");
        }
    }

    public function convertToArray(){
        $myfile = fopen($this->path, "r") or die("Ups! no se pudo abrir el archivo \n");

        while(!feof($myfile)) {
            $line = explode(" ",fgets($myfile));
            array_push($this->lines, $line);
        }
        fclose($myfile);
        return $this->lines;

    }


}

?>