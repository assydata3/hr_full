<?php 


class support {
    
    public function auto_crr($value,$change){
        if(isset($value)) $data = $value ; 
        else $data = $change  ; 
        return $data ; 
    }

    public function curr_domain(){
        $host = $_SERVER['HTTP_HOST']; 
        $current_domain = "http://$host"; 
        return $current_domain ; 
    }



}



?>