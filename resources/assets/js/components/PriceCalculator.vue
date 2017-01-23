<template>
    <div class="row">
        <div class="col-xs-3">
            <button @click="hidden=true" class="btn btn-default">+</button>
            <select multiple v-if="hidden" v-model="currentSelected" @change="updateSelectedProducts()" class="form-control">
                <option :value="[product.id, product.name]" v-for="product in products">
                    {{ product.name }}
                </option>
            </select>
        </div>
        <div class="col-xs-6" v-if="selected.length > 0">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    Selected Items
                </div>
                <div class="panel-body">
                    <div v-for="item in selected">
                        <item :item="item" @quantity-updated="updateItem" @delete-item="deleteItem"></item>
                    </div>
                </div>
                <div class="panel-footer" style="text-align:right">
                    Total: {{ totalPrice }}
                </div>
            </div>
        </div>
        <div class="col-xs-3" v-if="selected.length > 0">
            <button class="btn btn-primary" :disabled="totalPrice <= 0" @click="addToCart">Add to cart</button>
            <button class="btn btn-primary" :disabled="totalPrice <= 0" @click="showAddresses">Proceed to checkout</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['categoryId', 'designId'],
        data: function() {
            return {
                'products' : '',
                'currentSelected': [],
                'selected' : [],
                'hidden' : false,
            };
        },
        mounted: function () {
           this.$http.get('/category/' + this.categoryId + '/products').then((response) => {
                this.products = response.body;
           });
        },
        methods: {
            updateSelectedProducts: function() {
                if(! this.alreadySelected()) {
                    this.hidden = false;
                    var item = {
                        product_id : this.currentSelected[0][0],
                        name : this.currentSelected[0][1],
                        quantity: 0,
                        unit_price: 0,
                        total_price: 0,
                        design_id: this.designId
                    };
                    this.selected.push(item);
                }
            },
            alreadySelected: function() {
                var vm = this;
                var selected = false;

                this.selected.forEach(function(item) {
                    if (item.product_id == vm.currentSelected[0][0]) {
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
                this.$emit('item-deleted', productId);
            },
            addToCart: function() {
                this.$emit('add-to-cart');
            },
            showAddresses: function() {
                this.$emit('display-addresses');
            }
        },
        computed: {
            totalPrice: function() {
                var total = 0;
                this.selected.forEach(function(item) {
                    total = (total + item.total_price);
                });
                return total;
            }
        }
    }
</script>