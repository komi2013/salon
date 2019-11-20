<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Weidner\Goutte\GoutteFacade;

class HtmController extends Controller {

    public function index(Request $request, $page) {
        return view('htm.'.$page);
    }

}

