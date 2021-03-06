
  {!! Form::open(['url' => 'add-update-service-feature','enctype'=>'multipart/form-data','method'=>'POST']) !!}
<div class="modal-body">
    <!-- row strat -->
    <div class="row">

        <!-- column 6 -->
        <div class="col-sm-6">
            {{ Form::hidden('id',($data->id))}}
            <!--  Categories -->
            <div class="form-group">
                {{ Form::label('categories', ' Category Name', ['class' => 'name']) }}
                <select class="form-control" name="cat_id">
                    <option value="{{(!empty($data->cat_id))?$data->cat_id:old('cat_id')}}">{{(!empty($cat_name))?$cat_name->categories:"Please select category"}}</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->categories}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!--/column 6  -->
        <!-- column 6 -->
        <div class="col-sm-6">
            <!--  feature type -->
            <div class="form-group">
                {{ Form::label('service_type', 'Service type', ['class' => 'service_type']) }}
                {{ Form::text('service_type',(!empty($data->service_type))?$data->service_type:old('service_type'),['class'=>'form-control','id'=>'service_type','placeholder'=>'Enter Service Type', 'required' => 'required']) }}
            </div>
             
        </div>
        <!--/column 6  -->
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