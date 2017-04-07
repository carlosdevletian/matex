<template>
    <div>
        <div v-if="itemQuantity > 0" class="pd-btm-25">
            <div class="borderless">
                <table class="table borderless mg-0">
                    <tbody>
                        <tr>
                            <td class="col-xs-6">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a role="button" @click="openImage">
                                            <div class="background-image Thumbnail--image box-shadow" 
                                                :style="imageUrl">
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="col-xs-6">
                                <p class="text-right mg-0 pd-top-8">
                                    {{ firstItem.quantity }} {{ firstItem.product.name }} {{ firstItem.design.category.name }} 
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="itemQuantity != 1">
                    <p class="text-right mg-0">
                        ... and {{ itemQuantity - 1 }} more
                    </p>
            </div>
            <hr v-if="itemQuantity != 1" style="margin-top: 0;">
            <p>
                Subtotal: $ {{ subtotal }}
            </p>
        </div>
        <p v-else class="pd-btm-25">
            There are no items in your cart
        </p>
        <a href="/cart" class="Button Button--primary stick-to-bottom color-white">Go to cart</a>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                firstItem: {
                    design: {
                        image_name: '',
                        category: {
                            name: ''
                        }
                    },
                    product: {
                        name: ''
                    }
                },
                itemQuantity: 0,
                subtotal: 0
            }
        },
        mounted: function() {
            this.updateCartPreview();
        },
        created: function() {
            var vm = this;
            Event.$on('item-updated', function(updatedItem) {
                vm.updateCartPreview();
            })

            Event.$on('item-deleted', function() {
                vm.updateCartPreview();
            })
        },
        methods: {
            updateCartPreview: function() {
                axios.get('/cartPreview').then((response) => {
                    this.firstItem = response.data.firstItem;
                    this.itemQuantity = response.data.itemQuantity;
                    this.subtotal = response.data.subtotal;
                });
            },
            openImage: function() {
                Event.$emit('open-image', this.firstItem.design)
            }
        },
        computed: {
            imageUrl: function() {
                return {
                    backgroundImage : "url('/images/"+this.firstItem.design.image_name+"/1')",
                    height: '100px !important',
                }
            }
        }
    }
</script>