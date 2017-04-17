<template>
    <div>
        <div v-if="items.length > 0">
            <order-template>
                <h3 slot="items-title">Your items</h3>
                <div slot="table-header" class="table-responsive borderless">
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
                <h3 slot="address-title">Select a shipping address</h3>
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
        <div v-else>
            There are no items in your cart.
        </div>
    </div>
</template>

<script>
    import { stripeMixin } from '../../mixins/stripeMixin';

    export default {
        mixins: [stripeMixin],
        props: ['addresses', 'originalItems'],
        data: function() {
            return {
                items: this.originalItems,
                availableItems: this.getAvailableItems(),
                subtotal: 0,
                shipping: 0,
                tax: 0,
                order_id: null,
                selectedAddress: 0,
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
            getAvailableItems: function() {
                var availableItems = [];
                this.originalItems.forEach(function(item) {
                    if(!! +item.available) {
                        availableItems.push(item);
                    }
                })
                return availableItems;
            },
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
                if(this.address.zip.length == 5) {
                    var data = {
                        zip: this.address.zip
                    }
                    axios.post('/calculateShipping', data).then((response) => {
                        this.shipping = response.data.shipping;
                    });
                }
            },
            calculateTax: function() {
                var data = {
                    zip: this.address.zip
                }
                axios.post('/calculateTax', data).then((response) => {
                    this.tax = (this.subtotal + this.shipping) * response.data.tax_percentage;
                });
            },
        },
        watch: {
            'address.zip': function (getShippingAndTax) {
                this.calculateShipping();
            },
            shipping: function() {
                this.calculateTax();
            },
            subtotal: function (getTax) {
                this.calculateTax();
            }
        },
        computed:  {
            zipIsValid: function() {
                return this.address.zip.length == 5;
            },
            calculatedSubtotal: function() {
                if(this.availableItems.length > 0) {
                    this.subtotal = 0;
                    var vm = this;
                    this.availableItems.forEach(function(item) {
                        vm.subtotal = (vm.subtotal + +item.total_price);
                    });
                    return this.subtotal;
                }
            },
            totalPrice: function() {
                return (this.subtotal + this.shipping + this.tax);
            },
            filteredShipping: function() {
                if(this.zipIsValid) {
                    return '$ ' + (this.shipping / 100).toLocaleString('en-US');
                }
                return '-';
            },
            filteredTax: function() {
                if(this.zipIsValid) {
                    return '$ ' + (this.tax / 100).toLocaleString('en-US');
                }
                return '-';
            },
            filteredTotal: function() {
                if(this.zipIsValid) {
                    return '$ ' + (this.totalPrice / 100).toLocaleString('en-US');
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
    .Order__title--orange {
        font-size: 20px;
        color: #F16A01;
    }
    .Order__title--blue {
        font-size: 20px;
        color: #0000AA;
    }
</style>
