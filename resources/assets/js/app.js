
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

Vue.component('item', require('./components/Item.vue'));
Vue.component('modal', require('./components/Modal.vue'));
Vue.component('contact-modal', require('./components/ContactModal.vue'));
Vue.component('address-selector', require('./components/AddressSelector.vue'));
Vue.component('price-calculator', require('./components/PriceCalculator.vue'));

const app = new Vue({
    el: '#app',

    data: {
        stepOne: true,
        stepTwo: false,
        stepThree: false,
        showContactModal: false,
        modalActive: false,
        orderItems: [],
        addressId: '',
        guestEmail: ''
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
        updateOrderItems: function(newItem) {  
            var foundDuplicateItem = false; 

            this.orderItems.forEach(function(oldItem) {
                if (oldItem.product_id == newItem.product_id) {
                    oldItem.quantity = newItem.quantity;
                    oldItem.unit_price = newItem.unit_price;
                    oldItem.total_price = newItem.total_price;
                    foundDuplicateItem = true;
                }
            });

            if(! foundDuplicateItem) {
                this.orderItems.push(newItem);
            }
        },
        deleteItem: function(productId) {
            var vm = this;

            this.orderItems.forEach(function(item, index){ 
                if(item.product_id == productId){ 
                    vm.orderItems.splice(index, 1);
                } 
            });
        },
        addToCart: function(){
            this.$http.post('/addToCart', this.orderItems).then((response) => { window.location = '/cart' });
        },
        storeAddress: function(addressId) {
            this.addressId = addressId;
            this.enableStepThree();
        },
        disableStepTwo: function() {
            this.stepTwo = false;
            this.stepThree = false;
        },
        enableStepTwo: function() {
            if(this.stepOne) {
                this.stepTwo = true;
            }
        },
        enableStepThree: function() {
            if(this.stepTwo) {
                this.stepThree = true;
            }
        },
        createOrder: function () {
            var order = {
                address_id : this.addressId,
                items: this.orderItems,
                email: this.guestEmail,
            };
            this.$http.post('/orders', order).then((response) => { window.location = '/orders/' + response.body.order.id });
        }
    }
});
