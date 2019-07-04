$(function() {
	console.log(myApp.concert);
	$("#buy_tickets").submit(function(e) {
		e.preventDefault();
		myApp.openStripe();
		console.log("checkout...");
	});
});

myApp.initStripe = function() {
	var handler = StripeCheckout.configure({
		key: myApp.stripePublicKey
	});
	window.addEventListener('popstate', function() {
		handler.close();
	});
	return handler;
}

//open stripe payment
myApp.openStripe = function() {
	console.log(StripeCheckout);
	myApp.initStripe().open({
		name: 'Ticket Booking',
		allowRememberMe: false,
		description: window.myApp.concert.title,
		image: '../images/checkout-icon.png'
	});
};