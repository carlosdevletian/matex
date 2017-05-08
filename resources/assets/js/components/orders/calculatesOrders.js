export const calculatesOrders = {
    data: function() {
        return {
            amountsLoading: false,
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
                country: 'United States',
                phone_number: '',
                comment: '',
                is_valid: false,
                show_errors: false
            },
        }
    },
    methods: {
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
            if(this.zipIsValid && this.totalQuantity() > 0) {
                var data = {
                    zip: this.address.zip
                }
                axios.post('/calculateTax', data).then((response) => {
                    this.tax = (this.subtotal + this.shipping) * response.data.tax_percentage;
                });
            } else {
                this.tax = 0;
            }
            this.amountsLoading = false;
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
    computed: {
        zipIsValid: function() {
            return this.address.zip.length == 5;
        },
        calculatedSubtotal: function() {
            this.amountsLoading = true;
            this.subtotal = 0;
            var vm = this;
            this.items.forEach(function(item) {
                vm.subtotal = (vm.subtotal + +item.total_price);
            });
            this.amountsLoading = false;
            return this.subtotal;
        },
        totalPrice: function() {
            if (this.totalQuantity() >0) {
                return (this.subtotal + this.shipping + this.tax);
            }
            return 0;
        },
        filteredShipping: function() {
            if(this.zipIsValid && this.calculatedSubtotal > 0) {
                return '$' + (this.shipping / 100).toLocaleString('en-US', { minimumFractionDigits: 2 });
            }
            return '-';
        },
        filteredTax: function() {
            if(this.zipIsValid && this.calculatedSubtotal > 0) {
                return '$' + (this.tax / 100).toLocaleString('en-US', { minimumFractionDigits: 2 });
            }
            return '-';
        },
        filteredTotal: function() {
            if(this.zipIsValid) {
                return '$' + (this.totalPrice / 100).toLocaleString('en-US', { minimumFractionDigits: 2 });
            }
            return '-';
        }
    }
}
