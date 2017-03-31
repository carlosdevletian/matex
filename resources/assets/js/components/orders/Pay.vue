<template>
    <div>
        <button @click="pay"
            class="btn btn-default"
            >Checkout</button>
    </div>
</template>

<script>

    export default {
        props: ['order'],
        data: function() {
            return {
                stripeHandler: null,
            }
        },
        methods: {
            initStripe() {
                const handler = StripeCheckout.configure({
                    key: Matex.stripeKey
                })
                return handler
            },
            openStripe(callback) {
                this.stripeHandler.open({
                    name: 'Matex',
                    description: 'Bracelets',
                    currency: "usd",
                    allowRememberMe: false,
                    panelLabel: 'Pay {{amount}}',
                    amount: ++this.order.total,
                    email: Matex.signedIn ? Matex.email : this.order.email,
                    token: this.purchaseOrder,
                })
            },
            purchaseOrder(token) {
                swal({
                    title: 'Processing Payment',
                    customClass: 'Modal',
                    text: 'Please wait until your payment is confirmed',
                    type: 'info',
                    showConfirmButton: false
                }).catch(swal.noop)

                axios.post(`/retryPayment`, {
                    email: token.email,
                    payment_token: token.id,
                    order_id: this.order.id,
                }).then(response => {
                    window.location = "/orders/" + response.data.order_reference_number;
                }).catch(response => {
                    // this.processing = false
                })
            },
            pay: function() {
                this.openStripe();
            }
        },
        created: function() {
            this.stripeHandler = this.initStripe();
        }
    }
</script>
