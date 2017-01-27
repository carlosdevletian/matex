<template>
    <div class="row">
        <h2 class="text-center">
            <div v-if="signedIn">
                <a v-if="addresses.length > 0" @click="showAddressForm=false">Select a shipping address or </a> 
                <a @click="showAddressForm=true" style="hover:click">Add a new shipping address</a>
            </div>
            <div v-else>
                <div class="row">
                    Your email here
                    <input type="text" v-model="email" class="text-center" @change="updateNewAddress">
                </div>
            </div>
        </h2>
        <div v-for="address in addresses" v-show="!showAddressForm">
            <div class="col-xs-4">
                <div class="panel panel-default" v-bind:class="{ selected : isSelected(address.id) }">
                    <div class="panel-heading">
                        {{ address.name }}
                    </div>
                    <div class="panel-body">
                        <div class="container">
                            <div class="row">ID: {{ address.id }}</div>
                            <div class="row">{{ address.street }}</div>
                            <div class="row">{{ address.city }}</div>
                            <div class="row">{{ address.state }}</div>
                            <div class="row">{{ address.zip }}</div>
                            <div class="row">{{ address.country }}</div>
                            <div class="row">{{ address.comment }}</div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button @click="select(address.id)" class="btn btn-primary">Select</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-xs-offset-3">
            <div v-show="shouldShowAddressForm" class="panel panel-default">
                <div class="panel-heading">
                    Add your shipping address
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        <input class="form-control" type="text" v-model="newAddress.name">
                        <label class="control-label">Street</label>
                        <input class="form-control" type="text" v-model="newAddress.street">
                        <label class="control-label">City</label>
                        <input class="form-control" type="text" v-model="newAddress.city">
                        <label class="control-label">State</label>
                        <input class="form-control" type="text" v-model="newAddress.state">
                        <label class="control-label">Zip Code</label>
                        <input class="form-control" type="text" v-model="newAddress.zip">
                        <label class="control-label">Country</label>
                        <input class="form-control" type="text" v-model="newAddress.country">
                        <label class="control-label">Phone Number</label>
                        <input class="form-control" type="text" v-model="newAddress.phone_number">
                        <label class="control-label">Comment</label>
                        <input class="form-control" type="text" v-model="newAddress.comment">
                    </div>
                    <button class="btn btn-default pull-right" @click="submitNewAddress">{{ buttonMessage }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    var emailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    
    export default {
        data: function() {
            return {
                newAddress: {
                    name: '',
                    street: '',
                    city: '',
                    state: '',
                    zip: '',
                    country: '',
                    phone_number: '',
                    comment: '',
                },
                addresses: {},
                showAddressForm: false,
                selectedAddressId: '',
                signedIn: Matex.signedIn,
                email: '',
            }
        },

        mounted: function() {
            this.getAddresses();
        },

        methods: {
            select: function(addressId) {
                this.selectedAddressId = addressId;
                this.$emit('address-selected', this.selectedAddressId);
            },
            getAddresses: function() {
                this.$http.get('/addresses').then((response) => {
                    this.addresses = response.body.addresses;
                });

            },
            submitNewAddress: function() {
                if(!this.signedIn && this.selectedAddressId != ''){
                    this.updateNewAddress();
                }else {
                    this.createNewAddress();
                }
            },
            createNewAddress: function() {
                var data = {
                    address: this.newAddress,
                    email: this.email
                };

                this.$http.post('/addresses', data).then((response) => {
                    if(response.body.address_id) {
                        this.getAddresses();
                        this.select(response.body.address_id);
                        this.showAddressForm = false;
                        this.clearNewAddress();
                        return
                    }
                    this.select(response.body.address.id);
                }); 
            },
            updateNewAddress: function(data) {
                if(this.selectedAddressId != ''){
                    var data = {
                        address: this.newAddress,
                        email: this.email,
                    }
                    this.$http.put('/addresses/' + this.selectedAddressId, data).then((response) => {});
                }
            },
            isSelected: function(addressId) {
                return this.selectedAddressId == addressId;
            },
            clearNewAddress: function() {
                this.newAddress.name = '';
                this.newAddress.street = '';
                this.newAddress.city = '';
                this.newAddress.state = '';
                this.newAddress.zip = '';
                this.newAddress.country = '';
                this.newAddress.phone_number = '';
                this.newAddress.comment = '';
            }
        },
        computed: {
            validation: function() {
                return {
                    email: !! emailRegex.test(this.email),
                }
            },
            shouldShowAddressForm: function() {
                return this.showAddressForm || ( !this.signedIn && this.validation.email ) || ( this.signedIn && this.addresses.length == 0 );
            },
            buttonMessage: function() {
                if(!this.signedIn && this.selectedAddressId != '') {
                    return 'Update';
                }
                return 'Submit';
            }
        }
    }
</script>

<style type="text/css">
    .selected {
        background-color: yellow;
    }
</style>