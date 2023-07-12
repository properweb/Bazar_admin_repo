@include('include/header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Retailers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Retailers</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="col-md-12">
                        <ul class="nav row search-form-list">
                            <li class="col-md-2"><label>Filter Search By</label></li>
                            <li class="col-md-2">
                                <div class="form-group">
                                    <div class="select2-purple">
                                        <select class="form-control select2" style="width: 100%;" name="headquatered" id="countrySelect">
                                            <option value="">Select Country</option>
                                            @if(!empty($countries))
                                                @foreach($countries as $country)
                                                    <option value="{{$country['id']}}">{{$country['country_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </li>
                            <li class="col-md-2">
                                <div class="form-group">
                                    <div class="select2-purple">
                                        <select class="form-control select2" style="width: 100%;" name="state" id="stateSelect">
                                            <option value="">Select State</option>
                                        </select>
                                    </div>
                                </div>
                            </li>
                            <li class="col-md-2">
                                <div class="form-group">
                                    <div class="select2-purple">
                                        <select class="form-control select2" style="width: 100%;" name="city" id="citySelect">
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div>
                            </li>
                            <li class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control select2" style="width: 100%;" name="prime_cat" id="prime_cat">
                                        <option value="">Select Category</option>
                                        @if(!empty($categories))
                                            @foreach($categories as $category)
                                                <option value="{{$category['cat_id']}}">{{$category['category']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <table class="table table-bordered data-table" id="users-table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Store Name</th>
                                    <th>Store Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<aside class="control-sidebar control-sidebar-dark">

</aside>
<!-- /.control-sidebar -->
</div>
<script src="{{asset('/public/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('/public/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/public/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('/public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/public/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/public/dist/js/demo.js')}}"></script>
<!-- page script -->
<script type="text/javascript">

    $(document).ready(function(){

        // DataTable
        var empTable = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:"{{ url('retailer/retailer-data')}}",
                data: function(data){
                    data.countrySelect = $('#countrySelect').val();
                    data.stateSelect = $('#stateSelect').val();
                    data.citySelect = $('#citySelect').val();
                    data.catID = $('#prime_cat').val();
                }
            },
            columns: [
                {
                    data: 'first_name', render: function (data, type, row) {
                        return row.first_name + ' ' + row.last_name;
                    }
                },
                { data: 'email', name: 'email' },
                { data: 'store_name', name: 'store_name' },
                { data: 'store_type', name: 'store_type' },
                {
                    data: 'active', render: function (data, type, row) {
                        var id = row.id;
                        if(row.active==0)
                        {
                            return '<a href="javascript:void(0)" onclick="changeStatus(1,'+id+')"><button type="button" class="btn btn-block btn-danger">Inactive</button></a>';
                        }
                        if(row.active==1)
                        {
                            return '<a href="javascript:void(0)" onclick="changeStatus(0,'+id+')"><button type="button" class="btn btn-block btn-success">Active</button></a>';
                        }
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $('#countrySelect,#stateSelect,#citySelect,#prime_cat').change(function(){
            empTable.draw();
        });

    });

    {{--$(document).ready(function() {--}}
    {{--    $('#users-table').DataTable({--}}
    {{--        processing: true,--}}
    {{--        serverSide: true,--}}
    {{--        ajax: '{{ url('retailer/retailer-data')}}',--}}
    {{--        columns: [--}}
    {{--            {--}}
    {{--                data: 'first_name', render: function (data, type, row) {--}}
    {{--                    return row.first_name + ' ' + row.last_name;--}}
    {{--                }--}}
    {{--            },--}}
    {{--            { data: 'email', name: 'email' },--}}
    {{--            { data: 'store_name', name: 'store_name' },--}}
    {{--            { data: 'store_type', name: 'store_type' },--}}
    {{--            {--}}
    {{--                data: 'active', render: function (data, type, row) {--}}
    {{--                    var id = row.id;--}}
    {{--                    if(row.active==0)--}}
    {{--                    {--}}
    {{--                        return '<a href="javascript:void(0)" onclick="changeStatus(1,'+id+')"><button type="button" class="btn btn-block btn-danger">Inactive</button></a>';--}}
    {{--                    }--}}
    {{--                    if(row.active==1)--}}
    {{--                    {--}}
    {{--                        return '<a href="javascript:void(0)" onclick="changeStatus(0,'+id+')"><button type="button" class="btn btn-block btn-success">Active</button></a>';--}}
    {{--                    }--}}
    {{--                }--}}
    {{--            },--}}
    {{--            { data: 'action', name: 'action', orderable: false, searchable: false }--}}
    {{--        ]--}}
    {{--    });--}}
    {{--});--}}

    function changeStatus(status,id)
    {
        if(status==1)
        {
            var msg = 'Are you sure you want to change status of Active?';
        }
        else
        {
            var msg = 'Are you sure you want to change status of Inactive?';
        }
        if (confirm(msg)) {
            window.location.href = "{{ url('retailer/change-status/')}}/" +id+"/"+status;
        }
    }
    function confirmDelete(itemId) {

        if (confirm("Are you sure you want to delete?")) {
            window.location.href = "{{ url('retailer/delete/')}}/" + itemId; // Replace with your delete route URL
        }
    }
    document.getElementById('countrySelect').addEventListener('change', function () {
        var countryId = this.value;
        var url = '{{ url('brand/states')}}/'+countryId;
        var stateSelect = document.getElementById('stateSelect');

        // Disable the state dropdown until the states are fetched
        stateSelect.disabled = true;
        stateSelect.innerHTML = '<option value="">Loading...</option>';

        fetch(url)
            .then(response => response.json())
            .then(states => {
                stateSelect.innerHTML = '<option value="">Select State</option>';
                states.forEach(state => {
                    var option = document.createElement('option');
                    option.value = state.id;
                    option.textContent = state.name;
                    stateSelect.appendChild(option);
                });

                // Enable the state dropdown once the states are fetched
                stateSelect.disabled = false;
            })
            .catch(error => console.log(error));
    });

    document.getElementById('stateSelect').addEventListener('change', function () {
        var stateId = this.value;
        var url = '{{ url('brand/cities')}}/'+stateId;
        var citySelect = document.getElementById('citySelect');

        // Disable the state dropdown until the states are fetched
        citySelect.disabled = true;
        citySelect.innerHTML = '<option value="">Loading...</option>';

        fetch(url)
            .then(response => response.json())
            .then(cities => {
                citySelect.innerHTML = '<option value="">Select City</option>';
                cities.forEach(city => {
                    var option = document.createElement('option');
                    option.value = city.id;
                    option.textContent = city.name;
                    citySelect.appendChild(option);
                });

                // Enable the state dropdown once the states are fetched
                citySelect.disabled = false;
            })
            .catch(error => console.log(error));
    });
</script>
</body>
</html>
