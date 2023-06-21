@include('include/header')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><span>Home</span>
            </li>
            <li class="breadcrumb-item active"><span>Update User</span></li>
        </ol>
    </nav>
</div>
</header>

<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <form method="post" action="">
            @csrf
            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="mb-3 col-4">
                    <label for="formGroupExampleInput" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="first_name" value="{{ $data->first_name ?? '' }}">
                </div>
                <div class="mb-3 col-4">
                    <label for="formGroupExampleInput" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="last_name" value="{{ $data->last_name ?? '' }}">
                </div>
                <div class="mb-3 col-4">
                    <label for="formGroupExampleInput" class="form-label">Email</label>
                    <input type="email" class="form-control"  name="email"  value="{{ $data->email ?? '' }}">
                </div>

                    <div class="mb-3 col-4">
                        <label for="formGroupExampleInput" class="form-label">New Password (<i>Empty If don't want to update</i>)</label>
                        <input type="password" class="form-control"  name="new_password" >
                    </div>
                    <div class="mb-3 col-4">
                        <label for="formGroupExampleInput" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control"  name="new_password_confirmation" >
                    </div>
                <div class="mb-3 col-4">
                    <label for="formGroupExampleInput" class="form-label">Select Role</label>
                    <select name="role" class="form-control">
                        <option value="">Select</option>
                        @foreach ($role as $v)
                            <option value="{{$v['id']}}" @if ($data->role==$v['id']) selected @endif>{{$v['role']}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-8">
                    <ul class="main-list"><li><button class="btn btn-primary" type="submit">Submit</button></li></ul>

                </div>

            </div>
        </form>
    </div>
</div>

</div>
<!-- CoreUI and necessary plugins-->
<script src="{{asset('/public/vendors/@coreui/coreui/js/coreui.bundle.min.js')}}"></script>
<script src="{{asset('/public/vendors/simplebar/js/simplebar.min.js')}}"></script>
<!-- Plugins and scripts required by this view-->
<script src="{{asset('/public/vendors/chart.js/js/chart.min.js')}}"></script>
<script src="{{asset('/public/vendors/@coreui/chartjs/js/coreui-chartjs.js')}}"></script>
<script src="{{asset('/public/vendors/@coreui/utils/js/coreui-utils.js')}}"></script>
<script src="{{asset('/public/js/main.js')}}"></script>
<script>
</script>

</body>
</html>
