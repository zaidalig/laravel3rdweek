<style type="text/css">
    .center {
        margin: auto;
        width: 50%;
        border: 2px solid white;
        text-align: center;
        margin-top: 20px;
    }

    .font_size {
        text-align: center;
        font-size: 20px;
        padding-top: 0px;

    }

    .img_size {
        width: 100px;
        height: 100px;
    }

    .th_color {
        background-color: rgb(99, 138, 154);
    }

    .dg_pad {
        padding: 20px;

    }

    label {
        display: inline-block;
        width: 200px;
        padding-top: 5px;
        padding-left: 4px;
        margin: 5px;
        padding-left: 5px;

    }

    input {
        padding-top: 10px;
        margin: 2px;
    }

    .btn {
        margin-right: 10px
    }

    .category {
        padding-top: 5px;
        margin: 5px;
    }

    .quantity {
        padding-top: 5px;
        margin: 3px;
        margin-bottom: 5px;

    }
</style>



<?php $__env->startSection('content'); ?>
    <div class="container-scroller">

        <div class="main-panel">

            <div class="   content-wrapper">
                <form action="<?php echo e(url('products.search')); ?>" method="get" role="search">
                <div  style ="display:grid; padding:20px"
                class="d-flex  flex-wrap">
                    <input type="checkbox" id="pending" name="pending" value="pending">
                    <label for="pending"> Pending</label><br>
                    <input type="checkbox" id="approved" name="approved" value="approved">
                    <label for="approved"> Aprroved</label><br>
                    <input class="quantity" type="number" id="min_quantity" name="min_quantity">
                    <label for="min_quantity">Min Quantity</label><br>
                    <input class="quantity" type="number" id="max_quantity" name="max_quantity">
                    <label for="max_quantity"> Max Quantity</label><br>
                    <input class="quantity" type="number" id="min_price" name="min_price">
                    <label for="min_price">Min Price</label><br>
                    <input class="quantity" type="number" id="max_price" name="max_price">
                    <label for="max_price"> Max Price</label><br>
                    <input class="category" type="text" id="category" name="category">
                    <label for="category"> Category</label><br><br>
                </div>

                <div style="padding: 20px">

                        <?php echo e(csrf_field()); ?>

                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Search Products"> <span
                                class="input-group-btn">

                                <button style="
                                margin-left:20px;" type="submit"
                                    class="btn btn-primary">
                                    <span class="glyphicon glyphicon-search"> Search Product</span>
                                </button>

                            </span>

                        </div>

                    </form>

                </div>
                <div class="d-flex">
                    <div class="mr-auto "></div>
                    <div style="padding: 20px">
                        <a href="<?php echo e(route('products.create')); ?>">Add Prodcut</a>
                    </div>
                </div>

                <?php if(session()->has('message')): ?>
                    <div class="alert alert-success">

                        <?php echo e(session()->get('message')); ?>

                    </div>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-list')): ?>
                    <h2 class="font_size">All Products</h2>
                    <table class=" mx-auto center">
                        <tr class="th_color ">
                            <th class="dg_pad">Product title </th>
                            <th class="dg_pad">description</th>
                            <th class="dg_pad">Quantity</th>
                            <th class="dg_pad">Category</th>
                            <th class="dg_pad">Price</th>

                            <th class="dg_pad">Product Image</th>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-edit')): ?>
                                <th class="dg_pad">Edit</th>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-delete')): ?>
                                <th class="dg_pad">Delete</th>
                            <?php endif; ?>

                            <th class="dg_pad">Status</th>

                        </tr>
                        <?php $__currentLoopData = $product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($product->title); ?></td>
                                <td><?php echo e($product->description); ?></td>
                                <td><?php echo e($product->quantity); ?></td>
                                <td><?php echo e($product->catagory); ?></td>
                                <td><?php echo e($product->price); ?></td>
                                <td><img class="img_size" src="/product/<?php echo e($product->image); ?>" alt=""></td>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-edit')): ?>
                                    <td>
                                        <a class="btn btn-primary" href="<?php echo e(route('products.edit', $product->id)); ?>">Edit</a>
                                    </td>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-delete')): ?>
                                    <td>
                                        <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="Post">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" onclick="return confirm('Are you sure to delete this user ?')"
                                                class=" btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                                <td>
                                    <?php if($roles[0] == 'Admin'): ?>
                                        <?php if($product->status == 'pending'): ?>
                                            <form action="<?php echo e(url('products.approve', $product->id)); ?>" method="Post">
                                                <?php echo csrf_field(); ?>

                                                <button type="submit"
                                                    onclick="return confirm('Are you sure to Approve this Product ?')"
                                                    class=" btn btn-danger">Pending</button>
                                            </form>
                                        <?php else: ?>
                                            <h6><?php echo e($product->status); ?></h6>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <h6><?php echo e($product->status); ?></h6>
                                </td>
                        <?php endif; ?>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Muhammad Zaid Ali\Desktop\laravel3rdweek\laravel3rdweek-apiwithcommands\resources\views/product/products.blade.php ENDPATH**/ ?>