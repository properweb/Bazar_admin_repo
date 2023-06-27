@include('include/header')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><span>Home</span>
            </li>
            <li class="breadcrumb-item active"><span>Trash Users</span></li>
        </ol>
    </nav>
</div>
</header>

<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="white-sec">

            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <table class="table table-hover" id="myTable">
                <thead>

                <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Restore</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $v)
                    <tr>
                        <td>{{$v['first_name']}}</td>
                        <td>{{$v['last_name']}}</td>
                        <td>{{$v['email']}}</td>
                        <td>{{$v['role']}}</td>
                        <td><a href="{{ url('role/restore/')}}/{{$v['id']}}" onclick="event.preventDefault(); confirmRestore('{{ $v['id'] }}');">Restore</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
<!-- CoreUI and necessary plugins-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="{{asset('/public/vendors/@coreui/coreui/js/coreui.bundle.min.js')}}"></script>
<script src="{{asset('/public/vendors/simplebar/js/simplebar.min.js')}}"></script>
<!-- Plugins and scripts required by this view-->
<script src="{{asset('/public/vendors/chart.js/js/chart.min.js')}}"></script>
<script src="{{asset('/public/vendors/@coreui/chartjs/js/coreui-chartjs.js')}}"></script>
<script src="{{asset('/public/vendors/@coreui/utils/js/coreui-utils.js')}}"></script>
<script src="{{asset('/public/js/main.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });

    function confirmRestore(itemId) {
        if (confirm("Are you sure you want to restore this?")) {
            window.location.href = "{{ url('role/restore/')}}/" + itemId; // Replace with your delete route URL
        }
    }
</script>
</body>
</html>
