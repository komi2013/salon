<?php
namespace App\Http\Controllers\Calendar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScheduleController extends Controller {

    public function edit(Request $request, $directory=null, $controller=null, 
            $action=null, $id_date=null) {
        $usr_id = 3;
        $common_id = null;
        $a['time_start'] = '';
        $a['time_end'] = '';
        $a['todo'] = '';
        $a['title'] = '';
        $a['tag'] = '';
        $a['usr_id'] = '';
        $a['group_id'] = '';
        $a['public_tag'] = '';
        $a['public_title'] = '';
        $mydata = 0;
        if ( strpos($id_date,"-") ) { //new
            $date = $id_date;
        } else {  //edit
            $common_id = $id_date;
            $obj = DB::table('t_schedule')->where("common_id", $common_id)->get();
            $date = date('Y-m-d');
            $mydata = 1;
            foreach ($obj as $d) {
                if ($d->usr_id == $usr_id) {
                    $a['time_start'] = $d->time_start;
                    $a['time_end'] = $d->time_end;
                    $a['todo'] = $d->todo;
                    $a['title'] = $d->title;
                    $a['tag'] = $d->tag;
                    $a['usr_id'] = $d->usr_id;
                    $a['group_id'] = $d->group_id;
                    $a['public_tag'] = $d->public_tag;
                    $a['public_title'] = $d->public_title;
                    $date = date('Y-m-d', strtotime($d->time_start));
                    $mydata = 2;
                }
            }

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
           $arr_group[$d->group_type_id] = $arr;
        }
        $group_ids = json_encode($group_ids);
        $request->session()->put('view_time', date('Y-m-d H:i:s'));
        return view('calendar.edit', compact('date','arr_group','group_ids','common_id',
                'mydata','a'));
    }
}

