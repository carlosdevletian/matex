<template>
    <div>
        <div class="borderless position-relative">
            <table class="table borderless mg-0">
                <tbody>
                    <tr>
                        <td class="col-xs-7">
                            <div class="row position-relative">
                                <div class="col-xs-4">
                                    <a @click="deleteItem" role="button" class="Item__delete" style="position: absolute; top: 25%;left: -5%;">&#10005;</a>
                                    <a role="button" @click="openImage">
                                        <div class="background-image Thumbnail--image box-shadow" 
                                            :style="imageUrl">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-8">
                                    <p>
                                        {{ productName() }} {{ categoryName() }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="col-xs-3">
                            <div class="position-relative">
                                <input type="number"
                                    v-model="item.quantity"
                                    @change="updateItem"
                                    class="Form pd-0 text-center"
                                    onfocus="if(this.value == '0') { this.value = ''; }"
                                    v-bind:class="{ 'Form--error' : this.error }"
                                    :disabled="processing">
                                <i v-show="processing" class="fa fa-spinner fa-spin Spinner"></i>
                            </div>
                        </td>
                        <td class="col-xs-2">
                            <p class="text-center no-wrap">$ {{ item.unit_price | inDollars }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-show="!isAvailable()" 
                style="background-color: rgb(255,255,255, 0); 
                    position: absolute; 
                    width: 100%; 
                    height: 100%; 
                    top: 0;">
            </div>
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
                imageUrl: {
                    backgroundImage : `url(/images/${this.item.design.image_name}/1)`,
                    height: '40px !important',
                }
            }
        },
        methods: {
            updateItem: function () {
                this.processing = true;
                if(! this.quantityIsValid()) {
                    this.error = 'Please input a valid quantity';
                    this.item.quantity = 1;
                } else {
                    this.error = '';
                }
                axios.put('/items/' + this.item.id, {
                    item: this.item
                }).then((response) => {
                    this.$emit('item-updated', response.data.item);
                    Event.$emit('item-updated', response.data.item);
                    this.processing = false;
                });
            },
            quantityIsValid: function() {
                return (this.item.quantity > 0 && this.item.quantity % 1 == 0);
            },
            deleteItem: function() {
                this.processing = true;
                this.$emit('delete-item', this.item.id);
                this.processing = false;
            },
            productName: function() {
                return `${this.item.product.name.charAt(0).toUpperCase()}${this.item.product.name.slice(1)}`;
            },
            categoryName: function() {
                return `${this.item.product.category.name.charAt(0).toUpperCase()}${this.item.product.category.name.slice(1)}`;
            },
            isAvailable: function() {
                return !! +this.item.available;
            },
            openImage: function() {
                Event.$emit('open-image', this.item.design)
            },
        }
    }
</script>