<template>
    <order-template>
        <div slot="items-title">Ordered items</div>
        <div slot="table-header" class="table-responsive borderless">
            <table class="table borderless mg-0">
                <tbody>
                    <tr>
                        <td class="pd-0 col-xs-7">
                                <p class="text-center mg-0">Items</p>
                        </td>
                        <td class="pd-0 col-xs-3">
                                <p class="text-center mg-0 visible-xs-block">Qty</p>
                                <p class="text-center mg-0 hidden-xs">Quantity</p>
                        </td>
                        <td class="pd-0 col-xs-2">
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
        <div slot="address-title">Shipping address</div>
        <div slot="address-picker">
            <div class="col-xs-12"><h5>Name: {{ address.name }}</h5></div>
            <div class="col-xs-12"><h5>Street: {{ address.street }}</h5></div>
            <div class="col-xs-12"><h5>City: {{ address.city }}</h5></div>
            <div class="col-xs-12"><h5>State: {{ address.state }}</h5></div>
            <div class="col-xs-12"><h5>Zip: {{ address.zip }}</h5></div>
            <div class="col-xs-12"><h5>Phone Number: {{ address.phone_number }}</h5></div>
            <div v-show="address.comment" class="col-xs-12">User comment: {{ address.comment }}</div>
        </div>
    </order-template>
</template>

<script>
    export default {
        props: ['order', 'items', 'address'],
    }
</script>
