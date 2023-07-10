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
                            @if($detail['profile_photo']!='')
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="https://staging.bazarcenter.ca/public/{{$detail['profile_photo']}}"
                                         alt="">
                                </div>
                            @else
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{asset('/public/icons/noimage.png')}}"
                                         alt="User profile picture">
                                </div>
                            @endif



                            <h3 class="profile-username text-center">{{$detail['name']}}</h3>

                            <p class="text-muted text-center">{{$detail['brand_name']}}</p>

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
                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Brand Information</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Photo</a></li>
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
                                        <p><b>About Me: </b>{{$detail['about_us']}}</p>


                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="timeline">
                                    <!-- The timeline -->
                                    <div class="post">
                                        <p><b>Shop Name: </b>{{$detail['name']}}</p>
                                        <p><b>Website: </b>{{$detail['email']}}</p>
                                        <p><b>Year Of Established: </b>{{$detail['established_year']}}</p>
                                        <p><b>Shop Lead Time: </b>{{$detail['shop_lead_time']}}</p>
                                        <p><b>Pause Mode (Previously Vacation Mode): </b>{{$detail['pause_from_date']}} - {{$detail['pause_to_date']}}</p>
                                        <p><b>First Order Min: </b>{{$detail['first_order_min']}}</p>
                                        <p><b>Reorder Min: </b>{{$detail['re_order_min']}}</p>
                                        <p><b>Direct Link: </b>{{$detail['bazaar_direct_link']}}</p>
                                        <p><b>HeadQuarter: </b>{{$detail['head-quarter']}}</p>
                                        <p><b>Product Made: </b>{{$detail['product-made']}}</p>
                                        <p><b>Product Shipped: </b>{{$detail['product-shipped']}}</p>
                                        <p><b>Avg Lead Time: </b>{{$detail['avg_lead_time']}}</p>
                                        <p><b>Brand Story: </b>{{$detail['shared_brd_story']}}</p>
                                        @if($detail['proof_document']!='')
                                            <p><b>Document: </b><a target="_blank" href="https://staging.bazarcenter.ca/public/{{$detail['proof_document']}}">View</a></p>
                                        @endif

                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="settings">
                                    <div class="card-body">
                                        <div class="row">
                                            @if($detail['profile_photo']!='')
                                                <div class="col-sm-2">
                                                    <a href="https://staging.bazarcenter.ca/public/{{$detail['profile_photo']}}" data-toggle="lightbox" data-title="Profile Photo" data-gallery="gallery">
                                                        <img src="https://staging.bazarcenter.ca/public/{{$detail['profile_photo']}}" class="img-fluid mb-2" alt="Profile Photo"/>
                                                    </a>
                                                </div>
                                            @endif
                                            @if($detail['cover_image']!='')
                                                <div class="col-sm-2">
                                                    <a href="https://staging.bazarcenter.ca/public/{{$detail['cover_image']}}" data-toggle="lightbox" data-title="Cover Photo" data-gallery="gallery">
                                                        <img src="https://staging.bazarcenter.ca/public/{{$detail['cover_image']}}" class="img-fluid mb-2" alt="Cover Photo"/>
                                                    </a>
                                                </div>
                                            @endif
                                            @if($detail['logo_image']!='')
                                                <div class="col-sm-2">
                                                    <a href="https://staging.bazarcenter.ca/public/{{$detail['logo_image']}}" data-toggle="lightbox" data-title="Logo" data-gallery="gallery">
                                                        <img src="https://staging.bazarcenter.ca/public/{{$detail['logo_image']}}" class="img-fluid mb-2" alt="Logo"/>
                                                    </a>
                                                </div>
                                            @endif
                                            @if($detail['featured_image']!='')
                                                <div class="col-sm-2">
                                                    <a href="https://staging.bazarcenter.ca/public/{{$detail['featured_image']}}" data-toggle="lightbox" data-title="Feature Image" data-gallery="gallery">
                                                        <img src="https://staging.bazarcenter.ca/public/{{$detail['featured_image']}}" class="img-fluid mb-2" alt="Feature Image"/>
                                                    </a>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
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
