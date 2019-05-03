<?php
namespace App\Http\Controllers\Scraping;
require_once('/var/www/zstg_salon/vendor/simple_html_dom.php');

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller {

    public function index(Request $request) {
        $table = str_get_html($table);
        $a = $table->find( 'a' );

        foreach ($a as $d1) {
            $a_arr[] = $d1->attr['href'];
        }

die('works?');

		var_dump('test');
		die;
		
    }

}

