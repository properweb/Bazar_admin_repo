@include('include/header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Retailer</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Create Retailer</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <form role="form" action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger">

                        @foreach ($errors->all() as $error)
                            {{ $error }}<br/>
                        @endforeach

                    </div>
                @endif
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Information</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="first_name" value="{{ old('first_name') ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') ?? '' }}">
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="text" class="form-control" name="email" value="{{ old('email') ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address1" value="{{ old('address1') ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control" name="country" id="countrySelect">
                                        <option value="">Select</option>
                                        @if(!empty($countries))
                                            @foreach($countries as $country)
                                                <option value="{{$country['id']}}" >{{$country['country_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                        <label>State</label>
                                        <div class="select2-purple">
                                            <select class="form-control select2" style="width: 100%;" name="state" id="stateSelect">
                                                <option value="">Select</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                        <label>City</label>
                                        <div class="select2-purple">
                                            <select class="form-control select2" style="width: 100%;" name="city" id="citySelect">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Post Code</label>
                                    <input type="text" class="form-control" name="post_code" value="{{ old('post_code') ?? '' }}">
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Business Legal Name</label>
                                    <input type="text" class="form-control" name="store_name" value="{{ old('store_name') ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Store Type</label>
                                    <select  name="store_type" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Brick and mortar">Brick and mortar</option>
                                        <option value="Pop-up shop">Pop-up shop</option>
                                        <option value="Online only">Online only</option>
                                        <option value="Other">Other</option>
                                        <option value="I am just shopping for myself">I am just shopping for myself</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Website</label>
                                    <input type="text" class="form-control" name="website_url" value="{{ old('website_url') ?? '' }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Phone Code</label>
                                    <select class="form-control select2"   name="country_code" >
                                        <option value="">Select</option>
                                        @if(!empty($countries))
                                            @foreach($countries as $country)
                                                <option value="{{$country['phone_code']}}" >+{{$country['phone_code']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number') ?? '' }}">
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Language</label>
                                    <select class="form-control select2" style="width: 100%;" name="language">
                                        <option value="">Select</option>
                                        <option value="English">English</option>
                                        <option value="Français">Français</option>
                                        <option value="Deutsch">Deutsch</option>
                                        <option value="Italiano">Italiano</option>
                                        <option value="Español">Español</option>
                                        <option value="Svenska">Svenska</option>
                                        <option value="Dansk">Dansk</option>
                                        <option value="Nederlands">Nederlands</option>
                                        <option value="Português">Português</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Upload Document</label>
                                    <input type="file" name="proof_document" class="form-control">
                                </div>

                            </div>

                        </div>
                        <div class="card-footer" style="float: right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </div>


            </div>
        </form>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">

    </div>

</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
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
<script>
    $(document).ready(function () {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url('brand/brand-data')}}',
            columns: [
                {
                    data: 'first_name', render: function (data, type, row) {
                        return row.first_name + ' ' + row.last_name;
                    }
                },
                {data: 'email', name: 'email'},
                {data: 'brand_name', name: 'brand_name'},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
    function confirmDelete(itemId) {

        if (confirm("Are you sure you want to delete this?")) {
            window.location.href = "{{ url('brand/delete/')}}/" + itemId; // Replace with your delete route URL
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
                stateSelect.innerHTML = '<option value="">Select</option>';
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
                citySelect.innerHTML = '<option value="">Select</option>';
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
