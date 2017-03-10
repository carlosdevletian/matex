<template>
    <div>
        <div class="table-responsive borderless">
            <table class="table borderless mg-0">
                <tbody>
                    <tr>
                        <td class="col-xs-1">
                            <a @click="deleteItem" role="button" class="Item__delete">&#10005;</a>
                        </td>
                        <td class="col-xs-3">
                            <a role="button" @click="openImage">
                                <img class="img-responsive" :src="'images/' + item.design.image_name" style="margin-top: 8px">
                            </a>
                        </td>
                        <td class="col-xs-3">
                            <div class="position-relative">
                                <input type="number"
                                v-model="item.quantity"
                                @change="updateItem"
                                class="Form pd-0"
                                onfocus="if(this.value == '0') { this.value = ''; }"
                                v-bind:class="{ 'Form--error' : this.error }"
                                :disabled="processing"
                                autofocus>
                                <i v-show="processing" class="fa fa-spinner fa-spin Spinner"></i>
                            </div>
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
                processing: false,
            }
        },
        methods: {
            updateItem: function () {
                this.processing = true;
                this.validateQuantity();
                axios.put('/items/' + this.item.id, this.item).then((response) => {
                    this.$emit('item-updated', response.data);
                    this.processing = false;
                });
            },
            validateQuantity: function() {
                if(this.item.quantity < 1 || this.item.quantity % 1 != 0) {
                    this.error = 'To delete, press the X button';
                    this.item.quantity = 1;
                    this.processing = false;
                    return;
                }
                this.error = '';
            },
            deleteItem: function() {
                this.processing = true;
                this.$emit('delete-item', this.item.id);
            },
            openImage: function() {
                Event.$emit('open-image', this.item.design)
            }
        }
    }
</script>