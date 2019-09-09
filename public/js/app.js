$(function() {
	console.log(myApp.concert);
	myApp.rootUrl = myApp.getRoot();
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
	var totalPrice = $("#quantity").val() * myApp.concert.ticket_price;
	myApp.initStripe().open({
		name: 'Ticket Booking',
		allowRememberMe: false,
		description: myApp.concert.title,
		currency: "usd",
		amount: totalPrice ,
		image: '../images/checkout-icon.png',
		token: myApp.purchaseTickets
	});
};

myApp.getRoot = function() {
	var url, publicPos, publicEnd;
	url = window.location.href;
	publicPos = url.indexOf('/public');
	publicEnd = 0;
	if (publicPos > -1) {
		publicEnd = publicPos + 7;
	}
	return url.slice(0, publicEnd);
};

//post to purchase tickets
myApp.purchaseTickets = function(token) {
	var submitBtn = $("#submit_btn");
	submitBtn.prop("disabled", true);
	$.post({
		url: myApp.rootUrl + "/concerts/" +  myApp.concert.id + "/orders",
		data: {
			email: token.email,
			ticket_quantity: $("#quantity").val(),
			payment_token: token.id
		},
		success: function(response) {
			window.location = `${myApp.rootUrl}/orders/${response.confirmation_number}`;
		},
		fail: function(response) {
			submitBtn.prop("disabled", false);
		}
	})
};