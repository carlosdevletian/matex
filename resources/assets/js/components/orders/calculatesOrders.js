export const calculatesOrders = {
    data: function() {
        return {
            amountsLoading: false,
            subtotal: 0,
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
        calculateTax: function() {
            if(this.stateSelected && this.totalQuantity() > 0) {
                if(!! this.address.state) {
                    var data = { state: this.address.state }
                } else {
                    var data = { address_id : this. selectedAddress}
                }
                
                axios.post('/calculateTax', data).then((response) => {
                    this.tax = this.subtotal * response.data.tax_percentage;
                });
            } else {
                this.tax = 0;
            }
            this.amountsLoading = false;
        },
    },
    watch: {
        'address.state': function (getTax) {
            this.amountsLoading = true;
            this.calculateTax();
        },
        selectedAddress: function(getTax) {
            this.amountsLoading = true;
            this.calculateTax();
        },
        subtotal: function (getTax) {
            this.amountsLoading = true;
            this.calculateTax();
        }
    },
    computed: {
        stateSelected: function() {
            return (!! this.address.state || !! this.selectedAddress);
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
                return (this.subtotal + this.tax);
            }
            return 0;
        },
        filteredTax: function() {
            if(this.stateSelected && this.calculatedSubtotal > 0) {
                return '$' + (this.tax / 100).toLocaleString('en-US', { minimumFractionDigits: 2 });
            }
            return '-';
        },
        filteredTotal: function() {
            if(this.stateSelected) {
                return '$' + (this.totalPrice / 100).toLocaleString('en-US', { minimumFractionDigits: 2 });
            }
            return '-';
        }
    }
}
