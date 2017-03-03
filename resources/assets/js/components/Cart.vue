<template>
    <div style="background-color: white; padding: 20px 80px 20px 80px; position: relative; border-radius: 0px 0px 5px 5px; margin-bottom: 20px">
        <div style="padding-bottom: 40px">
            <div class="row">
                <div class="col-sm-12">
                    <div v-for="item in items">
                        <cart-item :item="item" @delete-item="deleteItem" @item-updated="updateItem">
                        </cart-item>
                    </div>
                    <hr v-if="items.length > 0">
                    <div class="row">
                        <div class="col-xs-3">
                            Subtotal:
                        </div>
                        <div class="col-xs-3 col-xs-offset-6">
                            $ {{ calculatedSubtotal | inDollars }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            Shipping:
                        </div>
                        <div class="col-xs-3 col-xs-offset-6">
                            $ {{ shipping | inDollars }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            Tax:
                        </div>
                        <div class="col-xs-3 col-xs-offset-6">
                            $ {{ tax | inDollars }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-3">
                            Total:
                        </div>
                        <div class="col-xs-3 col-xs-offset-6">
                            $ {{ totalPrice | inDollars }}
                        </div>
                    </div>
                <hr>
                </div>
                <div class="col-sm-6">
                    <h3 class="Order__title--blue">Add your details</h3>
                    <hr>
                    <address-picker
                        :existing-addresses="addresses"
                        :address="address"
                        @update-selected-address="updateSelectedAddress">
                    </address-picker>
                </div>
            </div>
        </div>
        <checkout @pay="pay"></checkout>
    </div>
</template>

<script>
    import { stripeMixin } from '../mixins/stripeMixin';

    export default {
        mixins: [stripeMixin],
        props: ['addresses'],
        data: function() {
            return {
                items: [],
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
        mounted: function() {
            axios.get('/items').then((response) => {
                this.items = response.data;
           });
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
            calculatedSubtotal: function() {
                if(this.items.length > 0) {
                    this.subtotal = 0;
                    var vm = this;
                    this.items.forEach(function(item) {
                        vm.subtotal = (vm.subtotal + +item.total_price);
                    });
                    return this.subtotal;
                }
            },
            totalPrice: function() {
                return (this.subtotal + this.shipping + this.tax);
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
