<template>
    <div>
        <div v-show="unavailableItems.length > 0" style="display: flex; justify-content: center">
            <div class="Card text-center" style="display: inline-block">
                <p v-if="! showUnavailable" class="mg-0">
                    Looks like some of your selected items are unavailable...
                    <a role="button" @click="showUnavailable = true">See unavailable items</a>
                </p>
                <a v-else role="button" @click="showUnavailable = false">Back</a>
            </div>
        </div>
        <div v-if="unavailableItems.length > 0 && showUnavailable">
            <div class="Card Card--double-pd col-sm-6 col-sm-offset-3">
                <div class="row">
                    <div class="Order__title--orange text-center">
                        Unavailable items
                    </div>
                </div>
                <div class="row"><hr></div>
                <div class="borderless">
                    <table class="table borderless mg-0">
                        <tbody>
                            <tr>
                                <td class="col-xs-7 col-sm-5">
                                    <p class="text-center mg-0">Items</p>
                                </td>
                                <td class="hidden-xs col-sm-2">
                                    <p class="text-center mg-0">Size</p>
                                </td>
                                <td class="col-xs-3">
                                    <p class="text-center mg-0 visible-xs-block">Qty</p>
                                    <p class="text-center mg-0 hidden-xs">Quantity</p>
                                </td>
                                <td class="col-xs-2">
                                    <p class="text-center mg-0">Price</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-for="item in unavailableItems">
                    <item-cart-create :item="item" @delete-item="deleteUnavailableItem" @item-updated="updateItem" :key="item.id">
                    </item-cart-create>
                </div>
            </div>
        </div>
        <div v-if="items.length > 0 && ! showUnavailable">
            <order-template>
                <p slot="items-title">Your items</p>
                <div slot="table-header" class="borderless">
                    <table class="table borderless mg-0">
                        <tbody>
                            <tr>
                                <td class="col-xs-7 col-sm-5">
                                    <p class="text-center mg-0">Items</p>
                                </td>
                                <td class="hidden-xs col-sm-2">
                                    <p class="text-center mg-0">Size</p>
                                </td>
                                <td class="col-xs-3">
                                    <p class="text-center mg-0 visible-xs-block">Qty</p>
                                    <p class="text-center mg-0 hidden-xs">Quantity</p>
                                </td>
                                <td class="col-xs-2">
                                    <p class="text-center mg-0">Price</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div slot="items">
                    <div v-for="item in items">
                        <item-cart-create :item="item" @delete-item="deleteItem" @item-updated="updateItem" :key="item.id">
                        </item-cart-create>
                    </div>
                </div>
                <div slot="spinner">
                    <i v-show="amountsLoading" class="fa fa-spinner fa-spin Spinner"></i>
                </div>
                <div slot="subtotal">${{ calculatedSubtotal | inDollars }}</div>
                <div slot="zip-error">
                    <div class="row" v-show="! stateSelected">
                        <div class="col-xs-12 text-center color-secondary">
                            <hr>
                            An address must be entered to calculate tax
                            <hr>
                        </div>
                    </div>
                </div>
                <div slot="shipping">Free</div>
                <div slot="tax">{{ filteredTax }}</div>
                <div slot="total">{{ filteredTotal }}</div>
                <div slot="hidden-total">{{ filteredTotal }}</div>
                <p slot="address-title">Select a shipping address</p>
                <div slot="address-picker">
                    <address-picker
                        :existing-addresses="addresses"
                        :address="address"
                        @update-selected-address="updateSelectedAddress">
                    </address-picker>
                </div>
                <div slot="buttons">
                    <div class="row">
                        <div class="col-xs-12  col-sm-6 col-sm-offset-3">
                            <button @click="pay"
                            class="Button--secondary box-shadow mg-btm-20"
                            >Checkout</button>
                        </div>
                    </div>
                </div>
            </order-template>
        </div>
        <div v-if="items.length <= 0 && unavailableItems.length <= 0" class="Card">
            There are no items in your cart.
        </div>
    </div>
</template>

<script>
    import { stripeMixin } from '../../mixins/stripeMixin';
    import { calculatesOrders } from './calculatesOrders';

    export default {
        mixins: [stripeMixin, calculatesOrders],
        props: ['addresses', 'originalItems', 'originalUnavailableItems'],
        data: function() {
            return {
                items: this.originalItems,
                unavailableItems: this.originalUnavailableItems,
                showUnavailable: false,
            }
        },
        methods: {
            deleteItem: function(itemId) {
                var vm = this;

                axios.delete('/items/' + itemId).then((response) => {
                    this.items.forEach(function(item, index){
                        if(item.id == itemId){
                            vm.items.splice(index, 1);
                        }
                    });
                    Event.$emit('item-deleted');
                });
            },
            deleteUnavailableItem: function(itemId) {
                var vm = this;
                axios.delete('/items/' + itemId).then((response) => {
                    this.unavailableItems.forEach(function(item, index){
                        if(item.id == itemId){
                            vm.unavailableItems.splice(index, 1);
                        }
                    });
                    if(this.unavailableItems.length == 0) this.showUnavailable = false;
                });
            },
            updateItem: function(updatedItem) {
                var vm = this;
                this.items.forEach(function(originalItem, index) {
                    if(updatedItem.id == originalItem.id) {
                        originalItem.quantity = updatedItem.quantity;
                        originalItem.unit_price = updatedItem.unit_price;
                        originalItem.total_price = updatedItem.total_price;
                    }
                });
            },
        },
    }
</script>


<style type="text/css">
    .left {
        left: 0;
    }
</style>
