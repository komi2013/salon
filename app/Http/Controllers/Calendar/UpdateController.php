<?php
namespace App\Http\Controllers\Calendar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateController extends Controller {

    public function lessuri(Request $request, $directory=null, $controller=null, $action=null) {
//        echo '<pre>';
//        var_dump($_POST);
//        echo '</pre>';
//          ["_token"]=>
//  string(40) "V2qDApU3NU7SRhIyxxDslm3eoJ8Dci81F6HRP1I1"
//  ["tag"]=>
//  string(1) "3"
//  ["title"]=>
//  string(9) "ｄｆｇ"
//  ["time_start"]=>
//  string(19) "2019-05-06 00:00:00"
//  ["time_end"]=>
//  string(19) "2019-05-06 00:00:00"
//  ["todo"]=>
//  string(9) "ｆｇｈ"
//  ["public"]=>
//  string(1) "2"
//  ["group_id"]=>
//  string(1) "3"
        $usr_id = 3;
        if ($request->input('public') == 2) {
            $group_id = $request->input('group_id');
        } else {
            $group_id = $request->input('public');
        }
        $arr = [
            'time_start' => $request->input('time_start')
            ,'time_end' => $request->input('time_end')
            ,'todo' => $request->input('todo')
            ,'title' => $request->input('title')
            ,'tag' => $request->input('tag')
            ,'group_id' => $group_id
        ];
        
        var_dump($request->input('usrs'));
        $usr_ids = [$usr_id]; 

//        var_dump($arr);
        if ($request->input('schedule_id')) {
            $usr_ids[] = $usr_id;
            foreach ($request->input('usrs') as $d) {
                $usr_ids[] = $d[0];
            }
            DB::table('t_schedule')->update($arr)->whereIn("schedule_id", $usr_ids);
        } else {
            foreach ($request->input('usrs') as $d) {
                $usr_ids[] = $d[0];
                $arr['usr_id'] = $d[0];
                $schedules[] = $arr;
            }
            DB::table('t_schedule')->insert($arr);
        }
        
//        $request->session()->regenerateToken();
    }
}

