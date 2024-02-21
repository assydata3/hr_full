<?php 

$connect = mysqli_connect('assydata3','SuperAdmin','123456','assy') ; 
$sql = "SELECT * FROM defect_code" ; 
$result = mysqli_query($connect,$sql) ; 
while($row = mysqli_fetch_array($result)){
    print_r($row); 
    echo '<br>'; 
}



?>