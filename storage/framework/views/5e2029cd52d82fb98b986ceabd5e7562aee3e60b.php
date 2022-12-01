<?php $__env->startSection('content'); ?>
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Login</div>
                        <div class="card-body">
                            <div class="card-body">
                                <?php if(session('status')): ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?php echo e(session('status')); ?>

                                        <?php echo e(session()->forget('status')); ?>


                                    </div>
                                <?php endif; ?>


                            </div>

                            <form action="<?php echo e(route('login.post')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="form-group row">
                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail
                                        Address</label>
                                    <div class="col-md-6">
                                        <input type="email" id="email_address" class="form-control" name="email"
                                        value="<?php echo e(session('email')); ?>"   required autofocus>
                                        <?php if($errors->has('email')): ?>
                                            <span class=" text text-danger"><?php echo e($errors->first('email')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                        <input type="password" value="<?php echo e(session('password')); ?>" id="password" class="form-control" name="password" required>
                                        <?php if($errors->has('password')): ?>
                                            <span class="text-danger"><?php echo e($errors->first('password')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group row">



                                </div>

                                <div class="col-md-6 offset-md-4 column">

                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>


                                            <label style="padding-left: 30px">
                                                <a href="<?php echo e(route('forget.password.get')); ?>">Forgot Password ?</a>
                                            </label>




                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Muhammad Zaid Ali\Desktop\laravel3rdweek\laravel3rdweek-apiwithcommands\resources\views/auth/login.blade.php ENDPATH**/ ?>