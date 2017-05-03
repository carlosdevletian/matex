<template>
    <div>
        <div v-show="unavailableItems.length > 0" style="display: flex; justify-content: center">
            <div class="Card text-center" style="display: inline-block">
                <p v-if="! showUnavailable" class="mg-0">
                    Looks like some of your selected items are unavailable...
                    <a role="button" @click="showUnavailable = true">See unavailable items</a>
                </p>
                <a v-else role="button" @click="showUnavailable = false">Back</a>
            </div>
        </div>
        <div v-if="unavailableItems.length > 0 && showUnavailable">
            <div class="Card Card--double-pd col-sm-6 col-sm-offset-3">
                <div class="row">
                    <div class="Order__title--orange text-center">
                        Unavailable items
                    </div>
                </div>
                <div class="row"><hr></div>
                <div class="borderless">
                    <table class="table borderless mg-0">
                        <tbody>
                            <tr>
                                <td class="pd-0 col-xs-7">
                                        <p class="text-center mg-0">Items</p>
                                </td>
                                <td class="pd-0 col-xs-3">
                                        <p class="text-center mg-0 visible-xs-block">Qty</p>
                                        <p class="text-center mg-0 hidden-xs">Quantity</p>
                                </td>
                                <td class="pd-0 col-xs-2">
                                        <p class="text-center mg-0">Price</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-for="item in unavailableItems">
                    <item-cart-create :item="item" @delete-item="deleteUnavailableItem" @item-updated="updateItem" :key="item.id">
                    </item-cart-create>
                </div>
            </div>
        </div>
        <div v-if="items.length > 0 && ! showUnavailable">
            <order-template>
                <p slot="items-title">Your items</p>
                <div slot="table-header" class="borderless">
                    <table class="table borderless mg-0">
                        <tbody>
                            <tr>
                                <td class="pd-0 col-xs-7">
                                        <p class="text-center mg-0">Items</p>
                                </td>
                                <td class="pd-0 col-xs-3">
                                        <p class="text-center mg-0 visible-xs-block">Qty</p>
                                        <p class="text-center mg-0 hidden-xs">Quantity</p>
                                </td>
                                <td class="pd-0 col-xs-2">
                                        <p class="text-center mg-0">Price</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div slot="items">
                    <div v-for="item in items">
                        <item-cart-create :item="item" @delete-item="deleteItem" @item-updated="updateItem" :key="item.id">
                        </item-cart-create>
                    </div>
                </div>
                <div slot="spinner">
                    <i v-show="amountsLoading" class="fa fa-spinner fa-spin Spinner"></i>
                </div>
                <div slot="subtotal">$ {{ calculatedSubtotal | inDollars }}</div>
                <div slot="zip-error">
                    <div class="row" v-show="! zipIsValid">
                        <hr>
                        <div class="col-xs-12 text-center color-secondary pd-20">
                            An address must be entered to calculate shipping and tax
                        </div>
                        <hr>
                    </div>
                </div>
                <div slot="shipping">{{ filteredShipping }}</div>
                <div slot="tax">{{ filteredTax }}</div>
                <div slot="total">{{ filteredTotal }}</div>
                <p slot="address-title">Select a shipping address</p>
                <div slot="address-picker">
                    <address-picker
                        :existing-addresses="addresses"
                        :address="address"
                        @update-selected-address="updateSelectedAddress">
                    </address-picker>
                </div>
                <div slot="buttons">
                    <div class="row">
                        <div class="col-xs-6 col-xs-offset-3">
                            <button @click="pay"
                            class="Button--secondary box-shadow mg-btm-20"
                            >Checkout</button>
                        </div>
                    </div>
                </div>
            </order-template>
        </div>
        <div v-if="items.length <= 0 && unavailableItems.length <= 0" class="Card">
            There are no items in your cart.
        </div>
    </div>
</template>

<script>
    import { stripeMixin } from '../../mixins/stripeMixin';

    export default {
        mixins: [stripeMixin],
        props: ['addresses', 'originalItems', 'originalUnavailableItems'],
        data: function() {
            return {
                amountsLoading: false,
                items: this.originalItems,
                unavailableItems: this.originalUnavailableItems,
                subtotal: 0,
                shipping: 0,
                tax: 0,
                order_id: null,
                selectedAddress: 0,
                showUnavailable: false,
                address: {
                    email: '',
                    name: '',
                    street: '',
                    city: '',
                    state: '',
                    zip: '',
                    country: '',
                    phone_number: '',
                    comment: '',
                    is_valid: false,
                    show_errors: false
                },
            }
        },
        methods: {
            deleteItem: function(itemId) {
                var vm = this;

                axios.delete('/items/' + itemId).then((response) => {
                    this.items.forEach(function(item, index){
                        if(item.id == itemId){
                            vm.items.splice(index, 1);
                        }
                    });
                    Event.$emit('item-deleted');
                });
            },
            deleteUnavailableItem: function(itemId) {
                var vm = this;
                axios.delete('/items/' + itemId).then((response) => {
                    this.unavailableItems.forEach(function(item, index){
                        if(item.id == itemId){
                            vm.unavailableItems.splice(index, 1);
                        }
                    });
                    if(this.unavailableItems.length == 0) this.showUnavailable = false;
                });
            },
            totalQuantity: function() {
                var total = 0;

                this.items.forEach( function(item){
                    total = total + item.quantity;
                });

                return total;
            },
            updateSelectedAddress: function(data) {
                this.selectedAddress = data.id;
                this.address.zip = data.zip;
            },
            canPay: function() {
                return this.totalQuantity() > 0 && (this.address.is_valid || this.selectedAddress != 0);
            },
            updateItem: function(updatedItem) {
                this.items.forEach(function(item) {
                    if(updatedItem.id == item.id) {
                        item.quantity = updatedItem.quantity;
                        item.unit_price = updatedItem.unit_price;
                        item.total_price = updatedItem.total_price;
                    }
                });
            },
            calculateShipping: function() {
                if(this.zipIsValid) {
                    var data = {
                        zip: this.address.zip
                    }
                    axios.post('/calculateShipping', data).then((response) => {
                        this.shipping = response.data.shipping;
                    });
                }
                this.amountsLoading = false;
            },
            calculateTax: function() {
                if(this.zipIsValid) {
                    var data = {
                        zip: this.address.zip
                    }
                    axios.post('/calculateTax', data).then((response) => {
                        this.tax = (this.subtotal + this.shipping) * response.data.tax_percentage;
                    });
                }
                this.amountsLoading = false;
            },
        },
        watch: {
            'address.zip': function (getShippingAndTax) {
                this.amountsLoading = true;
                this.calculateShipping();
            },
            shipping: function() {
                this.amountsLoading = true;
                this.calculateTax();
            },
            subtotal: function (getTax) {
                this.amountsLoading = true;
                this.calculateTax();
            }
        },
        computed:  {
            zipIsValid: function() {
                return this.address.zip.length == 5;
            },
            calculatedSubtotal: function() {
                if(this.items.length > 0) {
                    this.amountsLoading = true;
                    this.subtotal = 0;
                    var vm = this;
                    this.items.forEach(function(item) {
                        vm.subtotal = (vm.subtotal + +item.total_price);
                    });
                    this.amountsLoading = false;
                    return this.subtotal;
                }
            },
            totalPrice: function() {
                return (this.subtotal + this.shipping + this.tax);
            },
            filteredShipping: function() {
                if(this.zipIsValid  && this.calculatedSubtotal > 0) {
                    return '$ ' + (this.shipping / 100).toLocaleString('en-US', { minimumFractionDigits: 2 });
                }
                return '-';
            },
            filteredTax: function() {
                if(this.zipIsValid  && this.calculatedSubtotal > 0) {
                    return '$ ' + (this.tax / 100).toLocaleString('en-US', { minimumFractionDigits: 2 });
                }
                return '-';
            },
            filteredTotal: function() {
                if(this.zipIsValid) {
                    return '$ ' + (this.totalPrice / 100).toLocaleString('en-US', { minimumFractionDigits: 2 });
                }
                return '-';
            }
        }
    }
</script>


<style type="text/css">
    .left {
        left: 0;
    }
</style>
