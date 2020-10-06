<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use DB;

class APICustomerController extends Controller
{

    public function register(Request $request) {
        $dt = new DateTime();
        $currentdatetime = $dt->format('Y-m-d H:i:s');
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
            'user_type' => 0,
            'longitude' => $request->logn,
            'latitude' => $request->lat
        );
        $id = DB::table('users')->insertGetId($data);        
        if(!$id) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to register.']);
        } else {
            $current_user = DB::select('select * from users where id = '.$id);
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

    public function getDataforHome()
    {
        $service_category = DB::select('select * from service_category');
        $users = DB::select('select * from users where user_type = 1 and is_deleted = 0');
        $user_service = DB::select('select T1.*, T2.title from user_service T1 left join service_category T2 on T1.service_id = T2.id');
        if(!$service_category) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'service_category' => $service_category, 'users' => $users, 'user_service' => $user_service]);
        }
    }

    public function sendRequest(Request $request)
    {
        $dt = new DateTime();
        $currentdatetime = $dt->format('Y-m-d H:i:s');
        $data = array(
            'customer' => $request->customer,
            'provider' => $request->provider,
            'service' => $request->service,
            'contents' => $request->contents,
            'created_date' => $currentdatetime
        );
        $service = DB::select('select * from services where customer = '.$request->customer.' and provider = '.$request->provider.' and (status = 0 or status = 1 or status = 2 or status = 4)');
        if ($service) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'You are already hiring the provider']);
        }
        $result = DB::table('services')->insert($data);
        if(!$result) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field to send request.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success']);
        }
    }

    public function getNewRequests(Request $request) {
        $id = $request->id;
        $requests = DB::select('SELECT
                    T1.*,
                    T2.photo provider_photo,
                    T2.display_name provider_name,
                    T2.rate provider_rate,
                    T3.title service_title 
                FROM
                    services T1
                    LEFT JOIN users T2 ON T1.provider = T2.id
                    LEFT JOIN service_category T3 ON T1.service = T3.id 
                WHERE
                    is_history = 0 AND
                    (STATUS = 0 OR
                    STATUS = 1 OR
                    STATUS = 2 OR
                    STATUS = 3) AND
                    customer = '.$id);
        
        return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $requests]);
    }

    public function getNewRequest(Request $request) {
        $id = $request->id;
        $requests = DB::select('SELECT
                    T1.*,
                    T2.photo provider_photo,
                    T2.display_name provider_name,
                    T2.rate provider_rate,
                    T2.address provider_address,
                    T2.about_me provider_aboutme,
                    T2.longitude provider_long,
                    T2.latitude provider_lat,
                    T3.title service_title 
                FROM
                    services T1
                    LEFT JOIN users T2 ON T1.provider = T2.id
                    LEFT JOIN service_category T3 ON T1.service = T3.id 
                WHERE
                    T1.id = '.$id);
        
        if(!$requests) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Data is not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $requests[0]]);
        }
    }

    public function closeRequest(Request $request) {
        $id = $request->id;
        $result = DB::table('services')
                ->where(array('id' => $id))
                ->update(array('is_history' => 1));
        
        if($result != 1) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Fail to delete.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success']);
        }
    }

    public function getActiveRequests(Request $request) {
        $id = $request->id;
        $requests = DB::select('SELECT
                    T1.*,
                    T2.photo provider_photo,
                    T2.display_name provider_name,
                    T2.rate provider_rate,
                    T3.title service_title 
                FROM
                    services T1
                    LEFT JOIN users T2 ON T1.provider = T2.id
                    LEFT JOIN service_category T3 ON T1.service = T3.id 
                WHERE
                    is_history = 0 AND
                    STATUS = 4 AND
                    customer = '.$id);
        
        return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $requests]);
    }

    public function getActiveRequest(Request $request) {
        $id = $request->id;
        $requests = DB::select('SELECT
                    T1.*,
                    T2.photo provider_photo,
                    T2.display_name provider_name,
                    T2.rate provider_rate,
                    T2.address provider_address,
                    T2.about_me provider_aboutme,
                    T2.longitude provider_long,
                    T2.latitude provider_lat,
                    T3.title service_title 
                FROM
                    services T1
                    LEFT JOIN users T2 ON T1.provider = T2.id
                    LEFT JOIN service_category T3 ON T1.service = T3.id 
                WHERE
                    T1.id = '.$id);
        
        if(!$requests) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Data is not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $requests[0]]);
        }
    }

    public function completeAndRateRequest(Request $request) {
        $dt = new DateTime();
        $currentdatetime = $dt->format('Y-m-d H:i:s');
        $id = $request->id;
        $user_id = $request->provider;
        $rate = $request->rate;

        $user = DB::select('select * from users where id = '.$user_id);
        if ($user) {
            if ($user[0]->rate == 0) {
                $result = DB::table('users')
                ->where(array('id' => $user_id))
                ->update(array('rate' => $rate));
            } else {
                $rate = ($rate+$user[0]->rate)/2;
                $result = DB::table('users')
                ->where(array('id' => $user_id))
                ->update(array('rate' => $rate));
            }
            $result = DB::table('services')
            ->where(array('id' => $id))
            ->update(array('status' => 6, 'completed_date' => $currentdatetime));
            if ($result == 1) {
                return response()->json(['status' => '404', 'error_code' => '0', 'message' => 'Success']);
            } else {
                return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to complete this service']);
            }
        } else {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'The user not exist.']);
        }
    }

    public function declienAndRateRequest(Request $request) {
        $dt = new DateTime();
        $currentdatetime = $dt->format('Y-m-d H:i:s');
        $id = $request->id;
        $user_id = $request->provider;
        $rate = $request->rate;

        $user = DB::select('select * from users where id = '.$user_id);
        if ($user) {
            if ($user[0]->rate == 0) {
                $result = DB::table('users')
                ->where(array('id' => $user_id))
                ->update(array('rate' => $rate));
            } else {
                $rate = ($rate+$user[0]->rate)/2;
                $result = DB::table('users')
                ->where(array('id' => $user_id))
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

    public function completeRequest(Request $request) {
        $dt = new DateTime();
        $currentdatetime = $dt->format('Y-m-d H:i:s');
        $id = $request->id;
        $result = DB::table('services')
            ->where(array('id' => $id))
            ->update(array('status' => 6, 'completed_date' => $currentdatetime));
        if ($result == 1) {
            return response()->json(['status' => '404', 'error_code' => '0', 'message' => 'Success']);
        } else {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to complete this service']);
        }
    }

    public function declienRequest(Request $request) {
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

    public function getHistoryRequests(Request $request) {
        $id = $request->id;
        $requests = DB::select('SELECT
                    T1.*,
                    T2.photo provider_photo,
                    T2.display_name provider_name,
                    T2.rate provider_rate,
                    T3.title service_title 
                FROM
                    services T1
                    LEFT JOIN users T2 ON T1.provider = T2.id
                    LEFT JOIN service_category T3 ON T1.service = T3.id 
                WHERE
                    is_history = 0 AND
                    (STATUS = 5 OR
                    STATUS = 6) AND
                    customer = '.$id);
        
        return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $requests]);
    }

    public function getHistoryRequest(Request $request) {
        $id = $request->id;
        $requests = DB::select('SELECT
                    T1.*,
                    T2.photo provider_photo,
                    T2.display_name provider_name,
                    T2.rate provider_rate,
                    T2.address provider_address,
                    T2.about_me provider_aboutme,
                    T2.longitude provider_long,
                    T2.latitude provider_lat,
                    T3.title service_title 
                FROM
                    services T1
                    LEFT JOIN users T2 ON T1.provider = T2.id
                    LEFT JOIN service_category T3 ON T1.service = T3.id 
                WHERE
                    T1.id = '.$id);
        
        if(!$requests) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Data is not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $requests[0]]);
        }
    }

    public function deleteRequest(Request $request) {
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

    public function editProfile(Request $request) {
        $update_id = array('id' => $request->id);
        $photo = $request->file('photo');

        $data = array(
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "display_name" => $request->display_name,
            "phone" => $request->phone,            
            "email" => $request->email,
            "address" => $request->address,
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
        $user = DB::select('select * from users where id = '.$request->id, [1]);
        if ($result == 1) {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $user[0]]);
        } else {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to edit this thread.']);
        }
    }
}