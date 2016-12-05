
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
Vue.component('modal', require('./components/Modal.vue'));
Vue.component('contact-modal', require('./components/ContactModal.vue'));

const app = new Vue({
    el: '#app',

    data: {
        showContactModal: false,
        modalActive: false,
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
