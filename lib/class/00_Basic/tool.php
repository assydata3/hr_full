<?php 

class tool_support {
   
    public function list_folder_file($folder){
        $list = array(); $i =  0 ; 
        $dir    = $folder;
        $files1 = scandir($dir);
        $r=0 ; 
        while(isset($files1[$r])){
            $txt = $files1[$r];
            $path_check = $folder.'/'.$txt;
            if(!is_file($path_check) and ($txt <> '..') and ($txt <> '.')){
                //echo $txt.'<br>';
                $i++; 
                $list[$i] = $txt;  
            }
            $list['count'] = $i ; 
        $r++; 
        }
        return $list ; 
    }


    public function show_array($array){
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

    public function make_folder($path){
        #### check exist path and Make Folder
        if (!is_dir( $path) ) {
            mkdir($path);       
        }

    }

    public function make_path($path_origin,$path_data){
        $path_full = $path_origin ; 
        foreach($path_data as $path_temp){
            $path_full = $path_full.'/'.$path_temp ;
            $this->make_folder($path_full)  ;  
        }
        return $path_full ; 
    }



    public function read_db($connect,$query,$title){
        $result = mysqli_query($connect,$query) ; 
        $data = array(); $k = 0 ; 
        while($row = mysqli_fetch_array($result)){
            $k++ ;   $t = 0 ; 
            foreach($title as $tt){
                $data_temp = $row[$t]; 
                $data[$k][$tt] = $data_temp ; 
                $t++; 
            }
            
        }
        $data['count']= $k ; 
        return $data ; 
    }


}





?>