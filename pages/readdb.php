<?php 

require_once __DIR__.'/../lib/class/00_Basic/tool.php'; 
$tool = new tool_support ; 



$data = $tool->read_db( $connect = mysqli_connect('assydata3','SuperAdmin','123456','assy') ,
                        $query   = "SELECT defect_code, defect_name FROM defect_code" , 
                        $title   = array('def_code','def_name')
                       ); 

$tool->show_array($data); 

?>