<?php 
require_once(__DIR__ . '/excel/vendor/autoload.php');
require_once __DIR__.'/../00_Basic/connect.php'; 
use Connect\connect\conn_db;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class excel{
        
    public function read_file($file){
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $data_value = array() ;  $k = 0 ; 
        // Store data from the activeSheet to the varibale in the form of Array
        $data = array(1,$sheet->toArray(null,true,true,true));
        $data_real = $data[1] ;
        foreach($data_real as $value){
           $check = $value['A'] ; 
           if($check != ''){
                $k++ ; 
                $data_value[$k] = $value ; 
           }
          
        }
        $data_value['count'] = $k ; 
        return $data_value; 
    }


    public function excel_read_insert($file,$sql_delete,$column_value_delete,$sql_insert,$title_row,$column_select,$no_incre,$show_query){
        #### SETTING 
        $connection    = new conn_db ; 
        $connect       = $connection->conn_excel(); 

        ##### READ DATA 
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $data_value = array() ;  $k = 0 ; 
        $data = array(1,$sheet->toArray(null,true,true,true));
        $data_real = $data[1] ;
        foreach($data_real as $value){
           $k++ ; 
           $data_value[$k] = $value ; 
        }


        ### DELETE OLD DATA 
        $delete_value = $data_value[$title_row+1][$column_value_delete] ; 
        $query_delete_total = $sql_delete."'$delete_value'" ; 
        if($sql_delete != ''){
            if($show_query == True) { echo $query_delete_total.'<br>' ;  }
            mysqli_query($connect,$query_delete_total);
        }

        ### SELECT DATA AND INSERT DATABASE 
        if($no_incre == True) $query = " VALUES  (NULL," ;  else $query = " VALUES  (" ; 
        $row = $title_row + 1 ; 
        $len_column = count($column_select) ;
        for($i=$row;$i<=$k;$i++){
            $value = $data_value[$i] ; 
            $query_temp = $query ; 
            for($j=0;$j<$len_column-1;$j++){
                $index_column = $column_select[$j] ; 
                $dt = $value[$index_column] ; 
                $query_temp = $query_temp."'$dt'," ; 
            }

            $index_last = $column_select[$len_column-1]; 
            $dt_last = $value[$index_last] ; 
            $query_temp = $query_temp."'$dt_last');";   
            $query_total = $sql_insert.$query_temp ; 
            
            if($show_query==True){echo $query_total.'<br>' ; }
            

            $check_null = $value['A'] ; 
            if($check_null !=''){
                mysqli_query($connect,$query_total); 
            }
            

           

        }

        
    }
        






    #### Export excel From Database 
    public function export_excel($file_name,$sheet_name,$stt,$title,$sql_query,$save_url){
        $master_column = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ') ; 
        $connection    = new conn_db ; 
        $connect       = $connection->conn_excel(); 
        $count_column  = count($title) ; 

        ### STARTING
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle($sheet_name);

        ### TITLE
        $rowCount = 1; 
        if($stt){
            $sheet->setCellValue('A'.$rowCount,'stt');
            for($i=1;$i<=$count_column;$i++){ $sheet->setCellValue($master_column[$i].$rowCount,$title[$i-1]);}
        }
        else{ for($i=0;$i<$count_column;$i++){ $sheet->setCellValue($master_column[$i].$rowCount,$title[$i]);}   }
        

        #### CONTENT
        $result = mysqli_query($connect,$sql_query); 
        if($stt){
            $stt_count = 0 ; 
            while($row = mysqli_fetch_array($result)){
                $stt_count++; 
                $rowCount++; 
                $sheet->setCellValue('A'.$rowCount,$stt_count);
                for($i=1;$i<=$count_column;$i++){ $sheet->setCellValue($master_column[$i].$rowCount,$row[$i-1]);}
            }
        }
        else {
            while($row = mysqli_fetch_array($result)){
                $rowCount++; 
                for($i=0;$i<$count_column;$i++){ $sheet->setCellValue($master_column[$i].$rowCount,$row[$i]);} 
            }
        }


        ### OUTPUT FILE EXCEL 
        $writer = new Xlsx($spreadsheet);
        
        if($save_url!== ''){
            ### Save File to URL 
             $writer->save("$save_url/$file_name");
        }
        else {
            ### Download file
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. urlencode($file_name).'"');
            $writer->save('php://output');
        }
        
    }



    #### Export excel From Array data
    public function export_excel_array($file_name,$sheet_name,$stt,$title,$data_array,$save_url){
        $master_column = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ') ; 
        $connection    = new conn_db ; 
        $connect       = $connection->conn_excel(); 
        $count_column  = count($title) ; 

        ### STARTING
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle($sheet_name);

        ### TITLE
        $rowCount = 1; 
        if($stt){
            $sheet->setCellValue('A'.$rowCount,'stt');
            for($i=1;$i<=$count_column;$i++){ $sheet->setCellValue($master_column[$i].$rowCount,$title[$i-1]);}
        }
        else{ for($i=0;$i<$count_column;$i++){ $sheet->setCellValue($master_column[$i].$rowCount,$title[$i]);}   }
        

        #### CONTENT
        if($stt){
            $stt_count = 0 ; 
            foreach($data_array as $value){
                $stt_count++; 
                $rowCount++; 
                $sheet->setCellValue('A'.$rowCount,$stt_count);
                $i = 0 ; 
                foreach($value as $detail){
                    $i++; 
                    $sheet->setCellValue($master_column[$i].$rowCount,$detail);
                }
                
            }
        }
        else {
            foreach($data_array as $value){
                $rowCount++; 
                $i = 0 ; 
                foreach($value as $detail){
                    $i++; 
                    $sheet->setCellValue($master_column[$i-1].$rowCount,$detail);
                }
                
            }
        }


        ### OUTPUT FILE EXCEL 
        $writer = new Xlsx($spreadsheet);
        
        if($save_url!== ''){
            ### Save File to URL 
             $writer->save("$save_url/$file_name");
        }
        else {
            ### Download file
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. urlencode($file_name).'"');
            $writer->save('php://output');
        }
        
    }

    
    public function use_format_file_test($format_file){
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($format_file);
        $sheet = $spreadsheet->getActiveSheet();

        ### OUTPUT
        $writer = new Xlsx($spreadsheet);
        $file_output_name = 'test.xlsx' ; 

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($file_output_name).'"');
        $writer->save('php://output');
    }


    public function insert_format_file($format_file,$title_value,$data_content,$file_output_name,$save_url){
        #### SETTING 
        $connection    = new conn_db ; 
        $connect       = $connection->conn_excel(); 
        #### LOAD FILE FORMAT 
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($format_file);
        $sheet = $spreadsheet->getActiveSheet();


        #### UPDATE TITLE 
        foreach($title_value as $tt_data){
            $cell_address = $tt_data['address']  ; 
            $cell_value   = $tt_data['value'] ; 
            $sheet->setCellValue($cell_address,$cell_value) ; 
        }


       

       
        #### INSERT DATA
        ### Data 1
        $row_content   = $data_content[1]['row_count'] ; 
        $query         = $data_content[1]['query'] ; 
        $column_select = $data_content[1]['colum'] ; 
        $field_list    = $data_content[1]['field'] ; 
        $len_field     = count($field_list) ; 

        // $autofill_list = $data_content[1]['auto_fill'] ; 
        // $autofill_count = count($autofill_list)  ; 
 
        
        $row_start = $row_content - 1 ; 
        $result = mysqli_query($connect,$query) ; 
        while($row = mysqli_fetch_array($result)){
            $row_start++ ; 
            for($i=0;$i<$len_field;$i++){
                 $index = $field_list[$i] ; 
                 $colum = $column_select[$i] ; 
                 $find = $row[$index] ; 
                 $sheet->setCellValue($colum.$row_start,$find) ; 

            }


            $sheet->insertNewRowBefore($row_start+1);
             
            ### Copy Row format 
            // #### Autofill 
            // if($autofill_count>0){
            //     if($row_start != $row_content){
            //         foreach($autofill_list as $autofill){
            //             $link = $sheet->getCell("$autofill$row_content")->getValue();
            //             // $link = $sheet->getCell("$autofill$row_content")->getCalculatedValue() ; 
            //             // $sheet->setCellValue($autofill.$row_start,$link) ; 
            //             // $this->copyRange($sheet, 'E4:E8', 'E1');
            //             // $cellValues = $sheet->rangeToArray("$autofill$row_content");
            //             // $sheet->fromArray($cellValues, null, "$autofill$row_start");
            //             $sheet->setCellValueByColumnAndRow(5,$row_start,$link) ; 


            //         }
            //     }
               
            // }

        }
        $sheet->removeRow($row_start+1) ; 

            





        ### DATA 2 to END
        $count_data = count($data_content) ; 
        if($count_data > 1){
            for($d=2;$d<=$count_data;$d++){
                $data_temp     = $data_content[$d] ; 
                $row_next      = $data_temp['next_row'] ; 
                $query_2         = $data_temp['query'] ; 
                $column_select_2 = $data_temp['colum'] ; 
                $field_list_2    = $data_temp['field'] ; 
                $len_field_2     = count($field_list_2) ; 
        

                $row_start = $row_start + $row_next ; 
                $result_temp = mysqli_query($connect,$query_2) ; 
                while($row_2 = mysqli_fetch_array($result_temp)){
                    $row_start++ ; 
                    for($i=0;$i<$len_field_2;$i++){
                        $index_2 = $field_list_2[$i] ; 
                        $colum_2 = $column_select_2[$i] ; 
                        $find_2  = $row_2[$index_2] ; 
                        $sheet->setCellValue($colum_2.$row_start,$find_2) ; 

                    }
                    $sheet->insertNewRowBefore($row_start+1);

                }
                $sheet->removeRow($row_start+1) ; 

            }
        }


        ### OUTPUT
        $writer = new Xlsx($spreadsheet);

        if($save_url != ''){
            ### Save File to URL 
             $writer->save("$save_url/$file_output_name");
        }
        else {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. urlencode($file_output_name).'"');
            $writer->save('php://output');
        }
    }





 


     
   


}



// $excel = new excel; 
// // // $excel->insert_format('format1.xlsx');
// // $title_set = Array('user','fullname','code') ; 
// // $sql_user = 'SELECT user, fullname, code  FROM assy_2.user_table' ; 

// // $excel->export_excel(
// //     $file_name  = 'user.xlsx', 
// //     $sheet_name = 'test',
// //     $stt        =  True, 
// //     $title      =  $title_set,
// //     $sql_query  =  $sql_user , 
// //     $save_url   =  ''
    
// // ) ; 

// $title_set2 = Array('user','fullname','code') ; 

// $data = array() ; 
// $data[1]['user']     = 'nguyena' ; 
// $data[1]['fullname'] = 'Ngo Ba Kha' ; 
// $data[1]['code']     = '123' ; 

// $data[2]['user']     = 'nguyenb' ; 
// $data[2]['fullname'] = 'Nguyen van Tien' ; 
// $data[2]['code']     = '456' ; 


// $excel->export_excel_array(
//     $file_name  = 'test_no_stt.xlsx', 
//     $sheet_name = 'test',
//     $stt        =  True, 
//     $title      =  $title_set2,
//     $data_array =  $data , 
//     $save_url   =  ''
    
// ) ; 
?>