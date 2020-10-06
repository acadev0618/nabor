<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;

class SettingsController extends Controller {
    
    public function index() {
        if(Session::get('display_name')) {

            $data = DB::select('select * from settings', [1]);

            return view('settings')->with(
            	['data' => $data, 
            	'sliderAction' => 'settings', 
            	'subAction' => '']
            );
        } else {
            return redirect('admin/');
        }
    }

    public function updateSetting(Request $request) {
        $splash = $request->file('splash');
        $sidebar = $request->file('sidebar');
        $data = array();
        $id = array('id' => 1);

        if(!empty($splash) || !empty($sidebar)) {
            if (!empty($splash)) {
                $splash_name = $splash->getClientOriginalName();
                $destinationPath = 'uploads';
                $splash->move($destinationPath,$splash_name);
                $splash_link = "/uploads/".$splash_name;
                $data += [ "splash_image" => $splash_link ];                
            }
            if (!empty($sidebar)) {
                $sidebar_name = $sidebar->getClientOriginalName();
                $destinationPath = 'uploads';
                $sidebar->move($destinationPath,$sidebar_name);
                $sidebar_link = "/uploads/".$sidebar_name;
                $data += [ "sidebar_image" => $sidebar_link ];
            }
        } else {
            return back();
        }
        $result = DB::table('settings')
                ->where($id)
                ->update($data);
        if ($result == 1) {
            return back();
        }
    }
}
