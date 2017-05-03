<template>
    <div>
        <div class="borderless position-relative">
            <table class="table borderless mg-0">
                <tbody>
                    <tr>
                        <td class="col-xs-7">
                            <div class="row">
                                <div class="col-xs-4">
                                    <a role="button" @click="openImage">
                                        <div class="background-image Thumbnail--image box-shadow" 
                                            :style="imageUrl">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-8">
                                    <p class="mg-0 pd-top-8">
                                        {{ productName() }} {{ categoryName() }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="col-xs-3">
                            <p class="text-center mg-0 pd-top-8">{{ item.quantity }}</p>
                        </td>
                        <td class="col-xs-2">
                            <p class="text-center mg-0 pd-top-8">$ {{ item.unit_price | inDollars }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-show="!isAvailable()" 
                style="background-color: rgba(0,0,0,0.6);
                    color: white; 
                    position: absolute; 
                    width: 100%; 
                    height: 100%; 
                    top: 0;
                    display: flex;
                    align-items: center;
                    justify-content: center">
                Item currently unavailable
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['item'],
        data: function() {
            return {
                imageUrl: {
                    backgroundImage : `url(/images/${this.item.design.image_name}/1)`,
                    height: '40px !important',
                }
            }
        },
        methods: {
            openImage: function() {
                Event.$emit('open-image', this.item.design)
            },
            isAvailable: function() {
                return !! +this.item.available;
            },
            productName: function() {
                return `${this.item.product.name.charAt(0).toUpperCase()}${this.item.product.name.slice(1)}`;
            },
            categoryName: function() {
                return `${this.item.product.category.name.charAt(0).toUpperCase()}${this.item.product.category.name.slice(1)}`;
            },
        }
    }
</script>