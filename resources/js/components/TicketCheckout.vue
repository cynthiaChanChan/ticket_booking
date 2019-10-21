<template>
    <div class="form">
        <div class="form__group">
            <label class="form__label">Price</label>
            <span class="form__control form__control--static">${{ priceInDollars }}</span>
        </div>
        <div class="form__group">
            <label class="form__label" for="quantity">Qty</label>
            <input class="form__control" id="quantity" value="1" type="number" v-model="quantity">
        </div>
        <button class="btn form__btn"
            @click="openStripe"
            :class="{ 'btn__loading': processing}"
            :disabled="processing"
        >
            &nbsp;
            <span class="btn__visible">Buy Tickets</span>
            <span class="btn__invisible">Only {{ ticketsRemaining }} tickets left</span>
        </button>
    </div>   
</template>

<script>
export default {
    props: [
        'price',
        'concertTitle',
        'concertId',
        'ticketsRemaining'
    ],
    data() {
        return {
            quantity: 1,
            stripeHandler: null,
            processing: false,
            rootUrl: ""
        }
    },
    computed: {
        description() {
            if (this.quantity > 1) {
                return `${this.quantity} tickets to ${this.concertTitle}`;
            }
            return `One ticket to ${this.concertTitle}`
        },
        totalPrice() {
            return this.quantity * this.price
        },
        priceInDollars() {
            return (this.price / 100).toFixed(2)
        },
        totalPriceInDollars() {
            return (this.totalPrice / 100).toFixed(2)
        }
    },
    methods: {
        initStripe() {
            const handler = StripeCheckout.configure({
                key: App.stripePublicKey
            });
            window.addEventListener('popstate', function() {
                handler.close();
            });
            return handler;
        },
        openStripe() {
            const data = {
                name: 'Ticket Booking',
                allowRememberMe: false,
                description: this.description,
                panelLabel: 'Pay {{amount}}',
                currency: "usd",
                amount: this.totalPrice ,
                image: '../images/checkout-icon.png',
                token: this.purchaseTickets
            }
            
            this.stripeHandler.open(data);
        },
        purchaseTickets(token) {
            this.processing = true;
            axios.post(`${this.rootUrl}/concerts/${this.concertId}/orders`, {
                email: token.email,
			    ticket_quantity: this.quantity,
			    payment_token: token.id
            }).then(response => {
			    window.location = `${this.rootUrl}/orders/${response.data.confirmation_number}`;

            }).catch(response => {
                this.processing = false;
            });
        },
        getRoot() {
            var url, publicPos, publicEnd;
            url = window.location.href;
            publicPos = url.indexOf('/public');
            publicEnd = 0;
            if (publicPos > -1) {
                publicEnd = publicPos + 7;
            }
            return url.slice(0, publicEnd);
        }
    },
    created() {
        this.stripeHandler = this.initStripe();
        this.rootUrl = this.getRoot();
    }
}
</script>