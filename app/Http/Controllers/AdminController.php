<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Imports\InvoiceImport;
use App\models\User;
use App\models\Appusers;
use App\models\Category;
use App\models\AppBanner;
use App\models\ServiceFeature;
use App\models\ServiceFeatureType;
use App\models\Cart;
use App\models\UsersDeliveryAddress;
use App\models\UserTransactions;
use App\models\ReferalCode;
use App\models\Wallet;
use App\models\Appmajdoors;
use App\models\State;
use App\models\City;
 
use Excel;
use DateTime;
use HTML,Form,Validator,Mail,Response,Session,DB,Redirect,Image,Password,Cookie,File,View,Hash,JsValidator,Input,URL;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['index','getServiceFeatureType','getCategories','addOrUpdate','getServiceFeature','addOrUpdateServiceFeature','getServiceFeatureType','addOrUpdateServiceType','appUsers','UsersAllTransactions','getDeliveries','getAllMajdoors','import','addUpdateMajdoor','getStates','addUpdateState','getCities','addUpdateCity']);   
    }
    public function index()
    {
        //return view('home');
        $data = [];
        return view('admin.dashboard',$data);   
    }
    #login admin
    public function login(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email'              => 'required|Email',
                'password'           => 'required',
            ]);
            if($validator->fails()) {
                Session::flash('flash_message', $validator->messages());    
                return back();
            }
            $userdata = array(
                'email'     =>  $request['email'],
                'password'  =>  $request['password'],
            );
            //check in auth for login
            if(Auth::attempt($userdata)){
                $user_role = User::where('email',$request['email'])->value('role');
                if($user_role == "1"){
                    $admin = User::where('email',$request['email'])->first();
                    // $request->session()->put('data', $admin);
                    return redirect('/dashboard');
                }else{
                    Session::flash('flash_message','User is not exist.');
                    return back();
                }
            }else{
                Session::flash('flash_message','User is not exist.');    
                return back();
            }    
        }catch(\Exception $e){
            Session::flash('flash_message',"Something went wrong. please contact to administration"); 
            return back();
        } 
    }
    #get all category
    public function getCategories(Request $request){
        try{
             
            if($request->search){
                $categories = Category::where('delete_status','1')
                                           ->where('categories','LIKE','%'.$request->search.'%')
                                           ->paginate(10);
                if(!empty($categories)){
                    return view('admin.all_categories',compact('categories'));
                }
                else{
                    return view('admin.all_categories',compact('categories'));
                }             
            }
            $categories = Category::where('delete_status','1')->paginate(10);
            return view('admin.all_categories',compact('categories'));
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }
    }
    # add update category
    public function addOrUpdate(Request $request){
        try{
            #check if admin
            if($request->id){
                $categoryData = Category::where('id',$request->id)->first();
                if($categoryData){
                    $returnData = Category::where('id',$request->id)->update([
                        'categories'=> $request->categories,
                        'updated_at'=> date('Y-m-d')
                    ]);
                    if($returnData){
                        Session::flash('flash_message',"Category has been updated."); 
                        return redirect('/category');  
                    }else{
                        Session::flash('flash_error',"category has not been updated.Please contact to administrator."); 
                        return redirect('/category');    
                    }
                }else{
                    Session::flash('flash_error',"Category not found with this data.Please try again"); 
                    return back();                    
                }
            }else{
                #add category
                $category = new Category();
                $category->categories     = $request->categories;
                $category->delete_status  = "1";
                $category->created_at     = date("Y-m-d");
                $category->save();
                if($category->id){
                    Session::flash('flash_message',"Category has been added."); 
                    return redirect('/category');
                }else{
                    Session::flash('flash_error',"category has not been added.Please contact to administrator."); 
                    return redirect('/category'); 
                } 
            }
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }
    }
    #get all service feature
    public function getServiceFeature(Request $request){
        try{
            $categories = Category::where('delete_status','1')->get();
            if($request->search){
                $serviceFeatures = ServiceFeature::with('categories')->where('delete_status','1')
                                           ->where('service_type','LIKE','%'.$request->search.'%')
                                           ->paginate(10);
                if(!empty($serviceFeatures)){
                    return view('admin.all_service_features',compact('serviceFeatures','categories'));
                }
                else{
                    return view('admin.all_service_features',compact('serviceFeatures','categories'));
                }             
            }
            $serviceFeatures = ServiceFeature::with('categories')->where('delete_status','1')->paginate(10);
            return view('admin.all_service_features',compact('serviceFeatures','categories'));
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }
    }
    # add update service features
    public function addOrUpdateServiceFeature(Request $request){
        try{
            if($request->id){
                $serviceFeatureData = ServiceFeature::where('id',$request->id)->first();
                if($serviceFeatureData){
                    $returnData = ServiceFeature::where('id',$request->id)->update([
                       
                        'cat_id'=> $request->cat_id,
                        'service_type'=> $request->service_type,
                        'updated_at'=> date('Y-m-d')
                    ]);
                    if($returnData){
                        Session::flash('flash_message',"Service has been updated."); 
                        return redirect('/service-features');  
                    }else{
                        Session::flash('flash_error',"Service has not been updated.Please contact to administrator."); 
                        return redirect('/service-features');    
                    }
                }else{
                    Session::flash('flash_error',"Service not found with this data.Please try again"); 
                    return back();                    
                }
            }else{
                #add Service
                $serviceFeature = new ServiceFeature();
                $serviceFeature->cat_id         = $request->cat_id;
                $serviceFeature->service_type   = $request->service_type;
                $serviceFeature->delete_status  = "1";
                $serviceFeature->created_at     = date("Y-m-d");
                 
                $serviceFeature->save();
                if($serviceFeature->id){
                    Session::flash('flash_message',"Features has been added."); 
                    return redirect('/service-features');
                }else{
                    Session::flash('flash_error',"features has not been added.Please contact to administrator."); 
                    return redirect('/service-features'); 
                } 
            }
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }
    }
    #get service feature type
    public function getServiceFeatureType(Request $request){
        try{
            $serviceFeature = ServiceFeature::where('delete_status','1')->get();
            if($request->search){
                $serviceFeaturesType = ServiceFeatureType::with(['getServiceFeature'])->where('delete_status','1')
                                                      ->where('type','LIKE','%'.$request->search.'%')
                                                      ->paginate(10);
                if(!empty($serviceFeaturesType)){
                    return view('admin.all_service_features_type',compact('serviceFeature','serviceFeaturesType'));
                }
                else{
                    return view('admin.all_service_features_type',compact('serviceFeature','serviceFeaturesType'));
                }             
            }
            $serviceFeaturesType = ServiceFeatureType::with(['getServiceFeature'])->where('delete_status','1')->paginate(10);
            return view('admin.all_service_features_type',compact('serviceFeature','serviceFeaturesType'));
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }
    }
    #add update service type 
    public function addOrUpdateServiceType(Request $request){
        try{
            if($request->id){
                $serviceFeatureTypeData = ServiceFeatureType::where('id',$request->id)->first();
                if($serviceFeatureTypeData){
                    $returnData = ServiceFeatureType::where('id',$request->id)->update([
                        'service_features_id'=> $request->service_features_id,
                        'type'=> $request->type,
                        'price'=> $request->price,
                        'updated_at'=> date('Y-m-d')
                    ]);
                    if($returnData){
                        Session::flash('flash_message',"Service Type has been updated."); 
                        return redirect('/search-service-type');  
                    }else{
                        Session::flash('flash_error',"Service Type has not been updated.Please contact to administrator."); 
                        return redirect('/search-service-type');    
                    }
                }else{
                    Session::flash('flash_error',"Service Type not found with this data.Please try again"); 
                    return back();                    
                }
            }else{
                #add Service Type
                $model = new ServiceFeatureType();
                $model->service_features_id      = $request->service_features_id;
                $model->type         = $request->type;
                $model->price   = $request->price;
                $model->delete_status  = "1";
                $model->created_at     = date("Y-m-d");
                 
                $model->save();
                if($model->id){
                    Session::flash('flash_message',"Service Type has been added."); 
                    return redirect('/search-service-type');
                }else{
                    Session::flash('flash_error',"Service type has not been added.Please contact to administrator."); 
                    return redirect('/search-service-type'); 
                } 
            }
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }
    }
    #app users
    public function appUsers(Request $request){
        try{
            if($request->search){
                $appUsers = Appusers::where('delete_status','1')
                                     ->where('name','LIKE','%'.$request->search.'%')
                                     ->paginate(10);

                if(!empty($appUsers)){
                    return view('admin.app_users',compact('appUsers'));
                }
                else{
                    return view('admin.app_users',compact('appUsers'));
                }             
            }
            $appUsers = Appusers::where('delete_status','1')->paginate(10);
            return view('admin.app_users',compact('appUsers'));
           // $image_base_url = "http://www.projects.estateahead.com/hemkund/storage/app/";
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }

    }
    #get Users transaction
    public function UsersAllTransactions(Request $request){
        try{
            if($request->search){
                $usersTransactions = UserTransactions::where('order_id','LIKE','%'.$request->search.'%')->paginate(10);
                if(!empty($usersTransactions)){
                    return view('admin.users_transaction',compact('usersTransactions'));
                }
                else{
                    return view('admin.users_transaction',compact('usersTransactions'));
                }             
            }
            $usersTransactions = UserTransactions::orderBy('created_at','asc')->paginate(10);
          
            return view('admin.users_transaction',compact('usersTransactions'));
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }
    }
    
    #get deliveries
    public function getDeliveries(Request $request){
        try{
            if($request->search){
                $usersTransactions = UserTransactions::where('order_id','LIKE','%'.$request->search.'%')->paginate(10);
                
                if(!empty($usersTransactions)){
                    return view('admin.users_deliveries',compact('usersTransactions'));
                }
                else{
                    return view('admin.users_deliveries',compact('usersTransactions'));
                }             
            }
            $usersTransactions = UserTransactions::orderBy('created_at','asc')->paginate(20);
            //dd($usersTransactions);die;
            return view('admin.users_deliveries',compact('usersTransactions'));
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }
    }
    # Get all service providers
    public function getAllMajdoors(Request $request){
        try{
            $categories = Category::where('delete_status','1')->get();
            $states =  State::all();
            $cities =  City::all();
            $serviceFeatures = ServiceFeature::all();

            if($request->search){
                $majdoors = Appmajdoors::where('pin_code','LIKE','%'.$request->search.'%')->where('delete_status','1')->paginate(20);
                if(!empty($serviceProviders)){
                    return view('admin.service_providers',compact('majdoors','categories','serviceFeatures','states','cities'));
                }
                else{
                    return view('admin.service_providers',compact('majdoors','categories','serviceFeatures','states','cities'));
                }             
            }
            $majdoors = Appmajdoors::where('delete_status','1')->paginate(20);
            return view('admin.service_providers',compact('majdoors','categories','serviceFeatures','states','cities'));
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }
    }
    #import service data provider
    public function import(Request $request)
    {
        try{
           //validate the xls file
            $this->validate($request, array(
                'file'      => 'required'
            ));
        
            if($request->hasFile('file')){
                //$extension = File::extension($request->file->getClientOriginalName()); also we can use
                $extension = $request->file->getClientOriginalExtension();
                
                if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                    $file_name = 'service_provider_'.date('d-m-y').".".$request->file->getClientOriginalExtension();
                    
                    $path = Storage::put($file_name, $request->file,'public');
                    $path = $request->file->storeAs('public/service_files', $file_name);
                    Excel::import(new InvoiceImport, $path);
                    
                    Session::flash('flash_message', 'Your Data has successfully imported');
                    return back();
                }else {
                    Session::flash('flash_error', 'File is a '.$extension.' file.!! Please upload a valid xls/xlsx/csv file..!!');
                    return redirect('/service-deliveries');
                }
            }
        }catch(\Exception $e){
            return view('admin.error_pages.excel_wrong_formate');
        }
    } 
    # add update service features
    public function addUpdateMajdoor(Request $request){
        try{
            if($request->id){
                $majdoor = Appmajdoors::where('id',$request->id)->first();
                if($majdoor){
                    $returnData = Appmajdoors::where('id',$request->id)->update([
                        'cat'    => $request->cat,
                        'service_type'=> $request->service_type,
                        'name'   => $request->name,
                        'phone'  => $request->phone,
                        'gender' => $request->gender,
                        'dob'    => date('d-M-y',strtotime($request->dob)),
                        'state'  => $request->state,
                        'city'   => $request->city,
                        'address'=> $request->address,
                        'pin_code'=>$request->pin_code,
                        'updated_at'=> date('Y-m-d')
                    ]);
                    if($returnData){
                        Session::flash('flash_message',"Majdoor has been updated."); 
                        return back();  
                    }else{
                        Session::flash('flash_error',"Majdoor has not been updated.Please contact to administrator."); 
                        return back();    
                    }
                }else{
                    Session::flash('flash_error',"Majdoor not found with this data.Please try again"); 
                    return back();                    
                }
            }else{
                #add Service provider
                $model = new Appmajdoors();
                $model->cat          = $request->cat;
                $model->service_type      = $request->service_type;
                $model->name         = $request->name;
                $model->phone        = $request->phone;
                $model->gender       = $request->gender;
                $model->dob          = date('d-M-y',strtotime($request->dob));
                $model->state        = $request->state;
                $model->city         = $request->city;
                $model->address      = $request->address;
                $model->pin_code     = $request->pin_code;
                $model->password     = encrypt($request->password);
                $model->status       = "1";
                $model->delete_status= "1";
                $model->created_at   = date("Y-m-d");
                $model->save();
                if($model->id){
                    Session::flash('flash_message',"Majdoor has been added."); 
                    return back();
                }else{
                    Session::flash('flash_error',"Majdoor has not been added.Please contact to administrator."); 
                    return back(); 
                } 
            }
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }
    }
    #change Status
    public function changeStatus(Request $request){
        try{
            if($request->id){
                $data = Appmajdoors::where('id',$request->id)->first();
                if(!empty($data)){
                    if($data->status=="1"){
                        $data->update(['status' => '0']);
                        Session::flash('flash_message',"Status Updated to Unavailable");
                        return redirect('/service-providers');
                    }elseif($data->status=="0"){
                        $data->update(['status' => '1']);
                        Session::flash('flash_message',"Status Updated to Available");
                        return redirect('/service-providers');
                    }else{
                        Session::flash('flash_error',"Something went wrong.please contact to administrator.");
                        return redirect('/service-providers');
                    }
                    
                }else{
                    Session::flash('flash_error',"Mazdurr not found.please contact to administrator.");
                    return redirect('/service-providers');
                }
            }else{
                Session::flash('flash_error',"Something went wrong please try again.");
                return redirect('/service-providers');
            }
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }
    }
    # Get all states
    public function getStates(Request $request){
        try{
          
            if($request->search){
                $states = State::where('state','LIKE','%'.$request->search.'%')->paginate(20);
                if(!empty($states)){
                    return view('admin.states',compact('states'));
                }
                else{
                    return view('admin.states',compact('states'));
                }             
            }
            $states = State::orderBy('state')->paginate(20);
            return view('admin.states',compact('states'));
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }
    }
   
    # add update state
    public function addUpdateState(Request $request){
        try{
            if($request->id){
                $categoryData = State::where('id',$request->id)->first();
                if($categoryData){
                    $returnData = State::where('id',$request->id)->update([
                        'state'=> $request->state,
                        'updated_at'=> date('Y-m-d')
                    ]);
                    if($returnData){
                        Session::flash('flash_message',"State has been updated."); 
                        return redirect('/state');  
                    }else{
                        Session::flash('flash_error',"State has not been updated.Please contact to administrator."); 
                        return redirect('/state');    
                    }
                }else{
                    Session::flash('flash_error',"Category not found with this data.Please try again"); 
                    return back();                    
                }
            }else{
                #add State
                $state = new State();
                $state->state  = $request->state;
                $state->created_at = date("Y-m-d");
                $state->save();
                if($state->id){
                    Session::flash('flash_message',"State has been added."); 
                    return redirect('/state');
                }else{
                    Session::flash('flash_error',"State has not been added.Please contact to administrator."); 
                    return redirect('/state'); 
                } 
            }
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }
    }
    # Get all Cities
    public function getCities(Request $request){
        try{
            $cities =  City::all();
            $states =  State::all();
            if($request->search){
                $cities = City::where('city','LIKE','%'.$request->search.'%')->paginate(20);
                if(!empty($cities)){
                    return view('admin.cities',compact('cities','states'));
                }
                else{
                    return view('admin.cities',compact('cities','states'));
                }             
            }
            $cities = City::orderBy('city')->paginate(20);
            return view('admin.cities',compact('cities','states'));
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }
    }
    # add update state
    public function addUpdateCity(Request $request){
        try{
            if($request->id){
                $cityData = City::where('id',$request->id)->first();
                if($cityData){
                    $returnData = City::where('id',$request->id)->update([
                        'state_id'=> $request->state_id,
                        'updated_at'=> date('Y-m-d')
                    ]);
                    if($returnData){
                        Session::flash('flash_message',"city has been updated."); 
                        return redirect('/city');  
                    }else{
                        Session::flash('flash_error',"city has not been updated.Please contact to administrator."); 
                        return redirect('/city');    
                    }
                }else{
                    Session::flash('flash_error',"city not found with this data.Please try again"); 
                    return back();                    
                }
            }else{
                #add city
                $city = new City();
                $city->state_id = $request->state_id;
                $city->city = $request->city;
                $city->created_at = date("Y-m-d");
                $city->save();
                if($city->id){
                    Session::flash('flash_message',"city has been added."); 
                    return redirect('/city');
                }else{
                    Session::flash('flash_error',"city has not been added.Please contact to administrator."); 
                    return redirect('/city'); 
                } 
            }
        }catch(\Exception $e){
            return view('admin.error_pages.something_went_wrong');
        }
    }
}
