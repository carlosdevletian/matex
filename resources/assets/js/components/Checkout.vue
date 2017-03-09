<template>
    <form action="#" method="POST">
        <input type="hidden" name="stripeToken" v-model="stripeToken">
        <input type="hidden" name="stripeEmail" v-model="stripeEmail">

        <button type="submit" class="Button--checkout box-shadow mg-btm-20" @click.prevent="buy">Checkout</button>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                stripeEmail: '',
                stripeToken: '',
            };
        },
        created() {
            this.stripe = StripeCheckout.configure({
                key: Matex.stripeKey,
                image: "https://stripe.com/img/documentation/checkout/marketplace.png",
                locale: "auto",
                panelLabel: "Pay For",
                token: (token) => {
                    this.stripeToken = token.id;
                    this.stripeEmail = token.email;
                    axios.post('/pay', this.$data)
                        .then(
                            response => alert('Complete! Thanks for your payment!'),
                        )
                }
            });
        },
        methods: {
            buy() {
                this.$emit('pay', this.stripe)
            }
        }
    }
</script>