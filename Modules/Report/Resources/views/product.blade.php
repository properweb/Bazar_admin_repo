@include('include/header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Stock Reports</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Product Stock Reports</li>
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
                        <ul class="nav row search-form-list" style="float: right">


                            <li class="col-md-12">
                                <div class="form-group">
                                    <div class="select2-purple">
                                        <button id="export-btn" class="btn btn-primary">Export</button>
                                    </div>
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
                            <table class="table table-bordered data-table" id="products-table">
                                <thead>
                                <tr>
                                    <th style="width: 100px;">Image</th>
                                    <th style="width: 100px;">Name</th>
                                    <th style="width: 70px;">Sku</th>
                                    <th style="width: 30px;">Options</th>
                                    <th style="width: 30px;">Stock</th>

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

    $(document).ready(function() {
        $('#products-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:"{{ url('report/product-data')}}",
                data: function(data){

                }
            },
            columns: [
                {
                    data: 'image',
                    title: 'Image',
                    render: function (data, type, row) {
                        if(row.featured_image=='')
                        {
                            row.featured_image = "{{asset('/public/dist/img/productnoimage.jpg')}}";
                        }
                        return '<img src="'+row.featured_image+'" alt="Image" width="100" >';
                    }, orderable: false, searchable: false
                },
                {data: 'name', name: 'name'},
                {data: 'sku', name: 'sku'},
                {data: 'variations_count', name: 'variations_count', orderable: false, searchable: false},
                {data: 'stock', name: 'stock'},
            ]
        });

        $('#export-btn').click(function () {

            $.ajax({
                url: '{{ url('report/export-product')}}',
                type: 'GET',
                data: {
                },
                success: function (response) {
                    window.location.href = response;
                }
            });
        });

    });

</script>
</body>
</html>
