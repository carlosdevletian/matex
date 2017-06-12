
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
Vue.component('order-pay', require('./components/orders/Pay.vue'));
Vue.component('order-list', require('./components/orders/List.vue'));
Vue.component('order-show', require('./components/orders/Show.vue'));
Vue.component('order-create', require('./components/orders/Create.vue'));
Vue.component('order-template', require('./components/orders/Template.vue'));
Vue.component('order-cart-create', require('./components/orders/CartCreate.vue'));

Vue.component('item-show', require('./components/items/Show.vue'));
Vue.component('item-create', require('./components/items/Create.vue'));
Vue.component('item-cart-create', require('./components/items/CartCreate.vue'));

Vue.component('design-show', require('./components/designs/Show.vue'));
Vue.component('design-thumbnail', require('./components/designs/Thumbnail.vue'));

Vue.component('category-show', require('./components/categories/Show.vue'));
Vue.component('accessory-show', require('./components/accessories/Show.vue'));

Vue.component('pricing-delete', require('./components/pricings/Delete.vue'));
Vue.component('pricing-create', require('./components/pricings/Create.vue'));

Vue.component('modal-image', require('./components/modals/Image.vue'));
Vue.component('modal-contact', require('./components/modals/Contact.vue'));
Vue.component('modal-template', require('./components/modals/Template.vue'));
Vue.component('user-comment', require('./components/modals/UserComment.vue'));
Vue.component('contact-user', require('./components/modals/ContactUser.vue'));
Vue.component('add-accessory', require('./components/modals/AddAccessory.vue'));

Vue.component('fpd', require('./components/Fpd.vue'));
Vue.component('products', require('./components/Products.vue'));
Vue.component('design-picker', require('./components/DesignPicker.vue'));
Vue.component('address-picker', require('./components/AddressPicker.vue'));

Vue.component('cart-preview', require('./components/carts/Preview.vue'));

Vue.component('faq', require('./components/Faq.vue'));
Vue.component('disclaimer', require('./components/Disclaimer.vue'));

Vue.component('active-checkbox', require('./components/ActiveCheckbox.vue'));
Vue.component('page-loader', require('./components/PageLoader.vue'));

Vue.directive('focus', {
    inserted: function (el) {
        el.focus()
    }
})

Vue.filter('inDollars', function(cents) {
    return (cents / 100).toLocaleString('en-US', { minimumFractionDigits: 2 });
});

Vue.filter('ago', function(date) {
    return moment(date).format("dddd, MMMM Do YYYY");
});

window.Event = new Vue();

const app = new Vue({
    el: '#app',
    data: {
        design: '',
        user: null,
        modalActive: false,
        pageIsLoading: true,
        selectedRole: 'Select a role for the new user',
        showImageModal: false,
        showCartPreview: false,
        showContactModal: false,
        showDesignPicker: false,
        showCreatePricing: false,
        showPredesignedPicker: false,
        showContactUserModal: false,
        showUserCommentModal: false,
    },
    created: function() {
        var vm = this;
        this.setLoadingSpinner();
        Event.$on('page-is-loading', function() {
            vm.pageIsLoading = true;
        })
        Event.$on('close-design-picker', function() {
            vm.showDesignPicker = false;
        })
        Event.$on('open-image', function(design) {
            vm.design = design;
            vm.openImageModal();
        })
    },
    methods: {
        createUser: function(event) {
            if(this.selectedRole == 1) {
                swal({
                    title: 'You are about to create an administrator',
                    text: "This user will have access to all parts of this website, do you want to continue?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'rgb(0, 0, 170)',
                    cancelButtonColor: 'rgb(208,67,40)',
                    confirmButtonText: 'Yes, create an admin'
                }).then(function () {
                    this.selectedRole = '';
                    event.target.submit();
                })
            }else {
                this.selectedRole = '';
                event.target.submit();
            }
        },
        openContactModal: function() {
            this.showContactModal = true;
            this.modalActive = true;
        },
        closeContactModal: function() {
            this.showContactModal = false;
            this.modalActive = false;
        },
        openContactUserModal: function() {
            this.showContactUserModal = true;
            this.modalActive = true;
        },
        closeContactUserModal: function() {
            this.showContactUserModal = false;
            this.modalActive = false;
        },
        openImageModal: function(design = null) {
            if (design) this.design = design;
            this.showImageModal = true;
            this.modalActive = true;
        },
        closeImageModal: function() {
            this.showImageModal = false;
            this.modalActive = false;
            this.design = '';
        },
        openUserCommentModal: function(user) {
            this.user = user;
            this.showUserCommentModal = true;
            this.modalActive = true;
        },
        closeUserCommentModal: function() {
            this.showUserCommentModal = false;
            this.modalActive = false;
            this.user = null;
        },
        deleteAddress: function(event) {
            swal({
                title: "Are you sure? <span class='Modal__close pd-0 top-0' onclick='swal.closeModal(); return false;'>&#10005;</span>",
                text: "You won't be able to revert this!",
                type: null,
                customClass: 'Modal',
                buttonsStyling: false,
                showConfirmButton: true,
                confirmButtonClass: 'Button--secondary stick-to-bottom',
                showCancelButton: false,
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {
                event.target.submit();
            }).catch(swal.noop);
        },
        setLoadingSpinner: function() {
            var vm = this;
            window.onload = function() {
                vm.pageIsLoading = false;
            }
        }
    }
});
