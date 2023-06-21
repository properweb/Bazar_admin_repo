@include('include/header')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><span>Home</span>
            </li>
            <li class="breadcrumb-item active"><span>Create Role</span></li>
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
                    <label for="formGroupExampleInput" class="form-label">Role</label>
                    <input type="text" class="form-control" name="role" value="{{ old('role') ?? '' }}">
                    <input type="hidden" class="form-control" name="status" value="1">
                </div>

                <div class="mb-3 col-12">
                    <h4>Access Functions</h4>
                    <ul class="main-list">
                        @foreach ($categories as $category)
                            <li>
                                @if ($category->children->count() > 0)
                                    <label>{{ $category->pages }}</label>
                                    <ul>
                                        @foreach ($category->children as $child)
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="checkbox[]" value="{{ $child->id }}">
                                                    <label class="form-check-label">
                                                        {{ $child->pages }}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                        <li><button class="btn btn-primary" type="submit">Submit</button></li>
                    </ul>
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
