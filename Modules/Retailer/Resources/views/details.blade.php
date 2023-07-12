@include('include/header')
<link rel="stylesheet" href="{{asset('/public/plugins/ekko-lightbox/ekko-lightbox.css')}}">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Brand Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">

                            <h3 class="profile-username text-center">{{$detail['name']}}</h3>

                            <p class="text-muted text-center">{{$detail['store_name']}}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{$detail['email']}}</a>
                                </li>

                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Profile</a></li>
                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Shipping Address</a></li>

                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <!-- Post -->
                                    <div class="post">
                                        <p><b>Name: </b>{{$detail['name']}}</p>
                                        <p><b>Email: </b>{{$detail['email']}}</p>
                                        <p><b>Phone Number: </b>{{$detail['phone_number']}}</p>
                                        <p><b>Language: </b>{{$detail['phone_number']}}</p>
                                        <p><b>Store Name: </b>{{$detail['store_name']}}</p>
                                        <p><b>Store Type: </b>{{$detail['store_type']}}</p>
                                        <p><b>Website: </b>{{$detail['website_url']}}</p>
                                        <p><b>Address: </b>{{$detail['address1']}}, {{$detail['town']}}, {{$detail['state']}},{{$detail['country']}}, {{$detail['post_code']}}</p>
                                        @if($detail['proof_document']!='')
                                            <p><b>Proof Document: </b><a target="_blank" href="https://staging.bazarcenter.ca/public/{{$detail['proof_document']}}">View</a></p>
                                        @endif

                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="timeline">
                                    <!-- The timeline -->
                                    @if(isset($shippings) && !empty($shippings))
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="card-title"><b>Shipping</b></h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Address</th>
                                                                <th>Phone Number</th>

                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach ($shippings as $shipping)
                                                                <tr>
                                                                    <td>{{$shipping->ship_name}}</td>
                                                                    <td>{{$shipping->suite}}, {{$shipping->city_name}} , {{$shipping->state_name}}, {{$shipping->country_name}}, {{$shipping->zip}}</td>
                                                                    <td>{{$shipping->phone}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>

                                            </div>


                                        </div>
                                    @endif
                                </div>

                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
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
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('/public/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/public/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/public/dist/js/demo.js')}}"></script>
<script src="{{asset('/public/plugins/ekko-lightbox/ekko-lightbox.min.js')}}"></script>
<script src=".{{asset('/public/plugins/filterizr/jquery.filterizr.min.js')}}"></script>
<script>
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

        $('.filter-container').filterizr({gutterPixels: 3});
        $('.btn[data-filter]').on('click', function() {
            $('.btn[data-filter]').removeClass('active');
            $(this).addClass('active');
        });
    })
</script>
</body>
</html>
