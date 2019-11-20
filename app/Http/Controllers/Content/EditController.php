<?php
namespace App\Http\Controllers\Content;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EditController extends Controller {

    public function index(Request $request, $directory=null, $controller=null, 
            $action=null, $content_id=null) {
        $title = 'whatever';
        return view('content.edit', compact('title','content_id'));
    }
}

