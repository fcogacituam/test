
<?php
class Student{

    public $name;
    public $minutes;
    public $days;
    function __construct(){
    }


    public function createStudent($name,$students){

        $this->name = str_replace(array("\r\n","\r"),"",$name);
        $this->minutes = 0;
        $this->days = [];

        return $this;
    
    }

    public function validateAndProcessData($line,$student){
       
        $start = date_create($line[3]);
        $end = date_create($line[4]);
        if(!in_array($line[2],(array)$student->days)){ //llenar array de dias
            array_push($student->days,$line[2]);        
        }
        if($minutes = $this->validPresence($start,$end)){
            $student->minutes +=  $minutes;
        }
        return $student;

    }

    private function validPresence($start,$end){
        if($start < $end){ //validar que fecha de fin sea mayor a la de inicio
            $diff= date_diff($end,$start);
            $hours= $diff->format('%h');
            $minutes = ($diff->format('%h')*60) + $diff->format('%i');
            if($minutes < 5){ // ignorar presencias de menos de 5 minutos
                return false;
            }
        }else{
            return false;
        }
        return $minutes;
    }


}
?>