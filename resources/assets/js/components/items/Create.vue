<template>
    <div>
        <div class="borderless position-relative">
            <table class="table borderless mg-0">
                <tbody>
                    <tr>
                        <td class="col-xs-7">
                            <div class="row position-relative">
                                <div class="col-xs-12">
                                    <a @click="deleteItem" role="button" class="Item__delete" style="position: absolute; top: 3%;left: 0;">&#10005;</a>
                                    <p class="color-secondary">{{ productName() }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="col-xs-3">
                            <div class="position-relative">
                                <input type="number"
                                    v-model="item.quantity"
                                    @change="updateItem"
                                    class="Form text-center pd-0"
                                    onfocus="if(this.value == '0') { this.value = ''; }"
                                    v-bind:class="{ 'Form--error' : this.error }"
                                    :disabled="processing"
                                    :key="item.product.id"
                                    v-focus>
                                <i v-show="processing" class="fa fa-spinner fa-spin Spinner"></i>
                            </div>
                        </td>
                        <td class="col-xs-2">
                            <p class="text-center no-wrap">${{ item.unit_price | inDollars }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import { updatesItems } from './updatesItems';
    export default {
        mixins: [updatesItems],
        props: ['item'],
    }
</script>