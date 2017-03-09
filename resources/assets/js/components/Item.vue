<template>
    <div>
        <div class="table-responsive">
            <table class="table borderless mg-0">
                <tbody>
                    <tr>
                        <td class="col-xs-1">
                            <a @click="deleteItem" role="button" class="Item__delete">&#10005;</a>
                        </td>
                        <td class="col-xs-3">{{ item.product.name }}</td>
                        <td class="col-xs-3">
                            <input type="number"
                            v-model="item.quantity"
                            @change="updatePrice"
                            class="Form pd-0"
                            onfocus="if(this.value == '0') { this.value = ''; }"
                            v-bind:class="{ 'Form--error' : this.error }"
                            autofocus>
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
        data: function () {
            return {
                error: '',
            }
        },
        methods: {
            updatePrice: function () {
                this.validateQuantity();
                axios.post('/calculatePrice', this.item).then((response) => {
                    this.item.unit_price = response.data.unit_price;
                    this.item.total_price = response.data.total_price;
               });
            },
            validateQuantity: function() {
                if(this.item.quantity < 1 || this.item.quantity % 1 != 0) {
                    this.error = 'Input a valid quantity';
                    this.item.quantity = 0;
                    return;
                }
                this.error = '';
            },
            deleteItem: function() {
                this.$emit('delete-item', this.item.product.id);
            }
        }
    }
</script>
