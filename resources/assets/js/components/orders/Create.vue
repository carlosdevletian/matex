<template>
    <order-template>
        <p slot="items-title">Choose your sizes</p>
        <div slot="products">
             <div class="row">
                <div class="col-xs-12">
                    <div v-for="product in sortedProducts()" style="display: inline">
                        <button @click="createItem(product)" class="Button--product">{{ product.name }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="items.length > 0" slot="table-header" class="table-responsive borderless">
            <div v-show="products.length != 0">
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
                <item-create :item="item" @delete-item="deleteItem">
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
                    class="Button--secondary box-shadow mg-btm-20"
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

    export default {
        mixins: [stripeMixin],
        props: ['products', 'design', 'addresses', 'categoryId'],
        data: function() {
            return {
                amountsLoading: false,
                items: [],
                subtotal: 0,
                shipping: 0,
                tax: 0,
                selectedAddress: 0,
                address: {
                    email: '',
                    name: '',
                    street: '',
                    city: '',
                    state: '',
                    zip: '',
                    country: '',
                    phone_number: '',
                    comment: '',
                    is_valid: false,
                    show_errors: false
                },
                signedIn: Matex.signedIn,
            }
        },
        methods: {
            createItem: function(product) {
                var item = {
                    product : product,
                    design_id: this.design,
                    quantity: 0,
                    unit_price: 0,
                    total_price: 0,
                };

                this.items.push(item);

                this.removeProduct(product.id);
            },
            removeProduct: function(productId) {
                var vm = this;

                this.products.forEach( function(product, index){
                    if(product.id == productId){
                        vm.products.splice(index, 1);
                    }
                });
            },
            deleteItem: function(productId) {
                var vm = this;
                this.items.forEach( function(item, index){
                    if(item.product.id == productId){
                        vm.products.push(item.product);
                        vm.items.splice(index, 1);
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
            totalQuantity: function() {
                var total = 0;

                this.items.forEach( function(item){
                    total = total + item.quantity;
                });

                return total;
            },
            updateSelectedAddress: function(data) {
                this.selectedAddress = data.id;
                this.address.zip = data.zip;
            },
            canPay: function() {
                return this.totalQuantity() > 0 && (this.address.is_valid || this.selectedAddress != 0);
            },
            calculateShipping: function() {
                if(this.zipIsValid) {
                    var data = {
                        zip: this.address.zip
                    }
                    axios.post('/calculateShipping', data).then((response) => {
                        this.shipping = response.data.shipping;
                    });
                }
                this.amountsLoading = false;
            },
            calculateTax: function() {
                if(this.zipIsValid) {
                    var data = {
                        zip: this.address.zip
                    }
                    axios.post('/calculateTax', data).then((response) => {
                        this.tax = (this.subtotal + this.shipping) * response.data.tax_percentage;
                    });
                }
                this.amountsLoading = false;
            },
            sortedProducts: function() {
                return this.products.sort(function(productA,productB){
                    return productA.display_position - productB.display_position;
                })
            },
        },
        watch: {
            'address.zip': function (getShippingAndTax) {
                this.amountsLoading = true;
                this.calculateShipping();
            },
            shipping: function() {
                this.amountsLoading = true;
                this.calculateTax();
            },
            subtotal: function (getTax) {
                this.amountsLoading = true;
                this.calculateTax();
            }
        },
        computed:  {
            zipIsValid: function() {
                return this.address.zip.length == 5;
            },
            calculatedSubtotal: function() {
                this.amountsLoading = true;
                this.subtotal = 0;
                var vm = this;
                this.items.forEach(function(item) {
                    vm.subtotal = (vm.subtotal + item.total_price);
                });
                this.amountsLoading = false;
                return this.subtotal;
            },
            totalPrice: function() {
                if (this.items.length >0) {
                    return (this.subtotal + this.shipping + this.tax);
                }
                return 0;
            },
            sortedItems: function() {
                return this.items.sort(function(a,b){
                    return a.product.display_position - b.product.display_position;
                })
            },
            filteredShipping: function() {
                if(this.zipIsValid && this.calculatedSubtotal > 0) {
                    return '$ ' + (this.shipping / 100).toLocaleString('en-US');
                }
                return '-';
            },
            filteredTax: function() {
                if(this.zipIsValid && this.calculatedSubtotal > 0) {
                    return '$ ' + (this.tax / 100).toLocaleString('en-US');
                }
                return '-';
            },
            filteredTotal: function() {
                if(this.zipIsValid) {
                    return '$ ' + (this.totalPrice / 100).toLocaleString('en-US');
                }
                return '-';
            }
        }
    }
</script>