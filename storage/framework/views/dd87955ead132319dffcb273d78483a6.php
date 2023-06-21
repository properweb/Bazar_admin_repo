<?php echo $__env->make('include/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><span>Home</span>
            </li>
            <li class="breadcrumb-item active"><span>Admin Users</span></li>
        </ol>
    </nav>
</div>
</header>

<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="white-sec">
            <input type="button" value="Add New" onClick="window.location.href='<?php echo e(url('role/create-user')); ?>'" class="btn btn-primary" style="float:right"/>
            <?php if(session()->has('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session()->get('success')); ?>

                </div>
            <?php endif; ?>
            <table class="table table-hover" id="myTable">
                <thead>

                <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($v['first_name']); ?></td>
                        <td><?php echo e($v['last_name']); ?></td>
                        <td><?php echo e($v['email']); ?></td>
                        <td><?php echo e($v['role']); ?></td>
                        <td><a href="<?php echo e(url('role/user-details/')); ?>/<?php echo e($v['id']); ?>"><span class="fas fa-pen"></span></a> <a href="<?php echo e(url('role/user-delete/')); ?>/<?php echo e($v['id']); ?>" onclick="event.preventDefault(); confirmDelete('<?php echo e($v['id']); ?>');"><span class="fas fa-trash"></span></a> </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
<!-- CoreUI and necessary plugins-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="<?php echo e(asset('/public/vendors/@coreui/coreui/js/coreui.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('/public/vendors/simplebar/js/simplebar.min.js')); ?>"></script>
<!-- Plugins and scripts required by this view-->
<script src="<?php echo e(asset('/public/vendors/chart.js/js/chart.min.js')); ?>"></script>
<script src="<?php echo e(asset('/public/vendors/@coreui/chartjs/js/coreui-chartjs.js')); ?>"></script>
<script src="<?php echo e(asset('/public/vendors/@coreui/utils/js/coreui-utils.js')); ?>"></script>
<script src="<?php echo e(asset('/public/js/main.js')); ?>"></script>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });
    function confirmDelete(itemId) {
        if (confirm("Are you sure you want to delete this?")) {
            window.location.href = "<?php echo e(url('role/user-delete/')); ?>/" + itemId; // Replace with your delete route URL
        }
    }
</script>

</body>
</html>
<?php /**PATH /home/bazarcenter/public_html/staging.bazarcenter.ca/admin/Modules/Role/Resources/views/show-admin.blade.php ENDPATH**/ ?>