<template>
    <order-template>
        <p slot="items-title">Choose your sizes</p>
        <div slot="products">
             <div class="row">
                <div class="col-xs-12">
                    <div v-for="product in sortedProducts" style="display: inline">
                        <button @click="createItem(product)" class="Button--product">{{ product.name }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="items.length > 0" slot="table-header" class="borderless">
            <div v-show="productList.length != 0">
                <hr>
            </div>
            <table class="table borderless mg-0">
                <tbody>
                    <tr>
                        <td class="col-xs-7">
                            <p>Items</p>
                        </td>
                        <td class="col-xs-3">
                            <p class="visible-xs-block">Qty</p>
                            <p class="hidden-xs">Quantity</p>
                        </td>
                        <td class="col-xs-2">
                            <p>Price</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div slot="items">
            <div v-for="item in sortedItems">
                <item-create :item="item" @delete-item="deleteItem" @item-updated="updateItem">
                </item-create>
            </div>
        </div>
        <div slot="spinner">
            <i v-show="amountsLoading" class="fa fa-spinner fa-spin Spinner"></i>
        </div>
        <div slot="subtotal">$ {{ calculatedSubtotal | inDollars }}</div>
        <div slot="zip-error">
            <div class="row" v-show="! zipIsValid">
                <div class="col-xs-12 text-center color-secondary">
                    <hr>
                    An address must be entered to calculate shipping and tax
                    <hr>
                </div>
            </div>
        </div>
        <div slot="shipping">{{ filteredShipping }}</div>
        <div slot="tax">{{ filteredTax }}</div>
        <div slot="total">{{ filteredTotal }}</div>
        <p slot="address-title">Select a shipping address</p>
        <div slot="address-picker">
            <address-picker
                :existing-addresses="addresses"
                :address="address"
                @update-selected-address="updateSelectedAddress">
            </address-picker>
        </div>
        <div slot="buttons">
            <div class="col-xs-6">
                <button v-if="signedIn"
                    @click="addToCart"
                    class="Button--secondary box-shadow mg-btm-20 no-wrap"
                    >Add to cart</button>
            </div>
            <div class="col-xs-6" :class="{ 'col-xs-offset-3': !signedIn }">
                <button @click="pay"
                    class="Button--primary box-shadow mg-btm-20"
                    >Checkout</button>
            </div>
        </div>
    </order-template>
</template>

<script>
    import { stripeMixin } from '../../mixins/stripeMixin';
    import { calculatesOrders } from './calculatesOrders';

    export default {
        mixins: [stripeMixin, calculatesOrders],
        props: ['products', 'design', 'addresses', 'categoryId'],
        data: function() {
            return {
                items: [],
                productList: this.products,
                signedIn: Matex.signedIn,
            }
        },
        methods: {
            createItem: function(product) {
                this.removeProduct(product.id);
                var item = {
                    product_id : product.id,
                    product : product,
                    design_id : this.design,
                    quantity : 0,
                    unit_price : 0,
                    total_price : 0,
                }
                this.items.push(item);
            },
            removeProduct: function(productId) {
                var vm = this;

                this.productList.forEach( function(product, index){
                    if(product.id == productId){
                        vm.productList.splice(index, 1);
                    }
                });
            },
            deleteItem: function(productId) {
                var vm = this;
                this.items.forEach( function(item, index){
                    if(item.product.id == productId){
                        vm.productList.push(item.product);
                        vm.items.splice(index, 1);
                    }
                });
            },
            updateItem: function(updatedItem) {
                var vm = this;
                this.items.forEach( function(originalItem, index){
                    if(originalItem.product_id == updatedItem.product_id){
                        vm.items.splice(index, 1);
                        vm.items.push(updatedItem);
                    }
                });
            },
            addToCart: function() {
                if(this.totalQuantity() > 0) {
                    axios.post('/addToCart', this.items).then((response) => { 
                        swal({
                            title: 'Items added successfully',
                            customClass: 'Modal',
                            text: 'The items were added to your Cart',
                            type: 'success',
                            timer: 2500,
                            showConfirmButton: false
                        }).catch(swal.noop);

                        setTimeout("window.location = '/dashboard'", 2500); 
                    });
                }else{
                    swal({
                        title: 'An error occurred',
                        customClass: 'Modal',
                        text: 'Select some items to add to the cart',
                        type: 'error',
                        timer: 1900,
                        showConfirmButton: false
                    }).catch(swal.noop);
                }
            },
        },
        computed:  {
            sortedItems: function() {
                return this.items.sort(function(a,b){
                    return a.product.display_position - b.product.display_position;
                })
            },
            sortedProducts: function() {
                return this.productList.sort(function(productA,productB){
                    return productA.display_position - productB.display_position;
                })
            },
        }
    }
</script>