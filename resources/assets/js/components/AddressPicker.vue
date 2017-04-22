<template>
    <div class="col-xs-12">
        <div v-show="existingAddresses.length > 0 && ! showAddressForm" class="row">
            <div class="position-relative">
                <a @mouseover="scrollLeft()" 
                    @mouseout="stopScroll()" 
                    @click="scrollToBeginning()" 
                    class="Scroller Scroller--left" 
                    role="button">
                        <i class="fa fa-chevron-left Scroller__icon" aria-hidden="true"></i>
                    </a>
                <a @mouseover="scrollRight()" 
                    @mouseout="stopScroll()" 
                    @click="scrollToEnd()" 
                    class="Scroller Scroller--right" 
                    role="button">
                        <i class="fa fa-chevron-right Scroller__icon" aria-hidden="true"></i>
                    </a>
                <div ref="carousel" class="Scroll__container">
                    <div v-for="existingAddress in existingAddresses" class="Scroll__element">
                        <div class="Card Card--address col-md-12" :class="{ 'Card--address--selected' : isSelected(existingAddress.id)}">
                            <a role="button" @click="showExtraInfo(existingAddress.id)" class="Address__expand">
                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </a>
                            <a role="button" @click="updateSelectedAddress(existingAddress)">
                                <div>{{ existingAddress.name }}</div>
                                <div>{{ existingAddress.street }}</div>
                                <div>{{ existingAddress.city }}</div>
                                <div v-show="showMoreId == existingAddress.id">
                                    <div>{{ existingAddress.country }}</div>
                                    <div>{{ existingAddress.zip }}</div>
                                    <div>{{ existingAddress.phone_number }}</div>
                                </div>
                            </a>
                            <!-- <div v-show="isSelected(existingAddress.id)" class="text-center">
                                <i class="fa fa-check-circle" aria-hidden="true" ></i>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <a role="button" class="pull-right color-primary" @click="toggleAddressForm">
                    Add a new address
                </a>
            </div>
        </div>
        <div v-show="! signedIn || showAddressForm || (signedIn && existingAddresses.length == 0)" class="row">
            <div class="col-xs-12">
                <a role="button"
                    class="inherit pull-right"
                    v-show="existingAddresses.length > 0 && signedIn"
                    @click="showAddressForm = ! showAddressForm">
                        Select from existing addresses
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
            <div class="col-xs-12">
                <div v-show="address.show_errors && error" class="error">{{ error }}</div>
                <form>
                    <input class="Form mg-btm-20"
                        type="email"
                        v-model="address.email"
                        placeholder="Email *"
                        v-if="!signedIn"
                        v-bind:class="{ 'Form--error' : !validation.email && address.show_errors }">
                    <input class="Form mg-btm-20"
                        type="text"
                        v-model="address.name"
                        placeholder="Recipient name *"
                        v-bind:class="{ 'Form--error' : !validation.name && address.show_errors }">
                    <input class="Form mg-btm-20"
                        type="text"
                        v-model="address.street"
                        placeholder="Street *"
                        v-bind:class="{ 'Form--error' : !validation.street && address.show_errors }">
                    <div class="row">
                        <div class="col-sm-6">
                            <input class="Form mg-btm-20"
                            type="text"
                            v-model="address.city"
                            placeholder="City *"
                            v-bind:class="{ 'Form--error' : !validation.city && address.show_errors }">
                        </div>
                        <div class="col-sm-6">
                            <input class="Form mg-btm-20"
                            type="text"
                            v-model="address.state"
                            placeholder="State *"
                            v-bind:class="{ 'Form--error' : !validation.state && address.show_errors }">
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input class="Form mg-btm-20"
                                type="text"
                                v-model="address.zip"
                                placeholder="Zip Code *"
                                v-bind:class="{ 'Form--error' : !validation.zip && address.show_errors }">
                            </div>
                            <div class="col-sm-6">
                                <input class="Form mg-btm-20"
                                type="text"
                                v-model="address.country"
                                placeholder="Country *"
                                v-bind:class="{ 'Form--error' : !validation.country && address.show_errors }">
                            </div>
                        </div>
                        <input class="Form mg-btm-20"
                            type="text"
                            v-model="address.phone_number"
                            placeholder="Phone Number *"
                            v-bind:class="{ 'Form--error' : !validation.phone_number && address.show_errors }">
                        <textarea class="Form mg-btm-20" v-model="address.comment" placeholder="Comment"></textarea>
                    
                </form>
                    <div v-show="false">{{ validatedAddress }}</div>
            </div>
        </div>
    </div>
</template>

<script>
    var emailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

    import { carouselMixin } from '../mixins/carouselMixin';

    export default {
        mixins: [carouselMixin],
        props: ['address', 'existingAddresses'],
        data: function() {
            return {
                signedIn: Matex.signedIn,
                showAddressForm: false,
                selected: 0,
                showMoreId: 0,
                error: '',
            }
        },
        methods: {
            updateSelectedAddress: function(address) {
                if(this.selected == address.id || address == 0) {
                    this.selected = 0;
                    var zip = '';
                }else {
                    this.selected = address.id;
                    var zip = address.zip;
                }
                var data = {
                    id : this.selected,
                    zip : zip
                }
                this.$emit('update-selected-address', data);
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
            },
            showExtraInfo: function(id) {
                if(this.showMoreId == id) {
                    this.showMoreId = 0;
                } else {
                    this.showMoreId = id;
                }
            },
        },
        computed: {
            validation: function() {
                return {
                    email: !! emailRegex.test(this.address.email) && this.address.email != '' || this.signedIn,
                    name: !! this.address.name != '',
                    street: !! this.address.street != '',
                    city: !! this.address.city != '',
                    state: !! this.address.state != '',
                    zip: !! this.address.zip != '' && this.address.zip.length === 5,
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
                        vm.error = field == 'phone_number' ? 'Please enter a phone number' : 'Please enter a ' + field;
                        break;
                    }
                }
                if(this.address.is_valid) {
                    this.error = '';
                }
                return this.address.is_valid;
            },
        }
    }
</script>

<style>
    .error {
        color: red;
        text-align: center;
        padding: 10px;
    }
    .inherit {
        color: inherit;
    }
</style>
