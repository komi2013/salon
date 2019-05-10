<?php
namespace App\Http\Controllers\Calendar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GetController extends Controller {

    public function groupUsr(Request $request, $directory=null, $controller=null, 
            $action=null, $group_type_id=null, $oauth_type=null) {
        $bind = [
            'group_type_id' => $group_type_id
        ];        
        $obj = DB::select("SELECT * FROM r_group WHERE group_type_id = :group_type_id ", $bind);
        $arr_usr = [];
        $usr_ids = [];
        foreach ($obj as $d) {
           $usr_ids[] = $d->usr_id;
        }
        if ($oauth_type == 'facility') {
            $obj = DB::table('t_usr')->select('usr_id', 'usr_name_mb')
                    ->whereIn("usr_id", $usr_ids)->where("oauth_type","=",5)->get();
        } else {
            $obj = DB::table('t_usr')->select('usr_id', 'usr_name_mb')
                    ->whereIn("usr_id", $usr_ids)->where("oauth_type","<>",5)->get();
        }
        foreach ($obj as $d) {
           $arr = [$d->usr_id,$d->usr_name_mb];
           $arr_usr[] = $arr;
        }
        die(json_encode($arr_usr));
    }
    public function searchUsr(Request $request, $directory=null, $controller=null, 
            $action=null, $word=null, $oauth_type=null) {
        $obj = DB::table('r_group')->select('usr_id')
            ->whereIn("group_id", $_GET['group_ids'])->get();
        $i = 1;
        $com_usr_id = '';
        $usr_ids = [];
        foreach ($obj as $d) {
            if (!in_array($d->usr_id, $usr_ids)) {
                if ($i == 1) {
                    $com_usr_id = $d->usr_id;
                }else{
                    $com_usr_id .= ','.$d->usr_id;
                }
                $usr_ids[] = $d->usr_id;
                $i++;
            }
        }
        $bind = [
            'word' => '%'.$word.'%'
        ];
        if(strlen($word) == mb_strlen($word,'utf8')) {
            $sql = "SELECT * FROM t_usr WHERE usr_name like :word AND usr_id in (".$com_usr_id.")";
        }else{
            $sql = "SELECT * FROM t_usr WHERE usr_name_mb like :word AND usr_id in (".$com_usr_id.")";
        }
        if ($oauth_type == 'facility') {
            $oauth_type_and = ' AND oauth_type = 5';
        } else {
            $oauth_type_and = ' AND oauth_type <> 5';
        }
        $obj = DB::select($sql.$oauth_type_and, $bind);
        $arr_usr = [];
        foreach ($obj as $d) {
           $arr = [$d->usr_id,$d->usr_name_mb];
           $arr_usr[] = $arr;
        }
        die(json_encode($arr_usr));
    }
}

