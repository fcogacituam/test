<?php

class Report{

    public $students;


    function __construct(){
        $this->students =[];
    }

    public function start($path){
        $file = new File($path);
        $file->validate();

        $lines = $file->convertToArray();
        foreach($lines as $line){
            if($line && count($line)>0){
                if($line[0] == "Student"){
                    $name = str_replace(array("\r\n","\r"),"",$line[1]);
                    $this->createStudentIfNotExist($name);
                }
                else if($line[0] == "Presence"){
                    $this->processPresence($line);
                }   
            }
        }
        $this->sortStudents();
        $this->printResult();
    }
    private function createStudentIfNotExist($name){
        $key = $this->searchForName($name,$this->students);
        if(!isset($key)){
            $new_student = new Student;
            $new_student = $new_student->createStudent($name,$this->students);
            array_push($this->students, (array) $new_student);
        }
    }
    private function searchForName($name, $array) {
        $found = false;
        $index;
        foreach ($array as $key => $val) {
            if ($val['name'] === $name) {
                $found= true;
                $index = $key;
            }
        }
        if($found){
            return $index;
        }else{
            return null;
        }
        
    }
    private function processPresence($line){
    
        $indexStudent = $this->searchForName($line[1],$this->students);
        if(isset($indexStudent)){ //si existe el alumno
            $student = new Student();
            $this->students[$indexStudent] = (array) $student->validateAndProcessData($line,(object) $this->students[$indexStudent]);
        }else{ // Si no existe el alumno, lo creo y proceso los datos
            $this->createStudentIfNotExist($line[1]);
            $this->processPresence($line);
        } 
    }
    
    
    private function printResult(){
        $out;
        foreach($this->students as $student){
            $out = "{$student['name']}: {$student['minutes']} minutes ";
            if(count($student['days']) > 0){
                $out .= "in ". count($student['days']);
                if( count($student['days']) == 1){
                    $out .= " day";
                }else if(count($student['days']) > 1){
                    $out .= " days";
                }
            }
            echo $out."\n";
        }
    }
    private function sortStudents(){
        foreach($this->students as $key=> $fila){
            $minutes[$key] = $fila['minutes'];
        }
        array_multisort($minutes,SORT_DESC,$this->students);
    }
}

?>