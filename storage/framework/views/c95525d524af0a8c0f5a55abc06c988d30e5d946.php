<?php $__env->startSection('content'); ?>
    <main class="upload-images">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-search')): ?>
                        <div style="padding: 20px">
                            <form action="<?php echo e(url('users.search')); ?>" method="get" role="search">
                                <?php echo e(csrf_field()); ?>

                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" placeholder="Search User"> <span
                                        class="input-group-btn">
                                        <button
                                            style="background-color: red;
                                    margin-left:20px;
                                    "
                                            type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"> Search User</span>
                                        </button>
                                    </span>
                                </div>
                            </form>

                        </div>
                    <?php endif; ?>

                    <div class="card-header d-flex justify-content-between">
                        <h4>All Users</h4>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-create')): ?>
                            <a href="<?php echo e(route('users.create')); ?>">Create New User</a>
                        <?php endif; ?>
                    </div>
                    <div class="form-group ">

                        <?php if(session('status')): ?>
                            <div class="alert alert-info alert-dismissible">
                                <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo e(session('status')); ?>

                                <span aria-hidden="true">&times;</span>

                            </div>
                    </div>
                    <?php echo e(session()->forget('status')); ?>

                <?php else: ?>
                </div>
                <?php endif; ?>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Role</th>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-edit')): ?>
                                <th width="50px">Action</th>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-delete')): ?>
                                <th width="50px">Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($user->id); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td><?php echo e($user->name); ?></td>
                                <td><img src="<?php echo e(asset('thumbnails/' . $user->image)); ?>" alt="profile"
                                        style=" padding: 10px; margin: 0px; " width="50px" height="50px"></td>

                                <td>
                                    <?php if(!empty($user->getRoleNames())): ?>
                                        <?php $__currentLoopData = $user->getRoleNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <label class="badge badge-success"><?php echo e($v); ?></label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </td>


                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-edit')): ?>
                                    <td>

                                        <a class="btn btn-primary" href="<?php echo e(route('users.edit', $user->id)); ?>">Edit</a>

                                    </td>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-delete')): ?>
                                    <td>
                                        <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="Post">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                onclick="return confirm('Are you sure to delete this user ?')"
                                                class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo $users->links('pagination::bootstrap-5'); ?>





            </div>
        </div>
        </div>
        </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Muhammad Zaid Ali\Desktop\laravel3rdweek\laravel3rdweek-apiwithcommands\resources\views/show_users.blade.php ENDPATH**/ ?>