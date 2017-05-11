<template>
    <order-template>
        <p slot="items-title">Ordered items</p>
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
                <item-show :item="item"></item-show>
            </div>
        </div>
        <div slot="subtotal">$ {{ order.subtotal | inDollars }}</div>
        <div slot="shipping">$ {{ order.shipping | inDollars }}</div>
        <div slot="tax">$ {{ order.tax | inDollars }}</div>
        <div slot="total">$ {{ order.total | inDollars }}</div>
        <p slot="address-title">Shipping address</p>
        <div slot="address-picker">
            <div class="col-xs-12"><p>Name: {{ address.name }}</p></div>
            <div class="col-xs-12"><p>Street: {{ address.street }}</p></div>
            <div class="col-xs-12"><p>City: {{ address.city }}</p></div>
            <div class="col-xs-12"><p>State: {{ address.state }}</p></div>
            <div class="col-xs-12"><p>Zip: {{ address.zip }}</p></div>
            <div class="col-xs-12"><p>Phone Number: {{ address.phone_number }}</p></div>
            <div v-show="address.comment" class="col-xs-12">User comment: {{ address.comment }}</div>
        </div>
    </order-template>
</template>

<script>
    export default {
        props: ['order', 'items', 'address'],
    }
</script>
