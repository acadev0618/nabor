<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;

class HistoryController extends Controller {
    
    public function index() {
        if(Session::get('display_name')) {

            $data = DB::select('SELECT
                T1.*,
                T2.display_name provider_name 
            FROM
                (
                SELECT
                    T1.*,
                    T2.display_name customer_name,
                    T3.title service_title 
                FROM
                    services T1
                    LEFT JOIN users T2 ON T1.customer = T2.id
                    LEFT JOIN service_category T3 ON T1.service = T3.id 
                WHERE
                    is_history = 1 
                ) T1
                LEFT JOIN users T2 ON T1.provider = T2.id', [1]);

            return view('history')->with(
            	['data' => $data, 
            	'sliderAction' => 'history', 
            	'subAction' => '']
            );
        } else {
            return redirect('admin/');
        }
    }

    public function deleteHistory(Request $request) {
        $id = array(
            'id' => $request->id
        );

        $result = DB::table('services')->where($id)->delete();

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
