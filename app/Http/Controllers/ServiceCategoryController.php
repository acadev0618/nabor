<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;

class ServiceCategoryController extends Controller {
    
    public function index() {
        if(Session::get('display_name')) {

            $data = DB::select('select * from service_category', [1]);

            return view('servicecategory')->with(
            	['data' => $data, 
            	'sliderAction' => 'servicecategory', 
            	'subAction' => '']
            );
        } else {
            return redirect('admin/');
        }
    }

    public function addServiceCategory(Request $request) {
        $data = array(
            'title' => $request->title
        );
        $result = DB::table('service_category')->insert($data);
        if($result) {
            return back();
        } else {
            return back();
        }
    }

    public function editServiceCategory(Request $request) {
        $update_id = array('id' => $request->id);
        $data = array(
            'title' => $request->title
        );
        $result = DB::table('service_category')
                ->where($update_id)
                ->update($data);
        if($result) {
            return back();
        } else {
            return back();
        }
    }

    public function deleteServiceCategory(Request $request) {
        $id = array(
            'id' => $request->id
        );

        DB::table('user_service')->where(array('service_id' => $request->id))->delete();
        $result = DB::table('service_category')->where($id)->delete();

        if($result == 1) {
            $notification = array(
                'message' => 'Successfully deleted aboutUs.', 
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Whoops! Something went wrong.', 
                'alert-type' => 'warning'
            );
        }
        return back()->with($notification);
    }
}
