<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-create')): ?>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Role Management</h2>
                </div>

                <div class="d-flex justify-content-center ">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-create')): ?>
                        <a class="btn btn-success" href="<?php echo e(route('roles.create')); ?>"> Create New Role</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e($message); ?></p>
        </div>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-list')): ?>
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Name</th>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-list')): ?>
                <th width="280px">Action</th>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-edit')): ?>
                <th width="280px">Action</th>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-delete')): ?>
                <th width="280px">Action</th>
                <?php endif; ?>
            </tr>
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e(++$i); ?></td>
                    <td><?php echo e($role->name); ?></td>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-list')): ?>
                        <td>
                            <a class="btn btn-info" href="<?php echo e(route('roles.show', $role->id)); ?>">Show</a>
                        </td>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-edit')): ?>
                        <td>
                            <a class="btn btn-primary" href="<?php echo e(route('roles.edit', $role->id)); ?>">Edit</a>
                        </td>
                    <?php endif; ?>
                    <td>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-delete')): ?>
                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']); ?>

                            <?php echo Form::submit('Delete', ['class' => 'btn btn-danger']); ?>

                            <?php echo Form::close(); ?>

                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </table>

        <?php echo $roles->render(); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Muhammad Zaid Ali\Desktop\laravel3rdweek\laravel3rdweek-apiwithcommands\resources\views/roles/index.blade.php ENDPATH**/ ?>