<template>
    <div>
        <div class="row">
            <div class="col-xs-12">
                <h1>Choose your products</h1>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12" style="padding-bottom: 10px">
                <div v-for="product in products" style="display: inline; padding: 5px">
                    <button @click="updateSelectedProducts(product)" class="Button--calculator">
                        {{ product.name }}
                        <i v-if="alreadySelected(product.id)" class="fa fa-check-circle" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row" v-if="selected.length > 0">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-7"></div>
                    <div class="col-xs-2">Price</div>
                    <div class="col-xs-3">Total</div>
                </div>
                <hr>
                <div class="row">
                    <div v-for="item in selected">
                        <item :item="item" @quantity-updated="updateItem" @delete-item="deleteItem" style="padding-bottom: 5px"></item>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-1"></div>
                    <div class="col-xs-3">Subtotal</div>
                    <div class="col-xs-5"></div>
                    <div class="col-xs-3">${{ totalPrice }}</div>
                </div>
                <div class="row">
                    <div class="col-xs-1"></div>
                    <div class="col-xs-3">Shipping</div>
                    <div class="col-xs-5"></div>
                    <div class="col-xs-3">${{ totalPrice }}</div>
                </div>
                <div class="row">
                    <div class="col-xs-1"></div>
                    <div class="col-xs-3">Tax</div>
                    <div class="col-xs-5"></div>
                    <div class="col-xs-3">${{ totalPrice }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-1"></div>
                    <div class="col-xs-3">Total</div>
                    <div class="col-xs-5"></div>
                    <div class="col-xs-3">${{ totalPrice }}</div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 10px">
            <div class="col-xs-12 text-center" v-if="selected.length > 0">
                <button class="btn btn-primary" :disabled="!canContinue" @click="addToCart" v-if="signedIn">Add to cart</button>
                <button class="btn btn-primary" :disabled="!canContinue" @click="showAddresses" v-if="stepTwo == false">Continue with checkout</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['categoryId', 'designId', 'stepTwo'],
        data: function() {
            return {
                products : '',
                selected : [],
                hidden : false,
                signedIn: Matex.signedIn,
            };
        },
        mounted: function () {
           this.$http.get('/categories/' + this.categoryId + '/products').then((response) => {
                this.products = response.body;
           });
        },
        methods: {
            updateSelectedProducts: function(product) {
                if(! this.alreadySelected(product.id)) {
                    this.hidden = false;
                    var item = {
                        product_id : product.id,
                        name : product.name,
                        quantity: 0,
                        unit_price: 0,
                        total_price: 0,
                        design_id: this.designId
                    };
                    this.selected.push(item);
                }
            },
            alreadySelected: function(productId) {
                var vm = this;
                var selected = false;

                this.selected.forEach(function(item) {
                    if (item.product_id == productId) {
                        selected = true;
                    }
                });
                return selected;
            },
            updateItem: function(item) {
                this.$emit('item-updated', item);
            },
            deleteItem: function(productId) {
                var vm = this;
                this.selected.forEach( function(item, index){ 
                    if(item.product_id == productId){
                        vm.selected.splice(index, 1); 
                    } 
                });
                if(this.selected.length == 0) {
                    this.stepOneIncomplete();
                };
                this.$emit('item-deleted', productId);
            },
            addToCart: function() {
                this.$emit('add-to-cart');
            },
            showAddresses: function() {
                this.$emit('enable-step-two');
            },
            stepOneIncomplete: function() {
                this.$emit('step-one-incomplete');
            },
            prueba: function(product) {
                alert(product.name);
            }
        },
        computed: {
            totalPrice: function() {
                var total = 0;
                this.selected.forEach(function(item) {
                    total = (total + item.total_price);
                });
                return total;
            },
            canContinue: function() {
                if(this.totalPrice <= 0){
                    this.stepOneIncomplete();
                    return false;
                }
                return true;
            },
        }
    }
</script>
<style type="text/css">
    .Button--calculator {
        background-color: transparent; 
        color: orange; 
        outline: 0; 
        padding: 10px 20px; 
        border: 2px solid orange; 
        border-radius: 5px;
        margin-bottom: 3px;
    }
</style>