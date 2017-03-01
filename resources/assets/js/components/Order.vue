<template>
    <div style="background-color: white; padding: 20px 80px 20px 80px; position: relative; border-radius: 0px 0px 5px 5px; margin-bottom: 20px">
        <div style="padding-bottom: 40px">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="Order__title--orange">Choose your sizes</h3>
                    <hr>
                    <div class="row">
                        <div class="col-xs-6 col-xs-offset-3">
                            <div v-for="product in products">
                                <button @click="createItem(product)" class="Button--product">{{ product.name }}</button>
                            </div>
                        </div>
                    </div>
                    <hr v-if="products.length > 0">
                    <div v-for="item in items">
                        <item :item="item" @delete-item="deleteItem">
                        </item>
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
        <button v-if="signedIn"
            @click="addToCart"
            class="text-center Button--checkout left"
            >Add to cart</button>
    </div>
</template>

<script>
    export default {
        props: ['products', 'design', 'addresses'],
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
                signedIn: Matex.signedIn,
            }
        },
        methods: {
            createItem: function(product) {
                var item = {
                    product : product,
                    design_id: this.design,
                    quantity: 0,
                    unit_price: 0,
                    total_price: 0
                };

                this.items.push(item);

                this.removeProduct(product.id);
            },
            removeProduct: function(productId) {
                var vm = this;

                this.products.forEach( function(product, index){
                    if(product.id == productId){
                        vm.products.splice(index, 1);
                    }
                });
            },
            deleteItem: function(productId) {
                var vm = this;
                this.items.forEach( function(item, index){
                    if(item.product.id == productId){
                        vm.products.push(item.product);
                        vm.items.splice(index, 1);
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
                    this.$http.post('/prepareOrder', data).then((response) => {
                        alert('Hay que cobrar ' +  response.body);
                    });
                }else{
                    alert('error');
                    this.address.show_errors = true;
                }
            },
            addToCart: function() {
                if(this.totalQuantity() > 0) {
                    this.$http.post('/addToCart', this.items).then((response) => { window.location = '/cart' });
                }else{
                    alert('error');
                }
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
            calculateShipping: function() {
                if(this.address.zip.length == 5) {
                    var data = {
                        zip: this.address.zip
                    }
                    this.$http.post('/calculateShipping', data).then((response) => {
                        this.shipping = response.body.shipping;
                    });
                }
            },
            calculateTax: function() {
                var data = {
                    zip: this.address.zip
                }
                this.$http.post('/calculateTax', data).then((response) => {
                    this.tax = (this.subtotal + this.shipping) * response.body.tax_percentage;
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
                this.subtotal = 0;
                var vm = this;
                this.items.forEach(function(item) {
                    vm.subtotal = (vm.subtotal + item.total_price);
                });
                return this.subtotal;
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
