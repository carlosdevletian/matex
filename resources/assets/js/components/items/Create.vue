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
                                    <p class="text-center color-secondary">{{ item.product.name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="col-xs-3">
                            <div class="position-relative">
                                <input type="number"
                                v-model="item.quantity"
                                @change="updatePrice"
                                class="Form pd-0 text-center"
                                onfocus="if(this.value == '0') { this.value = ''; }"
                                v-bind:class="{ 'Form--error' : this.error }"
                                :disabled="processing"
                                autofocus>
                                <i v-show="processing" class="fa fa-spinner fa-spin Spinner"></i>
                            </div>
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
        data: function () {
            return {
                error: '',
                processing: false,
            }
        },
        methods: {
            updatePrice: function () {
                this.processing = true;
                this.validateQuantity();
                axios.post('/calculatePrice', this.item).then((response) => {
                    this.item.unit_price = response.data.unit_price;
                    this.item.total_price = response.data.total_price;
                    this.processing = false;
               });
            },
            validateQuantity: function() {
                if(this.item.quantity < 1 || this.item.quantity % 1 != 0) {
                    this.error = 'Input a valid quantity';
                    this.item.quantity = 0;
                    this.processing = false;
                    return;
                }
                this.error = '';
            },
            deleteItem: function() {
                this.processing = true;
                this.$emit('delete-item', this.item.product.id);
            }
        }
    }
</script>
