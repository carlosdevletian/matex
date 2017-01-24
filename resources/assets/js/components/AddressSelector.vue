<template>
    <div class="row">
        <h2 class="text-center">
            <a @click="showAddressForm=false">Select a shipping address</a> 
            or 
            <a @click="showAddressForm=true" style="hover:click">add a new one</a>
        </h2>
        <div class="col-xs-6 col-xs-offset-3">
            <div v-show="showAddressForm" class="panel panel-default">
                <div class="panel-heading">
                    Create a new address
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
                    <button class="btn btn-default pull-right" @click="createNewAddress">Submit</button>
                </div>
            </div>
        </div>
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
    </div>
</template>

<script>
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
                selectedAddressId: ''
            }
        },
        mounted: function() {
            this.getAddresses();
        },
        computed: {
            AddressesObject: function() {
                return JSON.parse(this.addresses);
            }
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
            createNewAddress: function() {
                this.$http.post('/addresses', this.newAddress).then((response) => { 
                    this.getAddresses();
                    this.select(response.body.address_id);
                    this.showAddressForm = false;
                });
            },
            isSelected: function(addressId) {
                return this.selectedAddressId == addressId;
            }
        }
    }
</script>

<style type="text/css">
    .selected {
        background-color: yellow;
    }
</style>