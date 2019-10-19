;

<?php $__env->startSection('body'); ?>

    <div class="container">
        <div class="modal">
            <h1 class="heading-primary heading-primary--main mg-bottom-bg">Connect Your Stripe Account</h1>
            <p class="mg-bottom-bg">Good news, Ticketbeast now integrated directly with your Stripe account!</p>
            <p class="mg-bottom-bg">To continue, connect your Stripe account by clicking the button below:</p>
            <a href="<?php echo e(route('backstage.stripe-connect.authorize')); ?>" class="btn btn--normal">Connect with Stripe</a>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\ticket_booking\resources\views/backstage/stripe-connect/connect.blade.php ENDPATH**/ ?>