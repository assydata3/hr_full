<?php 
require_once __DIR__.'/../00_Basic/connect.php' ; 
use Connect\connect\conn_db;

class date_class{

    ### tìm ngày đầu tiên trong tháng 
    public function first_day($date){
        $fist_day = date_create($date)
        ->modify('first day of this month')
        ->format('Y-m-d');

        return $fist_day;
    }

   


    public function last_month($date){
        ### tim ngay dau thang 
        $fistday = $this->first_day($date); 
        
        ### ngay cuoi thang truoc 
        $lastmonth_last = $this->date_add($fistday,-1); 
        $last_month = date('Y-m',strtotime($lastmonth_last)); 
        return $last_month  ; 
    }


    #### Tìm ngày cuối tháng từ ngày nhập vào 
    public function last_day($date){
        $last_day = date_create($date)
        ->modify('last day of this month')
        ->format('Y-m-d');
        return $last_day;
    }

    #### Tìm mảng dữ liệu thông tin ngày giờ hiện tại . 
    public function current_datetime() {
        date_default_timezone_set('Asia/ho_chi_minh');
        $date_full = date('Y-m-d H:i:s');
        $today = date('Y-m-d'); 
        $current_time = date('H:i:s') ; 

        $date_array = array() ; 
        $date_value = getdate() ; 

        $fist_day_month = $this->fist_day($today); 
        $last_day_month = $this->last_day($today); 

        $date_array['today_full']   = $date_full ; 
        $date_array['today']        = $today ; 
        $date_array['time']         = $current_time ; 
        $date_array['week_day']     = $date_value['weekday'] ; 
        $date_array['wday']         = $date_value['wday'] ;
        $date_array['week_day']     = $date_value['weekday'] ; 
        $date_array['time_total']   = $date_value['0'] ; 
        $date_array['day_in_year']  = $date_value['yday'] ; 
        $date_array['month']        = $date_value['month'] ; 
        $date_array['mon']          = $date_value['mon'] ;
        $date_array['fist_d_mo']    = $fist_day_month ;
        $date_array['last_d_mo']    = $last_day_month ;

        return $date_array ; 
    }

    



 


    public function diff_time($start_time,$end_time){
        $diff_array = array() ; 
        $originalTime = new DateTimeImmutable($start_time."Asia/ho_chi_minh");
        $targedTime   = new DateTimeImmutable($end_time."Asia/ho_chi_minh");
        $interval = $originalTime->diff($targedTime);
        $data = $interval->format("%H:%I:%S (Full days: %a)");
        $diff_array['total'] = $data ; 
        $diff_array['hour'] = $interval->format("%H");
        return $diff_array ;
    }


} 


// $data = new date_data ; 
// $list_month = $data->list_day_current_month(); 
// print_r($list_month) ; 
// $time_1 = '2025-12-01 08:30' ; 
// $time_2 = '2024-01-02 16:30';
// $diff = $data->diff_time($time_1, $time_2);
// print_r($diff);
// $current = $data->current_datetime() ; 
// print_r($current); 

// print_r($data->date_company_index('2023-12-21')) ; 
// print_r($data->index2date(1052)) ; 

// print_r($data->date_plus('2023-12-21',-10)) ; 

// echo date_create('2023-12-21')
// // ->modify('first day of this month')
// ->format('d/M/Y');

// $date1 = '2023-12-21' ; 
// $date2 = $data->date_add($date1,1-10) ; 
// echo $date2 ; 
 
?>