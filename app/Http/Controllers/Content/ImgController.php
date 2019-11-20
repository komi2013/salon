<?php
namespace App\Http\Controllers\Content;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImgController extends Controller {
    public function index(Request $request, $directory=null, $controller=null, 
            $action=null, $content_id=null) {
        $res[0] = 1;
        $res[1] = 1;
        die(json_encode($res));
    }
    public function add(Request $request) {
        $res[0] = 1;
        $res[1] = 1;
        die(json_encode($res));
    }
}

