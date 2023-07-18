@include('include/header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sales Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Sales Report</li>
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
                            <li class="col-md-2"><label>Filter By Date</label></li>
                            <li class="col-md-2">
                                <div class="form-group">
                                    <div class="select2-purple">
                                        <input type="text" placeholder="From Date" id="from-date-filter" class="form-control datepicker">
                                    </div>
                                </div>
                            </li>


                            <li class="col-md-2">
                                <div class="form-group">
                                    <div class="select2-purple">
                                        <input type="text" placeholder="To Date" id="to-date-filter" class="form-control datepicker">
                                    </div>
                                </div>
                            </li>
                            <li class="col-md-2">
                                <div class="form-group">
                                    <div class="select2-purple">
                                        <input type="text" style="width: 244px" id="customFilterInput" class="form-control" placeholder="Search By Brand and press enter">
                                    </div>
                                </div>
                            </li>
                            <li class="col-md-2">
                                <div class="form-group">
                                    <div class="select2-purple">
                                        <button id="export-btn" class="btn btn-primary">Export Data</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
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
                                    <th>Total Order</th>
                                    <th>Total Amount</th>
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
                <div id="chart"></div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
<!-- page script -->
<script>
    function loadSalesChart() {
        document.getElementById('chart').innerHTML= '';
        var fromDate = document.getElementById('from-date-filter').value;
        var toDate = document.getElementById('to-date-filter').value;
        var custom_filter = document.getElementById('customFilterInput').value;
        $.ajax({
            url: '{{ url('report/sale-chart')}}',
            data: {
                from_date: fromDate,
                to_date: toDate,
                custom_filter: custom_filter
            },
            success: function(response) {
                var options = {
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    series: response.series,
                    xaxis: {
                        categories: response.labels
                    }
                };

                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            }
        });
    }
    $(document).ready(function () {

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        document.getElementById('chart').innerHTML= '';
        var empTable = $('#users-table').DataTable({

            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ url('report/sale-data')}}",
                data: function (d) {
                    d.from_date = $('#from-date-filter').val();
                    d.to_date = $('#to-date-filter').val();
                    d.custom_filter = $('#customFilterInput').val();
                }
            },
            columns: [

                {
                    data: 'first_name', render: function (data, type, row) {
                        return row.first_name + ' ' + row.last_name;
                    }
                },
                {data: 'email', name: 'email'},
                {data: 'brand_name', name: 'brand_name'},
                {data: 'orders_count', name: 'orders_count', orderable: false, searchable: false},
                {data: 'orders_sum_total_amount', name: 'orders_sum_total_amount'},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        $('#from-date-filter,#to-date-filter').change(function(){
            empTable.draw();
            document.getElementById('chart').innerHTML= '';
            loadSalesChart();
        });
        $('#customFilterInput').keydown(function(event) {
            if (event.keyCode === 13) {
                document.getElementById('chart').innerHTML= '';
                loadSalesChart();
                empTable.draw();

            }

        });
        loadSalesChart();

        $('#export-btn').click(function () {
            var from_date = $('#from-date-filter').val();
            var to_date = $('#to-date-filter').val();
            var custom_filter = $('#customFilterInput').val();
            $.ajax({
                url: '{{ url('report/export-brand')}}',
                type: 'GET',
                data: {
                    from_date: from_date,
                    to_date: to_date,
                    custom_filter: custom_filter,
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
