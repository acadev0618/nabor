<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;

class RequestsController extends Controller {
    
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
                    is_history = 0 AND
                    (STATUS = 0 
                    OR STATUS = 1 
                    OR STATUS = 2 
                    OR STATUS = 3) 
                ) T1
                LEFT JOIN users T2 ON T1.provider = T2.id', [1]);

        return view('requests')->with(
            ['data' => $data, 
            'sliderAction' => 'requests', 
            'subAction' => '']
        );
        } else {
            return redirect('admin/');
        }
    }

    public function deleteRequest(Request $request) {
        $update_id = array('id' => $request->id);
        $data = array(
            'is_history' => 1
        );
        $result = DB::table('services')
                ->where($update_id)
                ->update($data);
        if($result) {
            return back();
        } else {
            return back();
        }
    }
}
