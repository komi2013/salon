<?php
namespace App\Http\Controllers\Calendar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TopController extends Controller {

    public function index(Request $request, $directory=null, $controller=null, 
            $action=null, $month=null) {
        
        $today = Carbon::today();
        $today = $month ? Carbon::parse($month.date('-d')) : Carbon::today();
        $month = $today->format('Y-m');
//        die($today->endOfMonth()->format('Y-m-d'));
        $bind = [
            'usr_id' => 1
            ,'month_begin' => $today->format('Y-m-01 00:00:00')
            ,'month_end' => $today->endOfMonth()->format('Y-m-d 23:59:59')
        ];

        $obj = DB::select("SELECT time_start FROM t_schedule WHERE usr_id = :usr_id "
                . "AND time_end > :month_begin AND time_start < :month_end", $bind);
        $arr_holidays = [];
        foreach ($obj as $d) {
            $arr_holidays[] = date('Y-m-d', strtotime($d->time_start));
        }
        
        $tempDate = Carbon::createFromDate($today->year, $today->month, 1);
        $skip = $tempDate->dayOfWeek;

        for($i = 0; $i < $skip; $i++) {
            $tempDate->subDay();
        }

        $arr_35days = [];
        while($tempDate->month <= $today->month) {
            for($i=0; $i < 7; $i++) {
                $arr['j'] = $tempDate->format('j');
                $arr['day'] = $tempDate->format('D');
                $arr['css_class'] = '';
                if ( in_array($tempDate->format('D'), ['Sun','Sat']) 
                        OR in_array($tempDate->format('Y-m-d'), $arr_holidays)) {
                    $arr['css_class'] .= ' offwork';
                }
                $arr_35days[$tempDate->format('Y-m-d')] = $arr;
                $tempDate->addDay();            
            }
        }

        return view('calendar.top', compact('arr_35days','month'));
        
    }
}

