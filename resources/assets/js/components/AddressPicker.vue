<template>
    <div>
        <div v-show="existingAddresses.length > 0 && ! showAddressForm" class="row">
            <div class="col-xs-12">
                <div v-for="existingAddress in existingAddresses" v-bind:class="{ selected : isSelected(existingAddress.id) }">
                    <h4>{{ existingAddress.name }}</h4>
                    <h4>{{ existingAddress.street }}</h4>
                    <h4>{{ existingAddress.city }}</h4>
                    <button class="btn btn-default" @click="updateSelectedAddress(existingAddress.id)">Select</button>
                </div>
                <button class="btn btn-default" @click="toggleAddressForm">Create New Address</button>
            </div>
        </div>
        <div v-show="! signedIn || showAddressForm" class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <button class="btn btn-default" v-show="existingAddresses.length > 0 && signedIn" @click="showAddressForm = ! showAddressForm">Select an Address</button>
                    
                    <label for="email" class="control-label error" v-show="!validation.email && address.show_errors">Please enter a valid email</label>
                    <input class="form-control mb-8" type="email" v-model="address.email" placeholder="Email">

                    <label for="name" class="control-label error" v-show="!validation.name  && address.show_errors">Please enter a valid name</label>
                    <input class="form-control mb-8" type="text" v-model="address.name" placeholder="Name">

                    <label for="street" class="control-label error" v-show="!validation.street  && address.show_errors">Please enter a valid street</label>
                    <input class="form-control mb-8" type="text" v-model="address.street" placeholder="Street">

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="city" class="control-label error" v-show="!validation.city  && address.show_errors">Please enter a valid city</label>
                            <input class="form-control mb-8" type="text" v-model="address.city" placeholder="City">
                        </div>
                        <div class="col-sm-6">
                            <label for="state" class="control-label error" v-show="!validation.state  && address.show_errors">Please enter a valid state</label>
                            <input class="form-control mb-8" type="text" v-model="address.state" placeholder="State">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="zip" class="control-label error" v-show="!validation.zip  && address.show_errors">Please enter a valid zip</label>
                            <input class="form-control mb-8" type="text" v-model="address.zip" placeholder="Zip Code">
                        </div>
                        <div class="col-sm-6">
                            <label for="country" class="control-label error" v-show="!validation.country  && address.show_errors">Please enter a valid country</label>
                            <input class="form-control mb-8" type="text" v-model="address.country" placeholder="Country">
                        </div>
                    </div>
                    <label for="phone_number" class="control-label error" v-show="!validation.phone_number  && address.show_errors">Please enter a valid phone number</label>
                    <input class="form-control mb-8" type="text" v-model="address.phone_number" placeholder="Phone Number">
                    <textarea class="form-control mb-8" v-model="address.comment" placeholder="Comment"></textarea>
                    <div v-show="false">{{ validatedAddress }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    var emailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

    export default {
        props: ['address', 'existingAddresses'],
        data: function() {
            return {
                signedIn: Matex.signedIn,
                showAddressForm: false,
                selected: 0,
            }
        },
        methods: {
            updateSelectedAddress: function(id) {
                this.selected = id;
                this.$emit('update-selected-address', this.selected);
            },
            isSelected: function(addressId) {
                return this.selected == addressId;
            },
            toggleAddressForm: function() {
                if(this.showAddressForm) {
                    this.showAddressForm = false;
                }else {
                    this.showAddressForm = true;
                    this.updateSelectedAddress(0);
                }
            }
        },
        computed: {
            validation: function() {
                return {
                    email: !! emailRegex.test(this.address.email) && this.address.email != '',
                    name: !! this.address.name != '',
                    street: !! this.address.street != '',
                    city: !! this.address.city != '',
                    state: !! this.address.state != '',
                    zip: !! this.address.zip != '',
                    country: !! this.address.country != '',
                    phone_number: !! this.address.phone_number != '',
                }
            },
            validatedAddress: function() {
                var vm = this;
                this.address.is_valid = true;
                for (var field in this.validation) {      
                    if(! vm.validation[field]){
                        vm.address.is_valid = false;
                        break;
                    }
                }
                return this.address.is_valid;
            },
        }
    }
</script>

<style>
    .mb-8 {
        margin-bottom: 8px
    }
    .error {
        color: red;
    }
    .selected {
        background-color: yellow;
    }
</style>
