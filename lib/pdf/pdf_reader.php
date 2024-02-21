<?php 
	$path = $_GET['path']; 
	//echo $path ; 
	$file1 = $path;
	header('Content-type:application/pdf');
	header('Content-description:inline; filename="'.$file1.'"'); 
	header('Content-Tranfer-Encoding:binary');
	header('Accept-ranges:bytes');
	@readfile($file1);
?>