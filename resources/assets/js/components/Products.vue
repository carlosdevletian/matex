<template>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="wrapper">
                <div v-dragula="products" class="Dragula" bag="products-bag">
                    <h4>Products</h4>
                    <div v-for="product in sortedProducts" :key="product.id">
                        <div class="row Card Card--half-pd">
                            <div class="col-xs-1">
                                <span>&#10005;</span>
                            </div>
                            <div class="col-xs-5">
                                <div class="Input__icon">
                                    <input :id="product.id"
                                        type="text"
                                        class="Form"
                                        name="products[]"
                                        placeholder="Product Name"
                                        v-model="product.name"
                                        required>
                                    <input type="hidden" name="ids[]" v-model="product.id">
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="Input__icon">
                                    <input type="text"
                                        class="Form"
                                        name="widths[]"
                                        placeholder="Width"
                                        v-model="product.width"
                                        required>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="Input__icon">
                                    <input type="text"
                                        class="Form"
                                        name="lengths[]"
                                        placeholder="Length"
                                        v-model="product.length"
                                        required>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <i class="fa fa-bars fa-2x" aria-hidden="true" style="cursor: move"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row Card Card--half-pd">
                        <div class="col-xs-1">
                            <span>&#10005;</span>
                        </div>
                        <div class="col-xs-5">
                            <div class="Input__icon">
                                <input id="newproduct"
                                    type="text"
                                    class="Form"
                                    name="products[]"
                                    placeholder="New Product">
                                <input type="hidden" name="ids[]" value="">
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="Input__icon">
                                <input type="text"
                                    class="Form"
                                    name="widths[]"
                                    placeholder="Width">
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="Input__icon">
                                <input type="text"
                                    class="Form"
                                    name="lengths[]"
                                    placeholder="Length">
                            </div>
                        </div>
                        <div class="col-xs-2">
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
        computed: {
            sortedProducts: function() {
                return this.products.sort(function(productA,productB){
                    return productA.display_position - productB.display_position;
                })
            }
        }
    }
</script>
