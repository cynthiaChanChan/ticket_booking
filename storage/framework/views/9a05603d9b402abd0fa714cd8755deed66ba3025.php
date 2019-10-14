<script>
	window.App = {
		csrfToken: '<?php echo e(csrf_token()); ?>',
    	stripePublicKey: '<?php echo e(config('services.stripe.key')); ?>'
	}
</script><?php /**PATH C:\wamp64\www\ticket_booking\resources\views/scripts/app.blade.php ENDPATH**/ ?>