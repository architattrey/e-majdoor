@extends('admin.layouts.app')

@section('content')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">All Majdoor</li>
      </ol>
    </section>
    <div class="row">
        <div class="col-md-12 col-sm-12">
           
            <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">

                <div class="col-sm-6">
                    {!! Form::open(['url' => 'search-service-providers','method'=>'GET']) !!}
                        {{ Form::text('search',old('search'),['id'=>'search','placeholder'=>' Search By Pin Code']) }}
                        <button type="submit" class="btn btn-warning" id="search_btn"><i class="fa fa-search" aria-hidden="true"></i> &nbsp;Search</button>
                    {!! Form::close() !!}
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary" id="add_more">Add More Majdoor</button>
                    <!-- <a style="margin-top: 5px; padding: 10px 17px; float: right;b margin-right: 17px;" href="#"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Emport xls file</button></a> -->
                </div> 
            </div>
        </div>
    </div>

    <!-- view list of agents -->
    <!-- Main content -->
    <section class="content">
        @if(Session::has('flash_message'))
        <div class="alert alert-success"><strong>Success!</strong>  {!! session('flash_message') !!}</div>
        @elseif(Session::has('flash_error'))
        <div class="alert alert-danger"><strong>Danger!</strong> {!! session('flash_error') !!} </div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <div class="listing" style="background-color: white;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Service Type</th>
                                <th>Name</th>
                                <th>Contact Number</th>
                                <th>state</th>
                                <th>city</th>
                                <th>Pin Code</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($majdoors) && isset($majdoors ))
                                @foreach($majdoors  as $key => $majdoor)
                                @if($majdoor->status=='1')
                                   @php $class ="label label-success";
                                        $status = "Available";
                                   @endphp
                                @else
                                    @php $class ="label label-danger";
                                         $status = "Unavailable";
                                    @endphp
                                @endif
                                @php 
                                    $key++;
                                @endphp
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$majdoor->cat ?ucfirst($majdoor->cat):"NA" }}</td>
                                        <td>{{$majdoor->service_type ? ucfirst($majdoor->service_type): "NA" }}</td>
                                        <td>{{$majdoor->name ? ucfirst($majdoor->name):   "NA" }}</td>
                                        <td>{{$majdoor->phone ? ucfirst($majdoor->phone): "NA" }}</td>
                                        <td>{{$majdoor->state ? ucfirst($majdoor->state): "NA" }}</td>
                                        <td>{{$majdoor->city ? ucfirst($majdoor->city) :  "NA" }}</td>
                                        <td>{{$majdoor->pin_code ? $majdoor->pin_code :   "NA" }}</td>
                                         <td><textarea class="form-control" row="3" disabled>{{$majdoor->address ? $majdoor->address: "NA" }}</textarea></td>
                                        <td><span class="<?=$class?>"><?=$status?></span></td>
                                        <td>{{$majdoor->created_at ? date('d-m-Y',strtotime($majdoor->created_at)): "NA"}}</td>
                                        <td>{{$majdoor->updated_at ? date('d-m-Y',strtotime($majdoor->updated_at)): "NA"}}</td>
                                        <td>

                                            <a href="{{url('change-status/'.$majdoor->id)}}"><i class="fa fa-reply"style="font-size:16px;color:blue" aria-hidden="true"></i></a>&nbsp;
                                            <a href="#"><i class="fa fa-pencil update-modal" style="font-size:16px;color:green" data-toggle="tooltip" title="Update majdoor" id="{{$majdoor->id}}" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a href="#"><i class="fa fa-trash delete-service$majdoor" style="font-size:16px;color:red" data-toggle="tooltip" title="Delete majdoor" id="{{$majdoor->id}}" aria-hidden="true"></i></a>&nbsp;
                                        </td>
                                    </tr>
                                @endforeach 
                            @else
                            <tr><td><p>Majdoors not found</p></td></tr>  
                            @endif  
                        </tbody> 
                    </table>
                   <div class="row">
                        <div class="col-sm-9"></div>
                        <div class="col-sm-3">
                            <div class ="pagination" style="margin-left: 75px;">
                                {{$majdoors->links()}}
                            </div>    
                        </div>     
                   </div>
                </div>
            </div>
        </div>
        <!-- add service providers modal -->
        <div class="modal fade" id="addServiceProvider" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want add majdoors!</h4>
                    </div>
                    <div class="modal-body">
                        <!-- row strat -->
                        <div class="row">
                            {!! Form::open(['url' => 'add-update-service-provider','enctype'=>'multipart/form-data','method'=>'POST']) !!}
                            <!-- column 6 -->
                            <div class="col-sm-6">
                                <!--  Categories -->
                                <div class="form-group">
                                    {{ Form::label('categories', ' Category Name', ['class' => 'name']) }}
                                    <select class="form-control" name="cat">
                                        <option value="">Please Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->categories}}">{{$category->categories}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- name -->
                                <div class="form-group">
                                    {{ Form::label('name', 'Name',['class' => 'name']) }}
                                    {{ Form::text('name',old('name'),['class'=>'form-control','id'=>'name','placeholder'=>'Enter Name', 'required' => 'required']) }}
                                </div>
                                <!--  gender -->
                                <div class="form-group">
                                    {{ Form::label('gender', 'Gender', ['class' => 'gender']) }}
                                    <select class="form-control" name="gender">
                                        <option value="">Please Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <!--  states -->
                                <div class="form-group">
                                    {{ Form::label('state', 'State Name', ['class' => 'state']) }}
                                    <select class="form-control" name="subcat_id">
                                        <option value="">Please Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->state}}">{{$state->state}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- pin code -->
                                <div class="form-group">
                                    {{ Form::label('pin_code', 'Pin Code', ['class' => 'pin_code']) }}
                                    {{ Form::number('pin_code',old('pin_code'),['class'=>'form-control','id'=>'pin_code','placeholder'=>'Enter Pin code', 'required' => 'required']) }}
                                </div>
                            </div>
                            <!--/column 6  -->
                            <!-- column 6 -->
                            <div class="col-sm-6">
                                <!--  Service feature -->
                                <div class="form-group">
                                    {{ Form::label('service_feature', 'Service Feature Name', ['class' => 'name']) }}
                                    <select class="form-control" name="service_type">
                                        <option value="">Please Select Service Feature</option>
                                        @foreach($serviceFeatures as $serviceFeature)
                                            <option value="{{$serviceFeature->service_type}}">{{$serviceFeature->service_type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- phone number -->
                                <div class="form-group">
                                    {{ Form::label('contact_number', 'Contact Number', ['class' => 'contact_number']) }}
                                    {{ Form::text('phone',old('phone'),['class'=>'form-control','id'=>'phone','placeholder'=>'Enter Contact Number', 'required' => 'required']) }}
                                </div>
                                <!--  dob -->
                                <div class="form-group">
                                    {{ Form::label('dob', 'Date Of Birth', ['class' => 'dob']) }}
                                    {{ Form::date('dob',old('dob'),['class'=>'form-control','id'=>'dob','required' => 'required']) }}
                                    
                                </div>
                                <!--  city -->
                                <div class="form-group">
                                    {{ Form::label('city', 'City Name', ['class' => 'city']) }}
                                    <select class="form-control" name="city">
                                        <option value="">Please Select State</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->city}}">{{$city->city}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- password -->
                                <div class="form-group">
                                    {{ Form::label('password', 'Generate Password',['class' => 'password']) }}
                                    {{ Form::text('password',old('password'),['class'=>'form-control','id'=>'password','placeholder'=>'Make password for this user', 'required' => 'required']) }}
                                </div>
                            </div>
                            <!--/column 6  -->
                            <div class="col-sm-12">
                                <!--  address -->
                                <div class="form-group">
                                    {{ Form::label('address', 'Address', ['class' => 'address']) }}
                                    {{ Form::textarea('address', old('address'), ['rows'=> 3,'class'=>'form-control','id'=>'address','placeholder'=>'Enter Address', 'required' => 'required']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- update Filed Boy modal -->
         <div class="modal fade" id="updateServiceProvider" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want update Majdoor</h4>
                    </div>
                    <div class="append">
                    <!-- you will append the html here -->
                    </div>
                </div>
            </div>
        </div>
        <!-- modal open for import file -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Import Bulk Data of Service provider</h4>
                    </div>
                    <div class="modal-body">
                    {!! Form::open(['url' => 'import-file','enctype'=>'multipart/form-data']) !!}
                        {{ Form::file('file',['class'=>'custom-file-input']) }}   
                    </div>
                    <div class="modal-footer">
                        {{ Form::submit('Submit',['class'=>'btn btn-success']) }}
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- modal close -->
    </section>    
    <!-- /.content -->
@endsection
@section('script')
<script>
    
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();  
        $('#add_more').click(function(){
            $('#addServiceProvider').modal('show');
        });
        
        // update modal with filed data
        $('.update-modal').click(function(){
            var serviceProviderId =  $(this).attr('id');
            if(serviceProviderId != " "){
                $.ajax({
                    type:"GET",
                    url:"{{url('update-view-service-provider')}}?serviceProviderId="+serviceProviderId,
                    success:function(res){   
                        if(res.status == "success"){
                            $('.append').html(res.html);
                            $('#updateServiceProvider').modal('show');
                        }else{
                            swal("Something went wrong!", "Contact to administrator!", "error");
                        }
                    }
                });  
            }else{  
                swal("Something went wrong!", "Contact to administrator!", "error"); 
            } 
        });
        // delete data
        $('.delete-service-provider').click(function(){
            var serviceProviderId =  $(this).attr('id');
            if(serviceProviderId != " "){  
                $.ajax({
                    type:"GET",
                    url:"{{url('delete-service-provider')}}?serviceProviderId="+serviceProviderId,
                    success:function(res){   
                        if(res.status == "success"){
                            location.reload();
                        }else{
                            swal("Something went wrong!", "Contact to administrator!", "error");
                        }
                    }
                });  
            }else{  
                swal("Something went wrong!", "Contact to administrator!", "error"); 
            } 
        });
    });
</script>
@endsection	
 
