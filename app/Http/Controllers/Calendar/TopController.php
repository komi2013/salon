<?php
namespace App\Http\Controllers\Calendar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TopController extends Controller {

    public function index(Request $request, $directory=null, $controller=null, $action=null) {
        
        $now = Carbon::now();
        echo '現在: ' . $now . '<br>';
        die();
        
        $obj = DB::select("SELECT * FROM prefecture ORDER BY prefecture_id ASC");
        
        return view('salon.top', compact('obj'));
        
    }
}

