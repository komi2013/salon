<?php
namespace App\Http\Controllers\Salon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CityController extends Controller {

    public function index(Request $request, $directory, $controller, $action, $prefecture) {
        $bind = [
            'prefecture' => $prefecture
        ];
        $obj = DB::select("SELECT * FROM riyou_jp WHERE prefecture = :prefecture ORDER BY riyou_jp_id", $bind);        
        return view('salon.city', compact('obj','prefecture'));
    }
}

