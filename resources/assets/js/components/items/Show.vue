<template>
    <div>
        <div class="table-responsive borderless">
            <table class="table borderless mg-0">
                <tbody>
                    <tr>
                        <td class="col-xs-4">
                            <a role="button" @click="openImage">
                                <img class="img-responsive" :src="'/images/' + item.design.image_name" style="margin-top: 8px">
                            </a>
                        </td>
                        <td class="col-xs-3">
                            {{ item.quantity }}
                        </td>
                        <td class="col-xs-2">
                            $ {{ item.unit_price | inDollars }}
                        </td>
                        <td class="col-xs-3">
                            $ {{ item.total_price | inDollars }}
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