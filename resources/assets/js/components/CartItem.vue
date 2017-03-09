<template>
    <div>
        <div class="table-responsive">
            <table class="table borderless mg-0">
                <tbody>
                    <tr>
                        <td class="col-xs-1">
                            <a @click="deleteItem" role="button" class="Item__delete">&#10005;</a>
                        </td>
                        <td class="col-xs-3"><img class="img-responsive" :src="'images/' + item.image_name" alt=""></td>
                        <td class="col-xs-3">
                            <input type="number"
                            v-model="item.quantity"
                            @change="updateItem"
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
            updateItem: function () {
                this.validateQuantity();
                axios.put('/items/' + this.item.id, this.item).then((response) => {
                    this.$emit('item-updated', response.data);
                });
            },
            validateQuantity: function() {
                if(this.item.quantity < 1 || this.item.quantity % 1 != 0) {
                    this.error = 'To delete, press the X button';
                    this.item.quantity = 1;
                    return;
                }
                this.error = '';
            },
            deleteItem: function() {
                this.$emit('delete-item', this.item.id);
            }
        }
    }
</script>
<style>
    .pd-0{
        padding: 0px;
    }
</style>
