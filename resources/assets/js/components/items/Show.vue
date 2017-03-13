<template>
    <div>
        <div class="borderless">
            <table class="table borderless mg-0">
                <tbody>
                    <tr>
                        <td class="col-xs-7">
                            <div class="row">
                                <div class="col-xs-4">
                                    <a role="button" @click="openImage">
                                        <img class="img-responsive margin-auto" :src="'/images/' + item.design.image_name" style="height: 40px; width: 40px; border-radius: 5px 5px 5px 5px">
                                    </a>
                                </div>
                                <div class="col-xs-8">
                                    <p>
                                        {{ item.product.name }} {{ item.product.category.name }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="col-xs-3">
                            <p class="text-center">{{ item.quantity }}</p>
                        </td>
                        <td class="col-xs-2">
                            <p class="text-center">$ {{ item.unit_price | inDollars }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['item'],
        methods: {
            openImage: function() {
                Event.$emit('open-image', this.item.design)
            }
        }
    }
</script>