@include('include/header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Brands</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Brands</li>
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
                    <div class="card-header">
                        <input type="button" value="Create Brand" onClick="window.location.href='{{ url('brand/create') }}'"
                               class="btn btn-primary" style="float:right;"/>
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
                                    <th>Brand</th>
                                    <th>Live Status</th>
                                    <th>Phone Number</th>
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
                {
                    data: 'go_live', render: function (data, type, row) {
                        var id = row.id;
                        if(row.go_live==0)
                        {
                            return 'Not Live';
                        }
                        if(row.go_live==1)
                        {
                            return '<a href="{{ url('brand/live')}}/'+id+'">Request for Live</a>';
                        }
                        if(row.go_live==2)
                        {
                            return 'Live';
                        }
                    }
                },
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
</script>
</body>
</html>
