<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\models\User;
use App\models\Appusers;
use App\models\Appmajdoors;
use App\models\UserTransactions;
 
use HTML,Form,Validator,Mail,Response,Session,DB,Redirect,Image,Password,Cookie,File,View,JsValidator,URL,Excel;

class MajdoorApiController extends Controller
{
    public function majdoorLogin(Request $request){
        try{
            if(!empty($request->phone_number) && !empty($request->password)){
                $validator = Validator::make($request->all(), [
                    'phone_number' => 'required|integer',
                    'password' => 'required',
                ]);
                if($validator->fails()) {
                    return response()->json([
                        'message'=>$validator->messages(),
                        'status'=>'error'
                    ]);
                }
                $majdoorData = Appmajdoors::where('phone_number',$request->phone_number)
                                            ->where('delete_status','1')
                                            ->first();
                if(!empty($majdoorData)){

                    if(decrypt($majdoorData->password) == $request->password){
                        Appmajdoors::where('phone_number',$request->phone_number)->update([
                            'firebase_token'=>$request->firebase_token
                        ]);
                        return response()->json([
                            'message'=>'successfully login.',
                            'status'=>'success',
                            'code'=>200,
                            'response'=>$majdoorData
                        ]);
                    }else{
                        return response()->json([
                            'message'=>'Password is incorrect',
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>'Data is not Exist',
                        'status'=>'error'
                    ]);
                }    
            }else{
                return response()->json([
                    'message'=>'Provide phone number and password',
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'

            ]);
        }
    }
    #app majdoor profile update
    public function majdoorProfileUpdate(Request $request){
        try{
            $response = [];
            $appMajdoorId = $request->majdoor_id;
            //check request have data or not
            if(!empty($appMajdoorId) && isset($appMajdoorId)){
                $appMajdoor = Appmajdoors::where('id',$appMajdoorId)->first();
                //check user is in database
                if(!empty($appMajdoor) && isset($appMajdoor)) {
                    Appmajdoors::where('id',$appMajdoorId)->update([
                        
                       'name'       => $request->name,
                       'phone'      => $request->phone_number,
                       'gender'     => $request->gender,
                       'state'      => ucfirst($request->state),
                       'city'       => ucfirst($request->city),
                       'dob'        => $request->dob,
                       'address'    => $request->address,
                       'updated_at' => date("Y-m-d"),
                    ]);
                    
                    $response['appMajdoor'] =  Appmajdoors::where('id', $appMajdoorId)->first();
                    return response()->json([
                        'message'=>'Profile successfully updated',
                        'status'=>'success',
                        'data'=>$response
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Majdoor not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'You are not able to performe this task',
                    'status'=>'error'
                ]);
            }        
        }catch(\Exception $e){
            return response()->json([
                "message" => "Something went wrong. Please contact administrator.".$e->getMessage(),
                "status" =>'error',
            ]);
        }
    }
    # majdoor image upload
    public function imageUpload(Request $request){
        try{

            $appMajdoorId = $request->majdoor_id;
            //check request have data or not
            if(!empty($appMajdoorId) && isset($appMajdoorId)){
                $appMajdoor = Appmajdoors::where('id',$appMajdoorId)->first();
                //check user is in database
                if (!empty($appMajdoor) && isset($appMajdoor)) {
                    $validator = Validator::make($request->all(), ['image' => 'required']);
                    if ($validator->fails()) {
                        return response()->json([
                            'message'=>$validator->messages(),
                            'status'=>'error'
                        ]);
                    }
                    if($request->image){
                        $file_name = 'public/majdoor_images/_user'.time().'.png';
                        $path = Storage::put($file_name, base64_decode($request->image),'public');
                        if($path==true){
                            //update image of user
                            $appUsers =   Appmajdoors::where('id', $appMajdoorId)->first();
                            $appUsers->update(['image' => $file_name]);
                            $finalPath = $file_name ? url('/').'/storage/app/'.$file_name : url('/')."/public/dist/img/user-dummy-pic.png";
                            return response()->json([
                                'message'=>'Image successfully uploaded',
                                'status'=>'success',
                                'response'=>$finalPath,
                                'code'=>200
                            ]);

                        }else{
                            return response()->json([
                                'message'=>'Something went wrong with request.Please try again later',
                                'status'=>'error'
                            ]);
                        }
                    }else{
                        return response()->json([
                            'message'=>'Please provide image for uploading',
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>'Majdoor not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'You are not able to performe this task',
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                "message" => "Something went wrong. Please contact administrator.".$e->getMessage(),
                "error" =>true,
            ]);
        }
    }
    #change status
    public function changeStatus(Request $request){
        try{
            if(!empty($request->majdoor_id) && !empty($request->status)){
                $majdoorData = Appmajdoors::where('id',$request->majdoor_id)
                                            ->where('delete_status','1')
                                            ->first();
                #status will update in enum formate
                if(!empty($majdoorData)){
                    if(($request->status == '1') || ($request->status == '2')){
                        $returnData = Appmajdoors::where('id',$request->majdoor_id)
                                                ->update([
                                                   'status'=>$request->status
                                                ]);
                    }else{
                        return response()->json([
                            'message'=>'status acceptable only in 1 or 2.',
                            'status' =>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>'Majdoor not found in our database.',
                        'status' =>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'Please provide id and status.',
                    'status' =>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'

            ]);
        }
    }
    #update firebase token
    public function updateFireBaseToken(Request $request){
        try{
            if($request->majdoorId  &&  $request->fireBaseToken){
                $appMajdoor = Appmajdoors::where('id',$request->majdoorId)->first();
                if($appMajdoor){
                    $updateToken = Appmajdoors::where('id',$request->majdoorId)->update([
                        'firebase_token'    => $request->fireBaseToken,
                    ]);
                    if($updateToken){
                        return response()->json([
                            'message'=>"token successfully updated",
                            'status' =>'success',
                            'code' =>200,
                        ]);
                    }else{
                        return response()->json([
                            'message'=>'token is not updated yet. please try again',
                            'status' =>'error',
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>'majdoor is not found in database',
                        'status' =>'error',
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>' majdoorId or token not provided',
                    'status' =>'error',
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"something went wrong.Please contact administrator.".$e->getMessage(),
                'error' =>true,
            ]);
        }
    }
    #get Order Details
    public function getOrderDetails(Request $request){
        try{
            $service_type_ids = [];
            $response['service_type_data'] = [];
            if(!empty($request->majdoor_id)){
               $response['userTransections'] = $userTransections = UserTransactions::where('majdoor_id',$request->majdoor_id)->with(['majdoor'])->get();
                for($i=0; $i<count($userTransections); $i++){
                    $service_type_id =  json_decode($userTransections[$i]->service_type_id);
                    array_push($service_type_ids,$service_type_id);
                }
                for($i=0; $i<count($service_type_ids); $i++){
                    for($j=0; $j<count($service_type_ids[$i]); $j++){
                       
                        $serviceType = ServiceFeatureType::where('id', $service_type_ids[$i][$j])->where('delete_status','1')->first();
                        array_push($response['service_type_data'],$serviceType);
                    }
                }
                if($response){
                    #send response
                    return response()->json([
                        'message'=>'All assigned tasks',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message' => 'No tasks found',
                        'status' => 'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message' => 'Please provide majdoor id',
                    'status' => 'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #give raitings 
    public function majdurUpdateRaiting(Request $request){
        try{
            if($request->raiting && $request->mazdurr_id){
                $data = Appmajdoors::where('id',$request->mazdurr_id)->where('delete_status','1')->first();
                if(!empty($data)){
                    $returnData = Appmajdoors::where('id',$request->user_id)->update([
                        'ratings'=>$request->raiting
                    ]);
                    if($returnData){
                        return response()->json([
                            'message'=>'Raiting updated.',
                            'status' =>'success',
                            'code'=>200
                        ]);

                    }else{
                        return response()->json([
                            'message'=>'Raiting not updated yet.',
                            'status' =>'error'
                        ]);

                    }
                }else{
                    return response()->json([
                        'message'=>'Mazdirr not found.',
                        'status' =>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'Please provide raiting and user id.',
                    'status' =>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);

        }
    }
}
