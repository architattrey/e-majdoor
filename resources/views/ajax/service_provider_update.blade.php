
{!! Form::open(['url' => 'add-update-service-provider','enctype'=>'multipart/form-data','method'=>'POST']) !!}
<div class="modal-body">
    <!-- row strat -->
    <div class="row">
        {{ Form::hidden('id',($data->id))}}    
        <!-- column 6 -->
        <div class="col-sm-6">
            <!--  Categories -->
            <div class="form-group">
                {{ Form::label('categories', ' Category Name', ['class' => 'categories']) }}
                <select class="form-control" name="cat">
                    <option value="{{(!empty($data->cat))?$data->cat:old('cat')}}">{{(!empty($data->cat))?$data->cat:old('cat')}}</option>
                    @foreach($categories as $category)
                        <option value="{{$category->categories}}">{{$category->categories}}</option>
                    @endforeach
                </select>
            </div>
            <!-- name -->
            <div class="form-group">
                {{ Form::label('name', 'Name', ['class' => 'name']) }}
                {{ Form::text('name',(!empty($data->name))?$data->name:old('name'),['class'=>'form-control','id'=>'name','placeholder'=>'Enter Name', 'required' => 'required']) }}
            </div>
            <!--  gender -->
            <div class="form-group">
                {{ Form::label('gender', 'Gender', ['class' => 'gender']) }}
                <select class="form-control" name="gender">
                    <option value="{{(!empty($data->gender))?$data->gender:old('gender')}}">{{(!empty($data->gender))?$data->gender:old('gender')}}</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                </select>
            </div>
            <!--  states -->
            <div class="form-group">
                {{ Form::label('state', 'State Name', ['class' => 'state']) }}
                <select class="form-control" name="subcat_id">
                    <option value="{{(!empty($data->state))?$data->state:old('state')}}">{{(!empty($data->state))?$data->state:old('state')}}</option>
                    @foreach($states as $state)
                        <option value="{{$state->state}}">{{$state->state}}</option>
                    @endforeach
                </select>
            </div>
            <!-- pin code -->
            <div class="form-group">
                {{ Form::label('pin_code', 'Pin Code', ['class' => 'pin_code']) }}
                {{ Form::number('pin_code',(!empty($data->pin_code))?$data->pin_code:old('pin_code'),['class'=>'form-control','id'=>'pin_code','placeholder'=>'Enter Pin code', 'required' => 'required']) }}
            </div>
        </div>
         
        <!--/column 6  -->
        <!-- column 6 -->
        <div class="col-sm-6">
           
            <!--  Service feature -->
            <div class="form-group">
                {{ Form::label('service_feature', 'Service Feature Name', ['class' => 'name']) }}
                <select class="form-control" name="service_type">
                    <option value="{{(!empty($data->service_type))?$data->service_type:old('service_type')}}">{{$data->service_type}}</option>
                    @foreach($serviceFeatures as $serviceFeature)
                    <option value="{{$serviceFeature->service_type}}">{{$serviceFeature->service_type}}</option>
                    @endforeach
                </select>
            </div>
            <!-- phone number -->
            <div class="form-group">
                {{ Form::label('contact_number', 'Contact Number', ['class' => 'contact_number']) }}
                {{ Form::text('phone',(!empty($data->phone))?$data->phone:old('phone'),['class'=>'form-control','id'=>'phone','placeholder'=>'Enter Contact Number', 'required' => 'required']) }}
            </div>
            <!--  dob -->
            <div class="form-group">
                {{ Form::label('dob', 'Date Of Birth', ['class' => 'dob']) }}
                {{ Form::date('dob',(!empty($data->dob))?$data->dob:old('dob'),['class'=>'form-control','id'=>'dob','required' => 'required']) }}
            </div>
            <!--  city -->
            <div class="form-group">
                {{ Form::label('city', 'City Name', ['class' => 'city']) }}
                <select class="form-control" name="city">
                <option value="{{(!empty($data->city))?$data->city:old('city')}}">{{(!empty($data->city))?$data->city:old('city')}}</option>
                    @foreach($cities as $city)
                        <option value="{{$city->city}}">{{$city->city}}</option>
                    @endforeach
                </select>
            </div>
            <!-- password -->
            <div class="form-group">
                {{ Form::label('password', 'Password [Cant change]',['class' => 'password']) }}
                {{ Form::text('password',(!empty($data->password))?decrypt($data->password):old('password'),['class'=>'form-control','id'=>'password','placeholder'=>'Make password for this user', 'required' => 'required','readonly' => 'true']) }}
            </div>
        </div>
        <div class ="col-sm-12">
            <!--  address -->
            <div class="form-group">
                {{ Form::label('address', 'Address', ['class' => 'address']) }}
                {{ Form::textarea('address',(!empty($data->address))?$data->address:old('address'), ['rows'=> 3,'class'=>'form-control','id'=>'address','placeholder'=>'Enter Address', 'required' => 'required']) }}
            </div>
        </div>
    </div>
    <!--/ row end -->
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-success">Update</button>
    {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
</div>
{!! Form::close() !!}
@section('script')
@endsection