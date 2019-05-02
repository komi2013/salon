<?php
namespace App\Http\Controllers\Calendar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TopController extends Controller {

    public function index(Request $request, $directory=null, $controller=null, $action=null) {

        $today = Carbon::today();
        $today = Carbon::parse('2015-07-07');
        $tempDate = Carbon::createFromDate($today->year, $today->month, 1);
        $skip = $tempDate->dayOfWeek;

        for($i = 0; $i < $skip; $i++) {
            $tempDate->subDay();
        }

        $arr_35days = [];
        while($tempDate->month <= $today->month) {
            for($i=0; $i < 7; $i++) {
                $arr_35days[$tempDate->format('Y-m-d_D')] = [];
                $tempDate->addDay();            
            }
        }

        return view('calendar.top', compact('arr_35days'));
        
    }
}

