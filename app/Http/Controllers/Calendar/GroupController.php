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
            ,'usr_id' => $usr_id
        ];
        $res = DB::select("SELECT * FROM r_group_relate WHERE group_id = :group_id "
                . " OR usr_id = :usr_id", $bind);
        $usrs = [];
        $usr_ids = [];
        $owner = false;
        foreach ($res as $d) {
            if ($d->group_id == $group_id) {
                if ($d->usr_id == $usr_id AND $d->owner_flg == 1) {
                    $owner = true;
                }
                $usr_ids[] = $d->usr_id;
//                $arr['usr_id'] = $d->usr_id;
//                $arr['owner_flg'] = $d->owner_flg ? true : false;
//                $usrs[$d->usr_id] = $arr;
            }
        }
        if (!$owner) {
            die('you can not change this group');
        }
        $m_group = DB::table('m_group')->where("group_id", $group_id)->first();
        if ($m_group->category_id == 1) {
            $people = '';
            $facility = 'selected';
        } else {
            $people = 'selected';
            $facility = '';
        }
        $arr_group = [];
        $group_ids = [];
        foreach ($res as $d) {
            if ($d->usr_id == $usr_id) {
                $group_ids[] = $d->group_id;
                $arr['group_id'] = $d->group_id;
                $arr['owner_flg'] = $d->owner_flg;
                $arr_group[$d->group_id] = $arr;
            }
        }
        $obj = DB::table('m_group')->whereIn("group_id", $group_ids)->get();
        foreach ($obj as $d) {
           $arr_group[$d->group_id]['group_id'] = $d->group_id;
           $arr_group[$d->group_id]['group_name'] = $d->group_name;
           $arr_group[$d->group_id]['category_id'] = $d->category_id;
           $arr_group[$d->group_id]['selected'] = '';
        }

        $usr_ids = json_encode($usr_ids);
        return view('calendar.group_edit', compact('m_group','people','facility',
                'arr_group','usr_id','usr_ids'));
    }
}

