<?php
namespace App\Http\Controllers\Calendar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScheduleController extends Controller {

    public function edit(Request $request, $directory=null, $controller=null, 
            $action=null, $date=null, $schedule_id=null) {
        $usr_id = 3;
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

        return view('calendar.edit', compact('date','arr_group','group_ids','schedule_id'));
    }
}

