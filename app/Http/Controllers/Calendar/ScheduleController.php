<?php
namespace App\Http\Controllers\Calendar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScheduleController extends Controller {

    public function edit(Request $request, $directory=null, $controller=null, 
            $action=null, $id_date=null) {
        $usr_id = $request->session()->get('usr_id');

        $common_id = null;
        $minute_start = $minute_end = $minutes = [['00',''],['15',''],['30',''],['45','']];
        for ($i=0; $i<24; $i++) {
            $k = str_pad($i,2,0,STR_PAD_LEFT);
            $k = (string) $k; 
            $hours[$k] = [$k,''];
        }
        $hour_start = $hour_end = $hours;
        for ($i=1; $i<6; $i++) {
            $tags[$i] = [$i,''];
        }
        $bind = [
            'usr_id' => $usr_id
        ];
        $obj = DB::select("SELECT * FROM r_group WHERE usr_id = :usr_id ", $bind);
        $arr_group = [];
        $group_type_ids = [];
        $group_ids = [];
        foreach ($obj as $d) {
           $group_ids[] = $d->group_id;
           $group_type_ids[] = $d->group_type_id;
           $arr['group_type_id'] = $d->group_type_id;
           $arr_group[$d->group_type_id] = $arr;
        }
        $obj = DB::table('m_group_type')->whereIn("group_type_id", $group_type_ids)->get();
        foreach ($obj as $d) {
           $arr['group_type_id'] = $d->group_type_id;
           $arr['group_name'] = $d->group_name;
           $arr['category_id'] = $d->category_id;
           $arr['selected'] = '';
           $arr_group[$d->group_type_id] = $arr;
        }
        $group_radio = 2;
        $group_ids = json_encode($group_ids);
        $usrs = [(int)$usr_id];
        $a['todo'] = '';
        $a['title'] = '';
        $a['usr_id'] = '';
        $a['group_id'] = '';
        $a['public_tag'] = '';
        $a['public_title'] = '';
        $mydata = 0;
        if ( strpos($id_date,"-") ) { //new
            $date = $id_date;
            $hours[date('H')][1] = 'selected';
            $hour_start = $hour_end = $hours;
            if (date('i') < 15) {
                $minutes[0][1] = 'selected';
            } else if (date('i') < 30) {
                $minutes[1][1] = 'selected';
            } else if (date('i') < 45) {
                $minutes[2][1] = 'selected';
            } else {
                $minutes[3][1] = 'selected';
            }
            $minute_start = $minute_end = $minutes;
            $hour_start = $hour_end = $hours;
        } else {  //edit
            $common_id = $id_date;
            $obj = DB::table('t_schedule')->where("common_id", $common_id)->get();
            $date = date('Y-m-d');
            $mydata = 1;
            foreach ($obj as $d) {
                if ($d->usr_id == $usr_id) {
                    if (date('i', strtotime($d->time_start)) < 15) {
                        $minute_start[0][1] = 'selected';
                    } else if (date('i', strtotime($d->time_start)) < 30) {
                        $minute_start[1][1] = 'selected';
                    } else if (date('i', strtotime($d->time_start)) < 45) {
                        $minute_start[2][1] = 'selected';
                    } else if (date('i', strtotime($d->time_start)) <= 59) {
                        $minute_start[3][1] = 'selected';
                    }
                    if (date('i', strtotime($d->time_end)) < 15) {
                        $minute_end[0][1] = 'selected';
                    } else if (date('i', strtotime($d->time_end)) < 30) {
                        $minute_end[1][1] = 'selected';
                    } else if (date('i', strtotime($d->time_end)) < 45) {
                        $minute_end[2][1] = 'selected';
                    } else if (date('i', strtotime($d->time_end)) <= 59) {
                        $minute_end[3][1] = 'selected';
                    }
                    $hour_start[date('H', strtotime($d->time_start))][1] = 'selected';
                    $hour_end[date('H', strtotime($d->time_end))][1] = 'selected';
                    $tags[$d->tag][1] = 'selected';
                    
                    if ($d->group_type_id < 2) {
                        $group_radio = $d->group_type_id;
                    } else if(isset($arr_group[$d->group_type_id]['selected'])) {
                        $arr_group[$d->group_type_id]['selected'] = 'selected';
                    }
                    $a['todo'] = $d->todo;
                    $a['title'] = $d->title;
                    $a['public_tag'] = $d->public_tag;
                    $a['public_title'] = $d->public_title;
                    $date = date('Y-m-d', strtotime($d->time_start));
                    $mydata = 2;
                } else {
                    $usrs[] = $d->usr_id;
                }
            }

        }
        
        $request->session()->put('view_time', date('Y-m-d H:i:s'));
//        echo '<pre>'; 
//        echo date('H');
//        var_dump($hour_start);
//        echo '</pre>';
//        die;
        $usrs = json_encode($usrs);
        $json_usr = json_encode([$request->session()->get('usr_id'),$request->session()->get('usr_name_mb')]);
        return view('calendar.edit', compact('date','arr_group','group_ids','common_id',
                'mydata','a','hour_start','hour_end','minute_start','minute_end','tags',
                'json_usr','group_radio','usrs'));
    }
}

