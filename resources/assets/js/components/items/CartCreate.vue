<template>
    <div>
        <div class="borderless position-relative">
            <table class="table borderless mg-0">
                <tbody>
                    <tr>
                        <td class="col-xs-7">
                            <div class="row position-relative">
                                <div class="col-xs-4">
                                    <a @click="deleteItem" role="button" class="Item__delete" style="position: absolute; top: 25%;left: 0;">&#10005;</a>
                                    <a role="button" @click="openImage">
                                        <img class="img-responsive margin-auto" :src="'images/' + item.design.image_name" style="height: 40px; width: 40px; border-radius: 5px 5px 5px 5px">
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
                            <div class="position-relative">
                                <input type="number"
                                v-model="item.quantity"
                                @change="updateItem"
                                class="Form borderless pd-0 text-center"
                                onfocus="if(this.value == '0') { this.value = ''; }"
                                v-bind:class="{ 'Form--error' : this.error }"
                                :disabled="processing">
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
                    this.editEnabled();
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
            },
        }
    }
</script>