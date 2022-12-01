<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-edit')): ?>
    <?php $__env->startSection('content'); ?>
        <main class="login-form">
            <div class="cotainer">
                <div class="row justify-content-center">
                    <div class="form-group ">

                        <?php if(session('errors')): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo e(session('errors')); ?>

                                <span aria-hidden="true">&times;</span>

                            </div>
                    </div>
                    <?php echo e(session()->forget('errors')); ?>

                    <?php endif; ?>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">User Info</div>
                        <div class="card-body">

                            <form action="<?php echo e(route('users.update', $user)); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo method_field('PATCH'); ?>
                                <?php echo csrf_field(); ?>

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="name" value="<?php echo e($user->name); ?>" minlength="8"
                                            class="form-control" name="name" required autofocus>
                                        <?php if($errors->has('name')): ?>
                                            <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail
                                        Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email_address" value="<?php echo e($user->email); ?>"
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
                                        <img src="<?php echo e(asset('thumbnails/' . $user->image)); ?>" alt="profile"
                                            style=" padding: 10px; margin: 0px; ">

                                    </div>
                                </div>

                                <div class="form-group row">



                                    <label for="image" class="col-md-4 col-form-label text-md-right"> Update Profile
                                        Image</label>
                                    <div class="col-md-6">
                                        <input type="file" name="image">
                                    </div>
                                </div>






                                <div class="form-group  d-flex justify-content-center">
                                    <label style="padding-right: 10px" for=""> Select Role</label>
                                    <select required class="input_color" name="role">
                                        <option >Choose </option>
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option   value="<?php echo e($role); ?>" <?php echo e(($role) == $userRole[0] ? 'selected' : ''); ?>><?php echo e($role); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
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
<?php endif; ?>

<?php echo $__env->make('auth.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Muhammad Zaid Ali\Desktop\laravel3rdweek\laravel3rdweek-apiwithcommands\resources\views/user/edituser.blade.php ENDPATH**/ ?>