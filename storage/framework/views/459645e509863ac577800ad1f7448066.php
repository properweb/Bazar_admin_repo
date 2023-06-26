<!DOCTYPE html>
<html>
<head>
    <title>User List - DataTables</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css">
</head>
<body>
<div class="container mt-5">
    <table class="table table-bordered data-table" id="users-table">
        <thead>
        <tr>

            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?php echo e(url('brand/')); ?>',
            columns: [
                { data: 'first_name', name: 'first_name' },
                { data: 'email', name: 'email' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
</body>
</html>
<?php /**PATH /home/bazarcenter/public_html/staging.bazarcenter.ca/admin/Modules/Brand/Resources/views/index.blade.php ENDPATH**/ ?>