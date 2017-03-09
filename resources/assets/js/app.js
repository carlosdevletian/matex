
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('fpd', require('./components/Fpd.vue'));
Vue.component('cart', require('./components/Cart.vue'));
Vue.component('item', require('./components/Item.vue'));
Vue.component('modal', require('./components/Modal.vue'));
Vue.component('order', require('./components/Order.vue'));
Vue.component('checkout', require('./components/Checkout.vue'));
Vue.component('cart-item', require('./components/CartItem.vue'));
Vue.component('create-order', require('./components/CreateOrder.vue'));
Vue.component('contact-modal', require('./components/ContactModal.vue'));
Vue.component('design-picker', require('./components/DesignPicker.vue'));
Vue.component('address-picker', require('./components/AddressPicker.vue'));

Vue.filter('inDollars', function(cents) {
    return (cents / 100).toLocaleString('en-US');
});

window.Event = new Vue();

const app = new Vue({
    el: '#app',
    data: {
        showContactModal: false,
        modalActive: false,
        showDesignPicker: false,
    },
    created: function() {
        var vm = this;
        Event.$on('close-design-picker', function() {
            vm.showDesignPicker = false;
        })
    },
    methods: {
        openContactModal: function() {
            this.showContactModal = true;
            this.modalActive = true;
        },
        closeContactModal: function() {
            this.showContactModal = false;
            this.modalActive = false;
        }
    }
});
