export const stripeMixin = {
    data: function() {
        return {
            stripeHandler: null,
            paying: false,
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
                description: 'Your order',
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
            // window.onbeforeunload = this.leaving;

            swal({
                title: 'Processing Payment',
                customClass: 'Modal',
                text: 'Please wait until your payment is confirmed',
                type: 'info',
                showConfirmButton: false,
                allowEscapeKey : false,
                allowOutsideClick : false,
            }).catch(swal.noop)

            axios.post(`/pay`, {
                payment_token: token.id,
                newAddress: this.address,
                selectedAddress: this.selectedAddress,
                items: this.items,
                design: this.design,
                total_price: this.totalPrice,
                category_id: this.categoryId ? this.categoryId : '',
            }).then(response => {
                // window.onbeforeunload = null;
                window.location = response.data.order_url;
            }).catch(error => {
                // console.log(error.response);
                window.location = error.response.data.order_url;
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
                    title: "<h2 class='Order__title--orange'>An error occurred</h2>",
                    html: "<p style='font-size: 12pt'>Please make sure you have some items in your order and an address is selected</p>",
                    type: 'error',
                    showConfirmButton: true,
                    confirmButtonClass: 'Button--secondary box-shadow stick-to-bottom',
                    confirmButtonText: '<p class="mg-0">Got it!</p>',
                    buttonsStyling: false,
                    customClass: 'Modal'
                }).catch(swal.noop);
                this.address.show_errors = true;
            }
        }
        // Si quieres probar lo de evitar que la persona se vaya tienes que descomentar las lineas 29, 49, borrar la 76 y descomentar de la 77 a la 79
        // },
        // leaving: function(){
        //     return "Your order is processing";
        // }
    },
    created: function() {
        this.stripeHandler = this.initStripe();
    }
}
