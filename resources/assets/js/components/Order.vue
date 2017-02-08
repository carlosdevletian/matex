<template>
    <div class="row">
        <div class="col-xs-6">
            <h3>Choose your sizes</h3>
            <div v-for="product in products">
                <button @click="createItem(product)">{{ product.name }}</button>
            </div>
            <div v-for="item in items">
                <item2 :item="item" @delete-item="deleteItem">
                </item2>
            </div>
        </div>
        <div class="col-xs-6">
            <address-picker>
            </address-picker>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['products', 'designId'],
        data: function() {
            return {
                items: [],
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
            }
        }
    }
</script>