<?php
namespace App\Http\Controllers\Salon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller {

    public function index(Request $request,$directory,$controller,$action,$prefecture,$city) {
        $bind = [
            'city' => $city
        ];

        $obj = DB::select("SELECT * FROM salon WHERE city = :city", $bind);
        
        $arr = [];
        $count = 0;
        foreach ($obj as $d) {
            $count++;
        }

        if ($count < 1) {
            abort(404);
        }
        return view('salon.shop', compact('obj','count'));
    }
}

