
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
Vue.component('order-list', require('./components/orders/List.vue'));
Vue.component('order-show', require('./components/orders/Show.vue'));
Vue.component('order-create', require('./components/orders/Create.vue'));
Vue.component('order-template', require('./components/orders/Template.vue'));
Vue.component('order-cart-create', require('./components/orders/CartCreate.vue'));

Vue.component('item-show', require('./components/items/Show.vue'));
Vue.component('item-create', require('./components/items/Create.vue'));
Vue.component('item-cart-create', require('./components/items/CartCreate.vue'));

Vue.component('modal-image', require('./components/modals/Image.vue'));
Vue.component('modal-contact', require('./components/modals/Contact.vue'));
Vue.component('modal-template', require('./components/modals/Template.vue'));

Vue.component('fpd', require('./components/Fpd.vue'));
Vue.component('design-picker', require('./components/DesignPicker.vue'));
Vue.component('address-picker', require('./components/AddressPicker.vue'));

Vue.filter('inDollars', function(cents) {
    return (cents / 100).toLocaleString('en-US');
});

Vue.filter('ago', function(date) {
    return moment(date).format("dddd, MMMM Do YYYY");
});

window.Event = new Vue();

const app = new Vue({
    el: '#app',
    data: {
        design: '',
        modalActive: false,
        showImageModal: false,
        showContactModal: false,
        showDesignPicker: false,
    },
    created: function() {
        var vm = this;
        Event.$on('close-design-picker', function() {
            vm.showDesignPicker = false;
        })
        Event.$on('open-image', function(design) {
            vm.design = design;
            vm.openImageModal();
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
        },
        openImageModal: function(design = null) {
            if (design) {
                this.design = design;
            }
            this.showImageModal = true;
            this.modalActive = true;
        },
        closeImageModal: function() {
            this.showImageModal = false;
            this.modalActive = false;
            this.design = '';
        },
    }
});
