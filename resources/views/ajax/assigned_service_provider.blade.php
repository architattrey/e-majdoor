
<div class="modal-body">
    <!-- row strat -->
    <div class="row">
        <div class="col-sm-12">
            <div class="listing" style="background-color: white;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>Address</th>
                            <th>District</th>
                            <th>state</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($majdoors) && isset($majdoors ))
                            @foreach($majdoors  as $key => $majdoor)
                            @php 
                                $key++;
                            @endphp
                                <tr>
                                    <td>{{$key}}</td>
                                    <td>{{isset($majdoor[0]->cat) && !empty($majdoor[0]->cat) ?ucfirst($majdoor[0]->cat):"NA" }}</td>
                                    <td>{{isset($majdoor[0]->sub_cat) && !empty($majdoor[0]->sub_cat) ? ucfirst($majdoor[0]->sub_cat): "NA" }}</td>
                                    <td>{{isset($majdoor[0]->name) && !empty($majdoor[0]->name) ? ucfirst($majdoor[0]->name): "NA" }}</td>
                                    <td>{{isset($majdoor[0]->phone) && !empty($majdoor[0]->phone) ? ucfirst($majdoor[0]->phone): "NA" }}</td>
                                    <td><textarea class="form-control" row="3" disabled>{{isset($majdoor[0]->address) && !empty($majdoor[0]->address) ? $majdoor[0]->address: "NA" }}</textarea></td>
                                    <td>{{isset($majdoor[0]->district) && !empty($majdoor[0]->district) ? ucfirst($majdoor[0]->district): "NA" }}</td>
                                    <td>{{isset($majdoor[0]->state) && !empty($majdoor[0]->state) ? ucfirst($majdoor[0]->state) : "NA" }}</td>
                                </tr>
                            @endforeach 
                        @else
                        <tr><td><p>Majdoors not found</p></td></tr>  
                        @endif  
                    </tbody> 
                </table>    
            </div>
        </div>   
    </div>
    <!--/ row end -->
</div>
 
 