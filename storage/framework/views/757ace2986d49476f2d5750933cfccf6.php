<?php echo $__env->make('include/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><span>Home</span>
            </li>
            <li class="breadcrumb-item active"><span>Create Admin User</span></li>
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
                    <input type="text" class="form-control" name="role">
                </div>
                    <div class="mb-3 col-4">
                        <label for="formGroupExampleInput" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="role">
                    </div>
                    <div class="mb-3 col-8">
                        <label for="formGroupExampleInput" class="form-label">Access Functions</label>
                       <ul class="main-list">
                           <li>
                               <label>Label one</label>
                               <ul class="sub-list">
                                   <li>
                                       <input type="checkbox" name="" value="">
                                       <span>Name 1</span>
                                   </li>
                                   <li>
                                       <input type="checkbox" name="" value="">
                                       <span>Name 2</span>
                                   </li>
                               </ul>
                           </li>
                       </ul>
                    </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <button class="btn btn-primary px-4" type="submit">Submit</button>
                    </div>

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
<?php /**PATH /home/bazarcenter/public_html/staging.bazarcenter.ca/admin/Modules/Role/Resources/views/createUser.blade.php ENDPATH**/ ?>