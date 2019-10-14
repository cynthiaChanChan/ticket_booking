<?php $__env->startSection('body'); ?>
	<div class="container">
		<?php if($concert->hasPoster()): ?>
			<?php echo $__env->make('concerts.partials.card-with-poster', ['concert' => $concert], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php else: ?>
			<?php echo $__env->make('concerts.partials.card-no-poster', ['concert' => $concert], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php endif; ?>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('beforeScripts'); ?>

<script src="https://checkout.stripe.com/checkout.js"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\ticket_booking\resources\views/concerts/show.blade.php ENDPATH**/ ?>