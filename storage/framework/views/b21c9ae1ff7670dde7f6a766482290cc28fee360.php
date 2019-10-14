<?php $__env->startSection('body'); ?>
<div class="flex-col full-height">
    <header>
        <nav class="navbar">
            <div class="container nav-content">
                <div>
                    <img class="logo" src="<?php echo e(url('images/logo.svg')); ?>" alt="logo">
                </div>
                <div class="logout">
                    <form action="<?php echo e(route('auth.logout')); ?>" method="POST">
                        <?php echo e(csrf_field()); ?>

                        <button type="submit">Log out</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    
    <?php echo $__env->yieldContent('backstageContent'); ?>
    
    <footer class="backstage-footer">
        <div class="container">&copy; <?php echo e(date('Y')); ?></div>
    </footer>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\ticket_booking\resources\views/layouts/backstage.blade.php ENDPATH**/ ?>