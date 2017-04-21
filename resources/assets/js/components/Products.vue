<template>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="wrapper">
                <div v-dragula="products" class="Dragula" bag="products-bag">
                    <h4>Products</h4>
                    <div v-for="product in sortedProducts" :key="product.id">
                        <div class="row Card">
                            <input type="hidden" name="products[id][]" v-model="product.id">
                            <div class="col-xs-4">
                                <div class="Input__icon">
                                    <input type="text"
                                        class="Form"
                                        name="products[name][]"
                                        placeholder="Product Name"
                                        v-model="product.name"
                                        required>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="Input__icon">
                                    <input type="text"
                                        class="Form"
                                        name="products[width][]"
                                        placeholder="Width"
                                        v-model="product.width"
                                        required>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="Input__icon">
                                    <input type="text"
                                        class="Form"
                                        name="products[length][]"
                                        placeholder="Length"
                                        v-model="product.length"
                                        required>
                                </div>
                            </div>
                            <div class="col-xs-1">
                                <div class="Input__icon">
                                    <active-checkbox 
                                        :initial="product.is_active"
                                    ></active-checkbox>
                                </div>
                            </div>
                            <div class="col-xs-1">
                                <i class="fa fa-bars fa-2x" aria-hidden="true" style="cursor: move"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row Card">
                        <input type="hidden" name="products[id][]" :value="getNull()">
                        <div class="col-xs-4">
                            <div class="Input__icon">
                                <input type="text"
                                    class="Form"
                                    name="products[name][]"
                                    placeholder="New Product">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="Input__icon">
                                <input type="text"
                                    class="Form"
                                    name="products[width][]"
                                    placeholder="Width">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="Input__icon">
                                <input type="text"
                                    class="Form"
                                    name="products[length][]"
                                    placeholder="Length">
                            </div>
                        </div>
                        <div class="col-xs-1">
                            <div class="Input__icon">
                                <active-checkbox 
                                    initial="0"
                                ></active-checkbox>
                            </div>
                        </div>
                        <div class="col-xs-1">
                            <i class="fa fa-bars fa-2x" aria-hidden="true" style="cursor: move"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style type="text/css">
    .Dragula {
        touch-action: none;
    }
</style>

<script>
    export default {
        props: ['products'],
        methods: {
            getNull: function() {
                return null;
            }
        },
        computed: {
            sortedProducts: function() {
                return this.products.sort(function(productA,productB){
                    return productA.display_position - productB.display_position;
                })
            }
        }
    }
</script>
