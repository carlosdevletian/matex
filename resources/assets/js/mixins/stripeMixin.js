export const stripeMixin = {
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
                amount: this.totalPrice,
                email: Matex.signedIn ? Matex.email : this.address.email,
                // image: '/img/checkout-icon.png',
                token: this.purchaseOrder,
            })
        },
        purchaseOrder(token) {
            axios.post(`/pay`, {
                email: token.email,
                payment_token: token.id,
                newAddress: this.address,
                selectedAddress: this.selectedAddress,
                items: this.items,
                design: this.design,
                total_price: this.totalPrice,
            }).then(response => {
                window.location = "/orders/" + response.data.order_reference_number;
            }).catch(response => {
                // this.processing = false
            })
        },
        pay: function() {
            if(this.canPay()){
                if(Matex.signedIn){
                    delete this.address.email;
                };
                this.openStripe();
            }else{
                swal({
                    title: 'An error occurred',
                    text: 'Please make sure you have some items in your order and an address is selected',
                    type: 'error',
                    showConfirmButton: true
                }).catch(swal.noop);
                this.address.show_errors = true;
            }
        }
    },
    created: function() {
        this.stripeHandler = this.initStripe()
    }
}
