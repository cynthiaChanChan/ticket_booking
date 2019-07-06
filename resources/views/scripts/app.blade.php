<script>
	window.myApp = {
		csrfToken: '{{ csrf_token() }}',
    stripePublicKey: '{{ config('services.stripe.key') }}'
	}
</script>