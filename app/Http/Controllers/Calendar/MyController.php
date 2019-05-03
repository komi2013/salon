<?php
namespace App\Http\Controllers\Calendar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MyController extends Controller {

    public function index(Request $request, $directory=null, $controller=null, 
            $action=null, $month=null) {

        $today = Carbon::parse($month.date('-d'));

        $bind = [
            'usr_id' => 2
            ,'month_begin' => $today->format('Y-m-01 00:00:00')
            ,'month_end' => $today->endOfMonth()->format('Y-m-d 23:59:59')
        ];

        $obj = DB::select("SELECT * FROM t_schedule WHERE usr_id = :usr_id "
                . "AND time_start >= :month_begin AND time_start <= :month_end", $bind);
        $arr_my = [];
        foreach ($obj as $d) {
            $arr_my[] = date('Y-m-d', strtotime($d->time_start));
        }
        
        $tempDate = Carbon::createFromDate($today->year, $today->month, 1);
        $skip = $tempDate->dayOfWeek;

        for($i = 0; $i < $skip; $i++) {
            $tempDate->subDay();
        }

        $arr_35days = [];
        while($tempDate->month <= $today->month) {
            for($i=0; $i < 7; $i++) {
                $arr = [];
                $arr_35days[$tempDate->format('Y-m-d')] = $arr;
                $tempDate->addDay();
            }
        }
        die(json_encode($arr));
//        return view('calendar.top', compact('arr_35days','month'));
        
    }
}

