import TicketCheckout from './components/TicketCheckout.vue';
import bootstrap from './bootstrap';
import Vue from 'vue';


const app = new Vue({
    components: {
        TicketCheckout
    }
});

app.$mount('#app');
