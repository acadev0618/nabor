<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;

class UserController extends Controller {
    
    public function index() {
        if(Session::get('display_name')) {

            $customers = DB::select('select * from users where user_type = 0 and is_deleted = 0', [1]);
            $providers = DB::select('select * from users where user_type = 1 and is_deleted = 0', [1]);
            $services = DB::select('select T1.*, T2.title from user_service T1 left join service_category T2 on T1.service_id = T2.id');

            return view('user')->with(
            	['customers' => $customers, 
            	'providers' => $providers, 
            	'services' => $services, 
            	'sliderAction' => 'user', 
            	'subAction' => '']
            );
        } else {
            return redirect('admin/');
        }
    }

    public function editCustomerView($id) {
        if(Session::get('display_name')) {

            $user = DB::select('select * from users where id = '.$id, [1]);

            return view('usermanagement.customeredit')->with(
            	['user' => $user,  
            	'sliderAction' => 'user', 
            	'subAction' => '']
            );
        } else {
            return redirect('admin/');
        }
    }

    public function editProviderView($id) {
        if(Session::get('display_name')) {

            $user = DB::select('select * from users where id = '.$id, [1]);
            $services = DB::select('select * from service_category');
            $selected_services = DB::select('select * from user_service where user_id = '.$id);

            return view('usermanagement.provideredit')->with(
            	['user' => $user, 
            	'services' => $services, 
            	'selected_services' => $selected_services, 
            	'sliderAction' => 'user', 
            	'subAction' => '']
            );
        } else {
            return redirect('admin/');
        }
    }

    public function customerPreView($id) {
        if(Session::get('display_name')) {

            $user = DB::select('select * from users where id = '.$id, [1]);

            return view('usermanagement.customerpreview')->with(
            	['user' => $user,  
            	'sliderAction' => 'user', 
            	'subAction' => '']
            );
        } else {
            return redirect('admin/');
        }
    }

    public function providerPreView($id) {
        if(Session::get('display_name')) {

            $user = DB::select('select * from users where id = '.$id, [1]);
            $services = DB::select('select * from service_category');
            $selected_services = DB::select('select * from user_service where user_id = '.$id);

            return view('usermanagement.providerpreview')->with(
            	['user' => $user, 
            	'services' => $services, 
            	'selected_services' => $selected_services, 
            	'sliderAction' => 'user', 
            	'subAction' => '']
            );
        } else {
            return redirect('admin/');
        }
    }

    public function editCustomer(Request $request) {
        $update_id = array('id' => $request->id);
        $photo = $request->file('photo');

        $data = array(
            "display_name" => $request->display_name,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "address" => $request->address,            
            "email" => $request->email,
            "phone" => $request->phone,
            "gender" => $request->gender,
            "about_me" => $request->about_me
        );
        if($photo) {
            $photo_name = $photo->getClientOriginalName();
            $destinationPath = 'uploads';
            $photo->move($destinationPath,$photo_name);
            $photo_link = "/uploads/".$photo_name;
            $data += [ "photo" => $photo_link ];
        }

        $result = DB::table('users')
                ->where($update_id)
                ->update($data);
        if ($result == 1) {
            return back();
        } else {
            return back();
        }
    }

    public function editProvider(Request $request) {
        $update_id = array('id' => $request->id);
        $photo = $request->file('photo');
        DB::delete('delete from user_service where user_id = '.$request->id);
        foreach ($request->service as $id) {
            DB::table('user_service')->insert(array('user_id' => $request->id, 'service_id' => $id));
        }

        $data = array(
            "display_name" => $request->display_name,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "address" => $request->address,            
            "email" => $request->email,
            "phone" => $request->phone,
            "gender" => $request->gender,
            "about_me" => $request->about_me
        );
        if($photo) {
            $photo_name = $photo->getClientOriginalName();
            $destinationPath = 'uploads';
            $photo->move($destinationPath,$photo_name);
            $photo_link = "/uploads/".$photo_name;
            $data += [ "photo" => $photo_link ];
        }

        $result = DB::table('users')
                ->where($update_id)
                ->update($data);
        if ($result == 1) {
            return back();
        } else {
            return back();
        }
    }

    public function deleteCustomer(Request $request) {
        $id = array(
            'id' => $request->id
        );
        $result = DB::table('users')
            ->where($id)
            ->update(array('is_deleted' => 1));

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

    public function deleteProvider(Request $request) {
        $id = array(
            'id' => $request->id
        );

        $result = DB::table('users')
            ->where($id)
            ->update(array('is_deleted' => 1));

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
