<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use DB;

class APIProviderController extends Controller
{
    public function getServiceCategory()
    {
        $data = DB::select('select * from service_category');
        if(!$data) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $data]);
        }
    }

    public function register(Request $request) {
        $dt = new DateTime();
        $currentdatetime = $dt->format('Y-m-d H:i:s');
        $services = explode(",", $request->services);
        $user = DB::select('select * from users where email = "'.$request->email.'"');
        if ($user) {
            return response()->json(['status' => '405', 'error_code' => '2', 'message' => 'The email exist already.']);
        }
        $data = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'display_name' => $request->display_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => $request->password,
            'created_date' => $currentdatetime,
            'user_type' => 1,
            'longitude' => $request->logn,
            'latitude' => $request->lat
        );
        $id = DB::table('users')->insertGetId($data);
        if ($id) {
            for ($i=0; $i < count($services); $i++) { 
                DB::table('user_service')->insert(array('user_id' => $id, 'service_id' => $services[$i]));
            }
        }
        
        if(!$id) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to register.']);
        } else {
            $current_user = DB::select('select * from users where id = '.$id);
            // $current_services = DB::select('select T1.*, T2.title from user_service T1 left join service_category T2 on T1.service_id = T2.id where user_id = '.$id);
            // return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $current_user[0], 'service_category' => $current_services]);
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $current_user[0]]);
        }
    }

    public function login(Request $request) {
        $user = DB::select('select * from users where email = "'.$request->email.'" and password = "'.$request->password.'"');
        if ($user) {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $user[0]]);
        } else {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Email or Password is not correct.']);
        }
    }

    public function requests(Request $request) {
        $id = $request->id;
        $requests = DB::select('SELECT
                    T1.*,
                    T2.photo customer_photo,
                    T2.display_name customer_name,
                    T2.address customer_address,
                    T2.rate customer_rate,
                    T3.title service_title 
                FROM
                    services T1
                    LEFT JOIN users T2 ON T1.customer = T2.id
                    LEFT JOIN service_category T3 ON T1.service = T3.id 
                WHERE
                    is_history = 0 AND
                    (STATUS = 0 OR
                    STATUS = 1 OR
                    STATUS = 2 OR
                    STATUS = 4) AND
                    provider = '.$id);
        
        $new_requests = DB::select('SELECT
                    T1.*,
                    T2.photo customer_photo,
                    T2.display_name customer_name,
                    T2.address customer_address,
                    T2.rate customer_rate,
                    T3.title service_title 
                FROM
                    services T1
                    LEFT JOIN users T2 ON T1.customer = T2.id
                    LEFT JOIN service_category T3 ON T1.service = T3.id 
                WHERE
                    is_history = 0 AND
                    STATUS = 0 AND
                    provider = '.$id);

        $active_requests = DB::select('SELECT
                    T1.*,
                    T2.photo customer_photo,
                    T2.display_name customer_name,
                    T2.address customer_address,
                    T2.rate customer_rate,
                    T3.title service_title 
                FROM
                    services T1
                    LEFT JOIN users T2 ON T1.customer = T2.id
                    LEFT JOIN service_category T3 ON T1.service = T3.id 
                WHERE
                    is_history = 0 AND
                    (STATUS = 1 OR
                    STATUS = 2 OR
                    STATUS = 4) AND
                    provider = '.$id);

        $history_requests = DB::select('SELECT
                    T1.*,
                    T2.photo customer_photo,
                    T2.display_name customer_name,
                    T2.address customer_address,
                    T2.rate customer_rate,
                    T3.title service_title 
                FROM
                    services T1
                    LEFT JOIN users T2 ON T1.customer = T2.id
                    LEFT JOIN service_category T3 ON T1.service = T3.id 
                WHERE
                    is_history = 0 AND
                    (STATUS = 5 OR
                    STATUS = 6) AND
                    provider = '.$id);
        
        return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'requests' => $requests, 'new_requests' => $new_requests, 'active_requests' => $active_requests, 'history_requests' => $history_requests]);
    }

    public function requestdetail(Request $request) {
        $id = $request->id;
        $result = DB::select('select * from services where id = '.$id);
        if ($result) {
            $customer = DB::select('select * from users where id = '.$result[0]->customer);
            if ($customer) {
                return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'request' => $result[0], 'customer' => $customer[0]]);
            } else {
                return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Data is not exist.']);
            }
        }        
    }

    public function accept(Request $request) {
        $id = $request->id;
        $result = DB::table('services')
                ->where(array('id' => $id))
                ->update(array('status' => 1));
        $result = DB::select('select * from services where id = '.$id);
        if ($result) {
            $customer = DB::select('select * from users where id = '.$result[0]->customer);
            if ($customer) {
                return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'request' => $result[0], 'customer' => $customer[0]]);
            } else {
                return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Data is not exist.']);
            }
        }        
    }

    public function reject(Request $request) {
        $dt = new DateTime();
        $currentdatetime = $dt->format('Y-m-d H:i:s');
        $id = $request->id;
        $msg = $request->message;
        $result = DB::table('services')
                ->where(array('id' => $id))
                ->update(array('status' => 3, 'rejected_date' => $currentdatetime, 'reject_reason' => $msg));
        if ($result != 1) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Failed to reject this request.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success']);
        }
    }

    public function updateStatus(Request $request) {
        $id = $request->id;
        $status = $request->value;
        $result = DB::table('services')
                ->where(array('id' => $id))
                ->update(array('status' => $status));
        $result = DB::select('select * from services where id = '.$id);
        if ($result) {
            $customer = DB::select('select * from users where id = '.$result[0]->customer);
            if ($customer) {
                return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'request' => $result[0], 'customer' => $customer[0]]);
            } else {
                return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Data is not exist.']);
            }
        }
    }

    public function declienAndRateRequest(Request $request) {
        $dt = new DateTime();
        $currentdatetime = $dt->format('Y-m-d H:i:s');
        $id = $request->id;
        $customer_id = $request->customer;
        $rate = $request->rate;

        $cutomer = DB::select('select * from users where id = '.$customer_id);
        if ($cutomer) {
            if ($cutomer[0]->rate == 0) {
                $result = DB::table('users')
                ->where(array('id' => $customer_id))
                ->update(array('rate' => $rate));
            } else {
                $rate = ($rate+$cutomer[0]->rate)/2;
                $result = DB::table('users')
                ->where(array('id' => $customer_id))
                ->update(array('rate' => $rate));
            }
            $result = DB::table('services')
            ->where(array('id' => $id))
            ->update(array('status' => 5, 'decliened_date' => $currentdatetime));
            if ($result == 1) {
                return response()->json(['status' => '404', 'error_code' => '0', 'message' => 'Success']);
            } else {
                return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to declien this service']);
            }
        } else {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'The user not exist.']);
        }
    }

    public function declien(Request $request) {
        $dt = new DateTime();
        $currentdatetime = $dt->format('Y-m-d H:i:s');
        $id = $request->id;
        $result = DB::table('services')
            ->where(array('id' => $id))
            ->update(array('status' => 5, 'decliened_date' => $currentdatetime));
        if ($result == 1) {
            return response()->json(['status' => '404', 'error_code' => '0', 'message' => 'Success']);
        } else {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to complete this service']);
        }
    }

    public function delete(Request $request) {
        $id = $request->id;
        $result = DB::table('services')
        ->where(array('id' => $id))
        ->update(array('is_history' => 1));
        
        if($result != 1) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Failed to delete.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success']);
        }
    }
}