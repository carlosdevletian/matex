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
                                        {{ productName() }} 
                                        {{ categoryName() }} 
                                        ({{ item.product.width + 'x' + item.product.length }}) 
                                        {{ item.accessory_id != null ? 'with ' + item.accessory.name : '' }}
                                    </p>
                                    <a role="button" @click="addAccessory" class="color-primary" v-if="item.accessory_id == null">Add an accessory</a>
                                    <a v-else role="button" @click="addAccessory" class="color-primary">Change accessory</a>
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
                                    :disabled="processing">
                                <i v-show="processing" class="fa fa-spinner fa-spin Spinner"></i>
                            </div>
                        </td>
                        <td class="col-xs-2">
                            <p class="text-center no-wrap">${{ item.unit_price | inDollars }}</p>
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
            <add-accessory v-if="showModal" 
                            :product="item.product"
                            :selected-accessory="item.accessory"
                            @close="showModal = false" 
                            @accessory-selected="assignAccessory"></add-accessory>
        </div>
    </div>
</template>

<script>
    import { updatesItems } from './updatesItems';
    export default {
        mixins: [updatesItems],
        props: ['item'],
        data: function () {
            return {
                imageUrl: {
                    backgroundImage : `url(/images/${this.item.design.image_name}/1)`,
                    height: '40px !important',
                }
            }
        },
        methods: {
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