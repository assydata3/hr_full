<?php 

namespace Connect\connect ;

class conn_db{
    const host_assy2 = 'assydata2' ; 
    const user_assy2 = 'SuperAdmin2' ; 
    const pass_assy2 = '123456'; 
 

    public function conn_sys(){
      $host = self::host_assy2 ; 
      $user = self::user_assy2 ; 
      $pass = self::pass_assy2 ;
      $db = 'sys_data' ; 
      $connect = mysqli_connect($host ,$user,$pass,$db); 
      return $connect ; 
    }


}

?>