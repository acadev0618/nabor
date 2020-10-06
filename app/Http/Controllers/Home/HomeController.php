<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;

class HomeController extends Controller {
    
    public function index() {
        if(Session::get('display_name')) {

            $current_date = date('Y-m-d');
            $current_year = date('Y');
            $new_requests = DB::select("SELECT COUNT(id) as num FROM services WHERE created_date LIKE '".$current_date."%'", [1]);
            $active_services = DB::select("SELECT COUNT(id) as num FROM services WHERE status = 4", [1]);
            $decliened_service = DB::select("SELECT COUNT(id) as num FROM services WHERE decliened_date LIKE '".$current_date."%'", [1]);
            $rejected_services = DB::select("SELECT COUNT(id) as num FROM services WHERE rejected_date LIKE '".$current_date."%'", [1]);
            $new_customers = DB::select("SELECT * FROM users WHERE created_date LIKE '".$current_date."%' AND user_type = 0", [1]);
            $new_providers = DB::select("SELECT * FROM users WHERE created_date LIKE '".$current_date."%' AND user_type = 1", [1]);

            $jan_completed = DB::select("SELECT COUNT(id) as num FROM services WHERE completed_date LIKE '".$current_year."-01%'", [1]);
            $feb_completed = DB::select("SELECT COUNT(id) as num FROM services WHERE completed_date LIKE '".$current_year."-02%'", [1]);
            $mar_completed = DB::select("SELECT COUNT(id) as num FROM services WHERE completed_date LIKE '".$current_year."-03%'", [1]);
            $apr_completed = DB::select("SELECT COUNT(id) as num FROM services WHERE completed_date LIKE '".$current_year."-04%'", [1]);
            $may_completed = DB::select("SELECT COUNT(id) as num FROM services WHERE completed_date LIKE '".$current_year."-05%'", [1]);
            $jun_completed = DB::select("SELECT COUNT(id) as num FROM services WHERE completed_date LIKE '".$current_year."-06%'", [1]);
            $jul_completed = DB::select("SELECT COUNT(id) as num FROM services WHERE completed_date LIKE '".$current_year."-07%'", [1]);
            $aug_completed = DB::select("SELECT COUNT(id) as num FROM services WHERE completed_date LIKE '".$current_year."-08%'", [1]);
            $sep_completed = DB::select("SELECT COUNT(id) as num FROM services WHERE completed_date LIKE '".$current_year."-09%'", [1]);
            $oct_completed = DB::select("SELECT COUNT(id) as num FROM services WHERE completed_date LIKE '".$current_year."-10%'", [1]);
            $nov_completed = DB::select("SELECT COUNT(id) as num FROM services WHERE completed_date LIKE '".$current_year."-11%'", [1]);
            $dec_completed = DB::select("SELECT COUNT(id) as num FROM services WHERE completed_date LIKE '".$current_year."-12%'", [1]);
            // var_dump($active_services[0]->num); die();
            $completed_services = array(
                'Jan' => $jan_completed[0]->num,
                'Feb' => $feb_completed[0]->num,
                'Mar' => $mar_completed[0]->num,
                'Apr' => $apr_completed[0]->num,
                'May' => $may_completed[0]->num,
                'Jun' => $jun_completed[0]->num,
                'Jul' => $jul_completed[0]->num,
                'Aug' => $aug_completed[0]->num,
                'Sep' => $sep_completed[0]->num,
                'Oct' => $oct_completed[0]->num,
                'Nov' => $nov_completed[0]->num,
                'Dec' => $dec_completed[0]->num
            );
            $max_completed = max($completed_services);

            $jan_decliened = DB::select("SELECT COUNT(id) as num FROM services WHERE decliened_date LIKE '".$current_year."-01%'", [1]);
            $feb_decliened = DB::select("SELECT COUNT(id) as num FROM services WHERE decliened_date LIKE '".$current_year."-02%'", [1]);
            $mar_decliened = DB::select("SELECT COUNT(id) as num FROM services WHERE decliened_date LIKE '".$current_year."-03%'", [1]);
            $apr_decliened = DB::select("SELECT COUNT(id) as num FROM services WHERE decliened_date LIKE '".$current_year."-04%'", [1]);
            $may_decliened = DB::select("SELECT COUNT(id) as num FROM services WHERE decliened_date LIKE '".$current_year."-05%'", [1]);
            $jun_decliened = DB::select("SELECT COUNT(id) as num FROM services WHERE decliened_date LIKE '".$current_year."-06%'", [1]);
            $jul_decliened = DB::select("SELECT COUNT(id) as num FROM services WHERE decliened_date LIKE '".$current_year."-07%'", [1]);
            $aug_decliened = DB::select("SELECT COUNT(id) as num FROM services WHERE decliened_date LIKE '".$current_year."-08%'", [1]);
            $sep_decliened = DB::select("SELECT COUNT(id) as num FROM services WHERE decliened_date LIKE '".$current_year."-09%'", [1]);
            $oct_decliened = DB::select("SELECT COUNT(id) as num FROM services WHERE decliened_date LIKE '".$current_year."-10%'", [1]);
            $nov_decliened = DB::select("SELECT COUNT(id) as num FROM services WHERE decliened_date LIKE '".$current_year."-11%'", [1]);
            $dec_decliened = DB::select("SELECT COUNT(id) as num FROM services WHERE decliened_date LIKE '".$current_year."-12%'", [1]);
            $decliened_services = array(
                'Jan' => $jan_decliened[0]->num,
                'Feb' => $feb_decliened[0]->num,
                'Mar' => $mar_decliened[0]->num,
                'Apr' => $apr_decliened[0]->num,
                'May' => $may_decliened[0]->num,
                'Jun' => $jun_decliened[0]->num,
                'Jul' => $jul_decliened[0]->num,
                'Aug' => $aug_decliened[0]->num,
                'Sep' => $sep_decliened[0]->num,
                'Oct' => $oct_decliened[0]->num,
                'Nov' => $nov_decliened[0]->num,
                'Dec' => $dec_decliened[0]->num
            );
            $max_decliened = max($decliened_services);

            return view('dashboard')->with(
            	['new_requests' => $new_requests[0]->num, 
            	'active_services' => $active_services[0]->num, 
            	'decliened_service' => $decliened_service[0]->num, 
            	'rejected_services' => $rejected_services[0]->num, 
            	'new_customers' => $new_customers, 
            	'new_providers' => $new_providers, 
            	'completed_services' => $completed_services, 
            	'max_completed' => $max_completed, 
            	'decliened_services' => $decliened_services, 
            	'max_decliened' => $max_decliened, 
            	'sliderAction' => 'dashboard', 
            	'subAction' => '']
            );
        } else {
            return redirect('admin/');
        }
    }

    public function updateHomeList(Request $request) {
        $id = array('id' => $request->id);
        $data = array(
            'title' => $request->title,
            'subtitle' => $request->subtitle
        );
        $result = DB::table('hometable')
                ->where($id)
                ->update($data);
        
        if ($result == 1) {
            $notification = array(
                'message' => 'Successfully deleted data.', 
                'alert-type' => 'success'
            );
            return back();
        } else {
            $notification = array(
                'message' => 'Whoops! Something went wrong.', 
                'alert-type' => 'error'
            );
        }
        return back()->withInput($notification);
    }
}
