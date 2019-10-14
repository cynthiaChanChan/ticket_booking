<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo $__env->yieldContent('title', 'Ticket_booking'); ?></title>
        <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
        <link rel="shortcut icon" type="image/png" href="<?php echo e(asset('favicon.ico')); ?>">
        <?php echo $__env->make('scripts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </head>
    <body>
        <div id="app">
            <?php echo $__env->yieldContent('body'); ?>
        </div>

        <?php echo $__env->yieldPushContent('beforeScripts'); ?>
        <script src="<?php echo e(asset('js/app.js')); ?>"></script>        
        <?php echo $__env->yieldPushContent('afterScripts'); ?>
    </body>
</html><?php /**PATH C:\wamp64\www\ticket_booking\resources\views/layouts/master.blade.php ENDPATH**/ ?>