<?php

require 'Classes/class.student.php';
require 'Classes/class.file.php';
require 'Classes/class.report.php';
$students=[];

if(isset($argv[1])){
    $path =  $argv[1];
    $reporte = new Report();
    $reporte->start($path);
   
}else{
    die("Debes ingresar un archivo como parámetro. (php reporte.php <nombre.txt>) \n");
}



?>