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
                <div v-show="address.show_errors && (error || emailError)" class="error">{{ emailError ? emailError : error }}</div>
                <form>
                    <input class="Form mg-btm-20"
                        name="email"
                        type="email"
                        v-model="address.email"
                        placeholder="Email *"
                        @blur="validateEmail"
                        v-if="!signedIn"
                        v-bind:class="{ 'Form--error' : (!validation.email && address.show_errors) || (emailTaken && address.show_errors) }">
                    <input class="Form mg-btm-20"
                        name="recipient"
                        type="text"
                        v-model="address.name"
                        placeholder="Recipient name *"
                        v-bind:class="{ 'Form--error' : !validation.name && address.show_errors }">
                    <input class="Form mg-btm-20"
                        name="street"
                        type="text"
                        v-model="address.street"
                        placeholder="Street *"
                        v-bind:class="{ 'Form--error' : !validation.street && address.show_errors }">
                    <div class="row">
                        <div class="col-sm-6">
                            <input class="Form mg-btm-20"
                            name="city"
                            type="text"
                            v-model="address.city"
                            placeholder="City *"
                            v-bind:class="{ 'Form--error' : !validation.city && address.show_errors }">
                        </div>
                        <div class="col-sm-6">
                            <div class="Form__select Form__select--full-width" v-bind:class="{ 'Form--error' : !validation.state && address.show_errors }">
                                <select name="state" v-model="address.state">
                                    <option value="" disabled>Select a State *</option>
                                    <option value="AL">Alabama</option>
                                    <option value="AK">Alaska</option>
                                    <option value="AZ">Arizona</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="CA">California</option>
                                    <option value="CO">Colorado</option>
                                    <option value="CT">Connecticut</option>
                                    <option value="DE">Delaware</option>
                                    <option value="DC">District Of Columbia</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="HI">Hawaii</option>
                                    <option value="ID">Idaho</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IN">Indiana</option>
                                    <option value="IA">Iowa</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="ME">Maine</option>
                                    <option value="MD">Maryland</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MI">Michigan</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MO">Missouri</option>
                                    <option value="MT">Montana</option>
                                    <option value="NE">Nebraska</option>
                                    <option value="NV">Nevada</option>
                                    <option value="NH">New Hampshire</option>
                                    <option value="NJ">New Jersey</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="NY">New York</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="OH">Ohio</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="OR">Oregon</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="RI">Rhode Island</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="TX">Texas</option>
                                    <option value="UT">Utah</option>
                                    <option value="VT">Vermont</option>
                                    <option value="VA">Virginia</option>
                                    <option value="WA">Washington</option>
                                    <option value="WV">West Virginia</option>
                                    <option value="WI">Wisconsin</option>
                                    <option value="WY">Wyoming</option>
                                </select>
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input class="Form mg-btm-20"
                                name="zip"
                                type="text"
                                v-model="address.zip"
                                placeholder="Zip Code *"
                                v-bind:class="{ 'Form--error' : !validation.zip && address.show_errors }">
                            </div>
                            <div class="col-sm-6" 
                                    data-toggle="tooltip" 
                                    data-placement="bottom" 
                                    title="At the moment we are only shipping in the US">
                                        <input class="Form mg-btm-20"
                                        name="country"
                                        type="text"
                                        v-model="address.country"
                                        disabled
                                        placeholder="Country *"
                                        v-bind:class="{ 'Form--error' : !validation.country && address.show_errors }">
                            </div>
                        </div>
                        <input class="Form mg-btm-20"
                            name="phone_number"
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
                emailTaken: false,
                emailError: false,
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
            validateEmail() {
                axios.post('/validateEmailAddress', {
                    email : this.address.email,
                }).then((response) => {
                    this.emailTaken = false;
                    this.emailError = '';
                }).catch(error => {
                    this.emailTaken = true;
                    this.emailError = error.response.data.email;
                    this.address.is_valid = false;
                })
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
                    zip: !! this.address.zip != '' && /^[0-9]{5}(\-[0-9]{4})?$/.test(this.address.zip),
                    country: !! this.address.country != '',
                    phone_number: !! this.address.phone_number != '',
                }
            },
            validatedAddress: function() {
                var vm = this;
                this.address.is_valid = true;
                this.error = '';
                for (var field in this.validation) {
                    if(vm.error) {
                        vm.address.is_valid = false;
                        break;
                    }
                    if(! vm.validation[field]){
                        vm.address.is_valid = false;
                        vm.error = field == 'phone_number' ? 'Please enter a phone number' : 'Please enter a ' + field;
                        break;
                    }
                }
                if(this.emailTaken) this.address.is_valid = false;
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
