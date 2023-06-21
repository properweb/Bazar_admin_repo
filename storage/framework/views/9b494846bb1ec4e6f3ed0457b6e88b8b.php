<?php echo $__env->make('include/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><span>Home</span>
            </li>
            <li class="breadcrumb-item active"><span>Create User</span></li>
        </ol>
    </nav>
</div>
</header>

<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <form method="post" action="">
            <?php echo csrf_field(); ?>
            <div class="row">
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if(session()->has('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session()->get('success')); ?>

                    </div>
                <?php endif; ?>
                <div class="mb-3 col-4">
                    <label for="formGroupExampleInput" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="first_name" value="<?php echo e(old('first_name') ?? ''); ?>">
                </div>
                    <div class="mb-3 col-4">
                        <label for="formGroupExampleInput" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" value="<?php echo e(old('last_name') ?? ''); ?>">
                    </div>
                    <div class="mb-3 col-4">
                        <label for="formGroupExampleInput" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email"  >
                    </div>
                    <div class="mb-3 col-4">
                        <label for="formGroupExampleInput" class="form-label">Select Role</label>
                        <select name="role" class="form-control">
                            <option value="">Select</option>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($v['id']); ?>"><?php echo e($v['role']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3 col-4">
                        <label for="formGroupExampleInput" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" >
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
<script src="<?php echo e(asset('/public/vendors/@coreui/coreui/js/coreui.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('/public/vendors/simplebar/js/simplebar.min.js')); ?>"></script>
<!-- Plugins and scripts required by this view-->
<script src="<?php echo e(asset('/public/vendors/chart.js/js/chart.min.js')); ?>"></script>
<script src="<?php echo e(asset('/public/vendors/@coreui/chartjs/js/coreui-chartjs.js')); ?>"></script>
<script src="<?php echo e(asset('/public/vendors/@coreui/utils/js/coreui-utils.js')); ?>"></script>
<script src="<?php echo e(asset('/public/js/main.js')); ?>"></script>
<script>
</script>

</body>
</html>
<?php /**PATH /home/bazarcenter/public_html/staging.bazarcenter.ca/admin/Modules/Role/Resources/views/create-user.blade.php ENDPATH**/ ?>