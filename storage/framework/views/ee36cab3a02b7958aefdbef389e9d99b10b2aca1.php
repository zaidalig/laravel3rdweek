<?php $__env->startSection('content'); ?>
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Update Password</div>
                        <div class="card-body">

                            <form action="<?php echo e(route('check_and_update_password')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="form-group row">
                                    <label for="old_password" class="col-md-4 col-form-label text-md-right"> Old
                                        Password</label>
                                    <div class="col-md-6">
                                        <input minlength="8" type="password" id="old_password" class="form-control"
                                            name="old_password" required>
                                        <?php if($errors->has('old_password')): ?>
                                            <span class="text-danger"><?php echo e($errors->first('old_password')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="new_password" class="col-md-4 col-form-label text-md-right">New
                                        Password</label>
                                    <div class="col-md-6">
                                        <input minlength="8" type="password" id="new_password" class="form-control"
                                            name="new_password" required>
                                        <?php if($errors->has('new_password')): ?>
                                            <span class="text-danger"><?php echo e($errors->first('new_password')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Muhammad Zaid Ali\Desktop\laravel3rdweek\laravel3rdweek-apiwithcommands\resources\views/auth/change_password.blade.php ENDPATH**/ ?>