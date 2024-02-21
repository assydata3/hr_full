<?php 
require_once __DIR__.'/../00_Basic/connect.php' ; 
use Connect\connect\conn_db ; 

class convert_data {
    
    public function area_folder($area){
        $area_array = array(
            'MAIN LINE'  => '01.MAIN LINE',
            'SUB LINE 1' => '02.SUB LINE 1',
            'SUB LINE 2' => '03.SUB LINE 2',
            'SUB LINE 3' => '04.SUB LINE 3',
            'SUB LINE 4' => '05.SUB LINE 4'
          );
        
        if($area== '') { $area_find = 'Unknow' ;    }
        else {  if(isset($area_array[$area])) $area_find = $area_array[$area] ; else $area_find = '' ;  }
        return $area_find ; 
    }


    public function folder2area($folder){
        $area_array = array(
            '01.MAIN LINE'	=> 'MAIN LINE', 
            '02.SUB LINE 1' => 'SUB LINE 1', 
            '03.SUB LINE 2' => 'SUB LINE 2', 
            '04.SUB LINE 3' => 'SUB LINE 3',
            '05.SUB LINE 4' => 'SUB LINE 4'
          );
        
        if($folder== '')  $area_find = 'Unknow' ;    
        else {  if(isset($area_array[$folder])) $area_find = $area_array[$folder] ; else $area_find = '' ;  }
        return $area_find ; 
    }


  

   
}



?>