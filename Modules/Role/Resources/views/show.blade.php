@include('include/header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><span>Home</span>
            </li>
            <li class="breadcrumb-item active"><span>Roles</span></li>
        </ol>
    </nav>
</div>
</header>

<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="white-sec">

            <button id="deleteBtn" class="btn btn-primary" style="float:right">Delete Selected</button>
            <input type="button" value="Add New" onClick="window.location.href='{{ url('role/create') }}'" class="btn btn-primary" style="float:right"/>
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <table class="table table-hover" id="myTable">
                <thead>

                    <tr>
                        <th scope="col"><input type="checkbox" id="masterCheckbox"></th>
                        <th scope="col">Role</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $v)
                    <tr>
                        <td><input type="checkbox" class="checkbox" name="record[]" id="checkbox" value="{{$v['id']}}"></td>
                        <td>{{$v['role']}}</td>
                        <td>{{$v['status']}}</td>
                        <td><a href="{{ url('role/details/')}}/{{$v['id']}}"><span class="fas fa-pen"></span></a> <a href="{{ url('role/delete/')}}/{{$v['id']}}" onclick="event.preventDefault(); confirmDelete('{{ $v['id'] }}');"><span class="fas fa-trash"></span></a> </td>
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

            // Delete button click event
            $('#deleteBtn').on('click', function() {
                var ids = [];

                // Get the selected IDs
                $('input[name="record[]"]:checked').each(function() {
                    ids.push($(this).val());
                });

                // If no checkboxes are selected
                if (ids.length === 0) {
                    alert('Please select at least one record.');
                    return;
                }

                // Show confirm dialog
                if (confirm('Are you sure you want to delete the selected records?')) {
                    // Send AJAX request
                    $.ajax({
                        url: '{{ url('role/delete-multiple')}}',
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            ids: ids
                        },
                        success: function(response) {
                            if (response.success) {
                                // Reload the page or update the table
                                location.reload();
                            } else {
                                alert('An error occurred while deleting records.');
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred while deleting records.');
                        }
                    });
                }
            });
    });
    function confirmDelete(itemId) {
        if (confirm("Are you sure you want to delete this?")) {
            window.location.href = "{{ url('role/delete/')}}/" + itemId; // Replace with your delete route URL
        }
    }


    // Get the master checkbox element
    const masterCheckbox = document.getElementById('masterCheckbox');

    // Get all checkbox elements
    const checkboxes = document.querySelectorAll('.checkbox');

    // Add an event listener to each checkbox
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Check if all checkboxes are checked
            const allChecked = Array.from(checkboxes).every(function(cb) {
                return cb.checked;
            });

            // Update the state of the master checkbox
            masterCheckbox.checked = allChecked;
        });
    });

    // Add an event listener to the master checkbox
    masterCheckbox.addEventListener('change', function() {
        const isChecked = masterCheckbox.checked;

        // Iterate through each checkbox and set checked property
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
    });



</script>

</body>
</html>
