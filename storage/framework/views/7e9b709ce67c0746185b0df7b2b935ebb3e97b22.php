<?php $__env->startSection('content'); ?>
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Profile</div>
                        <div class="card-body">

                            <form action="<?php echo e(route('edit_profile')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="name" value="<?php echo e(auth()->user()->name); ?>"
                                            minlength="8" class="form-control" name="name" required autofocus>
                                        <?php if($errors->has('name')): ?>
                                            <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail
                                        Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email_address" value="<?php echo e(auth()->user()->email); ?>"
                                            class="form-control" name="email" required autofocus>
                                        <?php if($errors->has('email')): ?>
                                            <span class="text-danger"><?php echo e($errors->first('email')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>


                                <div class="form-group row">



                                    <label class="col-md-4 col-form-label text-md-right">Profile
                                        Image</label>
                                    <div class="col-md-6">
                                        <img  src="<?php echo e(asset('thumbnails/' . Auth::user()->image)); ?>"
                                            alt="profile" style=" padding: 10px; margin: 0px; ">

                                    </div>
                                </div>

                                <div class="form-group row">



                                    <label for="image" class="col-md-4 col-form-label text-md-right">Profile
                                        Image</label>
                                    <div class="col-md-6">
                                        <input type="file" name="image">
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

<?php echo $__env->make('auth.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Muhammad Zaid Ali\Desktop\laravel3rdweek\laravel3rdweek-apiwithcommands\resources\views/auth/profile.blade.php ENDPATH**/ ?>