<?php
namespace App\Http\Controllers\Calendar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GroupController extends Controller {

    public function edit(Request $request, $directory=null, $controller=null, 
            $action=null, $group_id=null, $oauth_type=null) {
        $usr_id = $request->session()->get('usr_id');
        $bind = [
            'group_id' => $group_id
        ];
        $obj = DB::select("SELECT * FROM r_group_relate WHERE group_id = :group_id ", $bind);
        $group_usr = [];
        $usr_ids = [];
        $owner = false;
        foreach ($obj as $d) {
            if ($d->usr_id == $usr_id AND $d->owner_flg == 1) {
                $owner = true;
            }
            $usr_ids[] = $d->usr_id;
            $arr['usr_id'] = $d->usr_id;
            $arr['owner_flg'] = $d->owner_flg ? 'checked' : '';
            $group_usr[$d->usr_id] = $arr;
        }
        if (!$owner) {
            die('you can not change this group');
        }
        $obj = DB::table('t_usr')->whereIn("usr_id", $usr_ids)->get();
        foreach ($obj as $d) {
           $group_usr[$d->usr_id]['usr_name'] = $d->usr_name;
           $group_usr[$d->usr_id]['usr_name_mb'] = $d->usr_name_mb;
           $group_usr[$d->usr_id]['oauth_type'] = $d->oauth_type;
        }
        $m_group = DB::table('m_group')->where("group_id", $group_id)->first();
        if ($m_group->category_id == 1) {
            $people = '';
            $facility = 'selected';
        } else {
            $people = 'selected';
            $facility = '';
        }
        $arr = [];
        foreach ($group_usr as $d) {
          $arr[] = $d;  
        }
        $group_usr = json_encode($arr);
        return view('calendar.group', compact('group_usr','m_group','people','facility'));
    }
}

