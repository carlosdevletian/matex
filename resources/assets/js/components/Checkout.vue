<template>
    <form action="#" method="POST">
        <input type="hidden" name="stripeToken" v-model="stripeToken">
        <input type="hidden" name="stripeEmail" v-model="stripeEmail">

        <div class="form-group">
            <button type="submit" class="btn btn-primary" @click.prevent="buy">Pay</button>
        </div>
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