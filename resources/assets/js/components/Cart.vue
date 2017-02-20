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
                            $ {{ calculatedShipping | inDollars }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            Tax:
                        </div>
                        <div class="col-xs-3 col-xs-offset-6">
                            $ {{ calculatedTax | inDollars }}
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
        <button @click="pay"
            class="text-center Button--checkout"
            >Checkout</button>
    </div>
</template>

<script>
    export default {
        props: ['addresses'],
        data: function() {
            return {
                items: [],
                subtotal: 0,
                shipping: 0,
                tax: 0,
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
            this.$http.get('/items').then((response) => {
                this.items = response.body;
           });
        },
        methods: {
            deleteItem: function(itemId) {
                var vm = this;
                
                this.$http.delete('/items/' + itemId).then((response) => {
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
            updateSelectedAddress: function(id) {
                this.selectedAddress = id;
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
            pay: function() {
                if(this.canPay()){
                    alert('pagando');
                    var data = {
                        newAddress: this.address,
                        selectedAddress: this.selectedAddress,
                        items: this.items,
                        design: this.design,
                    }
                    this.$http.post('/prepareCartOrder', data).then((response) => {
                        alert('Hay que cobrar ' +  response.body);
                    });
                }else{
                    alert('error');
                    this.address.show_errors = true;
                }
            }
        },
        computed:  {
            calculatedSubtotal: function() {
                this.subtotal = 0;
                var vm = this;
                this.items.forEach(function(item) {
                    vm.subtotal = (vm.subtotal + +item.total_price);
                });
                return this.subtotal;
            },
            calculatedShipping: function() {
                var data = {
                    zip: this.address.zip
                }
                this.$http.post('/calculateShipping', data).then((response) => {
                    this.shipping = response.body.shipping;
                });
                return this.shipping;
            },
            calculatedTax: function() {
                var subtotal = this.subtotal;
                var shipping = this.shipping;
                var data = {
                    zip: this.address.zip
                }
                this.$http.post('/calculateTax', data).then((response) => {
                    this.tax = (subtotal + shipping) * response.body.tax_percentage;
                });
                return this.tax;
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
