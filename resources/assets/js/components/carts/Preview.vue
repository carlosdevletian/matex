<template>
    <div class="row color-grey">
        <div v-if="itemQuantity > 0">
            <div style="padding: 5px 0px; min-height: 170px">
                <div class="col-xs-5">
                    <a role="button" @click="openImage">
                        <div class="background-image Thumbnail--image box-shadow" 
                            :style="imageUrl">
                        </div>
                    </a>
                </div>
                <div class="col-xs-7">
                    <p>
                        {{ firstItem.quantity }} {{ firstItem.product.name }} {{ firstItem.design.category.name }} 
                    </p>
                    <div v-if="itemQuantity != 1">
                        <p>
                            ... and {{ itemQuantity - 1 }} more
                        </p>
                    </div>
                    <hr>
                    <p class="color-secondary">
                        Subtotal: ${{ subtotal | inDollars }}
                    </p>
                </div>
            </div>
            <a href="/cart" class="Button Button--primary stick-to-bottom color-white">Go to cart</a>
        </div>
        <p v-else class="text-center mg-top-10">
            Your cart is empty
        </p>
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