<template>
    <div>
        <div class="row">
            <div class="col-sm-6">
                <h3>Choose your sizes</h3>
                <hr>
                <div v-for="product in products" style="display: inline">
                    <button @click="createItem(product)" class="btn btn-default" >{{ product.name }}</button>
                </div>
                <hr v-if="products.length > 0">
                <div v-for="item in items">
                    <item2 :item="item" @delete-item="deleteItem">
                    </item2>
                </div>
                <hr v-if="items.length > 0">
                <div class="row">
                    <div class="col-xs-3">
                        Subtotal:
                    </div>
                    <div class="col-xs-3 col-xs-offset-6">
                        $ {{ calculatedSubtotal }}
                    </div>    
                </div>
                <div class="row">
                    <div class="col-xs-3">
                        Shipping:
                    </div>
                    <div class="col-xs-3 col-xs-offset-6">
                        $ {{ calculatedShipping }}
                    </div>    
                </div>
                <div class="row">
                    <div class="col-xs-3">
                        Tax:
                    </div>
                    <div class="col-xs-3 col-xs-offset-6">
                        $ {{ calculatedTax }}
                    </div>    
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-3">
                        Total:
                    </div>
                    <div class="col-xs-3 col-xs-offset-6">
                        $ {{ totalPrice }}
                    </div>    
                </div>
            </div>
            <div class="col-sm-6">
                <h3>Address</h3>
                <hr>
                <address-picker :address="address">
                </address-picker>
            </div>
        </div>
        <div class="row">
                <button @click="pay" class="col-xs-12 text-center btn btn-default">Pay</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['products', 'designId'],
        data: function() {
            return {
                items: [],
                subtotal: 0,
                shipping: 0,
                tax: 0,
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
                }
            }
        },
        methods: {
            createItem: function(product) {
                var item = {
                    product : product,
                    design_id: this.designId,
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
                if(this.totalQuantity() > 0 && this.address.is_valid){
                    alert('pagando');
                }else{
                    this.address.show_errors = true;
                }
            },
            totalQuantity: function() {
                var total = 0;

                this.items.forEach( function(item){ 
                    total = total + item.quantity;
                });

                return total;
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
                var data = {
                    zip: this.address.zip
                }
                var percentage = 0;
                this.$http.post('/calculateTax', data).then((response) => {
                    this.tax = (this.subtotal + this.shipping) * response.body.tax_percentage;
                });
                return this.tax;
            },
            totalPrice: function() {
                return (this.subtotal + this.shipping + this.tax);
            }
        }
    }
</script>