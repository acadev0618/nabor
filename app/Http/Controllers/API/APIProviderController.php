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
        $user_service = DB::select('select * from user_service');
        if(!$data) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $data, 'user_service' => $user_service]);
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
        $user = DB::select('select * from users where email = "'.$request->email.'" and password = "'.$request->password.'" and user_type = 1');
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
                    STATUS = 3) AND
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
                    STATUS = 3) AND
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
                    (STATUS = 2 OR
                    STATUS = 4 OR
                    STATUS = 5) AND
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
                ->update(array('status' => 2, 'rejected_date' => $currentdatetime, 'reject_reason' => $msg));
        return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success']);
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
                $rate = round(($rate+$cutomer[0]->rate)/2, 1);
                $result = DB::table('users')
                ->where(array('id' => $customer_id))
                ->update(array('rate' => $rate));
            }
            $result = DB::table('services')
            ->where(array('id' => $id))
            ->update(array('status' => 4, 'decliened_date' => $currentdatetime));
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
            ->update(array('status' => 4, 'decliened_date' => $currentdatetime));
        return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to complete this service']);
    }

    public function delete(Request $request) {
        $id = $request->id;
        $result = DB::table('services')
        ->where(array('id' => $id))
        ->update(array('is_history' => 1));
        
        return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success']);
    }

    public function editProfile(Request $request) {
        $update_id = array('id' => $request->id);
        $photo = $request->file('photo');
        $services = explode(",", $request->services);

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
        
        if ($request->is_eq == "yes") {
            $result = DB::table('users')
                ->where($update_id)
                ->update($data);
            $user = DB::select('select * from users where id = '.$request->id, [1]);
            if ($user) {
                return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $user[0]]);
            } else {
                return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to get profile.']);
            }
        } else {
            $current_services = DB::select('select * from services where provider = '.$request->id.' and is_history = 0');
            if ($current_services) {
                return response()->json(['status' => '404', 'error_code' => '1', 'message' => "You have processing services, so you can't update your service category."]);
            } else {
                $result = DB::table('users')
                ->where($update_id)
                ->update($data);
                DB::delete('delete from user_service where user_id = '.$request->id);
                for ($i=0; $i < count($services); $i++) { 
                    DB::table('user_service')->insert(array('user_id' => $request->id, 'service_id' => $services[$i]));
                }
                $user = DB::select('select * from users where id = '.$request->id, [1]);
                if ($user) {
                    return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $user[0]]);
                } else {
                    return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to get profile.']);
                }
            }
        }
    }

    public function getWorkSchedule(Request $request) {
        $id = $request->id;
        $result = DB::select('SELECT * FROM work_time WHERE user_id = '.$id);

        if ($result) {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $result[0]]);
        } else {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Not Exist']);
        }
    }

    public function updateWorkSchedule(Request $request) {
        $user_id = $request->id;
        $data = array(
            'user_id' => $request->id,
            'start_mon' => $request->start_mon,
            'end_mon' => $request->end_mon,
            'start_tue' => $request->start_tue,
            'end_tue' => $request->end_tue,
            'start_wed' => $request->start_wed,
            'end_wed' => $request->end_wed,
            'start_thu' => $request->start_thu,
            'end_thu' => $request->end_thu,
            'start_fri' => $request->start_fri,
            'end_fri' => $request->end_fri,
            'start_sat' => $request->start_sat,
            'end_sat' => $request->end_sat,
            'start_sun' => $request->start_sun,
            'end_sun' => $request->end_sun,
        );
        $result = DB::select('SELECT * FROM work_time WHERE user_id = '.$user_id);

        if ($result) {
            $result = DB::table('work_time')
                ->where(array('user_id' => $user_id))
                ->update($data);
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success']);
        } else {
            $id = DB::table('work_time')->insertGetId($data);
            if ($id) {
                return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success']);
            } else {
                return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Failed to create your work schedule']);
            }
        }
    }
}