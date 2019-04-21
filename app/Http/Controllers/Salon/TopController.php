<?php
namespace App\Http\Controllers\Salon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TopController extends Controller {

    public function index(Request $request, $directory, $controller, $action) {
        $obj = DB::select("SELECT * FROM prefecture ORDER BY prefecture_id ASC");
        
        return view('salon.top', compact('obj'));
        
    }
}

