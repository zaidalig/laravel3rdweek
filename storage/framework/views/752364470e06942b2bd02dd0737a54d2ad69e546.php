<style type="text/css">
    .div_center {
        text-align: center;
        padding-top: 40px;
    }

    .h2_font {
        font-size: 40px;
        padding-bottom: 40px;
    }

    .input_color {
        color: black;
    }

    .center {
        margin: auto;
        width: 50%;
        text-align: center;
        margin-top: 30px;
        border: 3px solid white;
    }
</style>
<?php $__env->startSection('content'); ?>
    <div class="container-scroller">

        <div class="main-panel">

            <div class="content-wrapper">
                <?php if(session()->has('message')): ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">

                        </button>
                        <?php echo e(session()->get('message')); ?>

                    </div>
                <?php endif; ?>
                <div class="content-wrapper">
                    <?php if(session()->has('errors')): ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">

                            </button>
                            <?php echo e(session()->get('errors')); ?>

                    <?php endif; ?>

                </div>
                <div style="padding: 20px">
                    <form action="<?php echo e(url('categories.search')); ?>" method="get" role="search">
                        <?php echo e(csrf_field()); ?>

                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Search Category by name"> <span
                                class="input-group-btn">
                                <button style="background-color: red;
                                margin-left:20px;
                                " type="submit" class="btn btn-default">
                                    <span class="glyphicon glyphicon-search"> Search Category</span>
                                </button>
                            </span>
                        </div>
                    </form>

                </div>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-create')): ?>
                    <div class='div_center'>
                        <h2 class="h2_font">Add Catagory</h2>

                        <form action="<?php echo e(route('categories.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input required type="text" class="input_color" name="category_name"
                                placeholder="write catagory name">

                            <input type="submit" name="submit" value="add catagory " class="btn btn-primary">

                        </form>
                    </div>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-list')): ?>
                    <table class="center">
                        <tr>
                            <td>Category name</td>
                         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-edit')): ?>


                            <td>Action</td>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-delete')): ?>
                            <td>Action</td>
                            <?php endif; ?>
                        </tr>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($categories->category_name); ?></td>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-edit')): ?>


                                <td>
                                    <a class="btn btn-primary" href="<?php echo e(route('categories.edit', $categories)); ?>">Edit</a>

                                </td>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-delete')): ?>
                                <td>
                                    <form action="<?php echo e(route('categories.destroy', $categories->id)); ?>" method="Post">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                            onclick="return confirm('Are you sure to delete this Category ?')"
                                            class=" btn btn-danger">Delete</button>
                                    </form>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                <?php endif; ?>
            </div>


        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Muhammad Zaid Ali\Desktop\laravel3rdweek\laravel3rdweek-apiwithcommands\resources\views/categories/category.blade.php ENDPATH**/ ?>