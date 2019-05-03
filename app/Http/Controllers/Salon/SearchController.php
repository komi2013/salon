<?php
namespace App\Http\Controllers\Salon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller {

    public function index(Request $request,$directory,$controller,$action,$address) {
        $bind = [
            'address' => '%'.$address.'%'
        ];

        $obj = DB::select("SELECT * FROM salon WHERE address like :address", $bind);
        
        $arr = [];
        $count = 0;
        foreach ($obj as $d) {
            $count++;
        }

        if ($count < 1) {
            abort(404);
        }
        return view('salon.search', compact('obj','count','address'));
    }
}

