<template>
    <modal-template @close="close()">
        <div slot="header">
        Contact Us
        </div>

        <div slot="description">
            Send us an email and we'll get back to you right away.
        </div>

        <div slot="body">
            <div>
                <div v-show="firstError" class="error text-center">{{ firstError }}</div>
                <div class="Input__icon">
                    <input v-model="contact.email"
                        class="Form"
                        placeholder="Email address"
                        v-bind:class="{ 'Form--error' : !validation.email}"
                        :disabled="existingEmail" 
                        autofocus>
                </div>
                <div class="Input__icon">
                    <input v-model="contact.subject"
                        class="Form"
                        placeholder="Subject"
                        v-bind:class="{ 'Form--error' : !validation.subject}">
                </div>
                <div class="Input__icon mg-btm-50">
                    <textarea v-model="contact.body"
                        class="Form"
                        placeholder="Your message here..."
                        rows=5
                        v-bind:class="{ 'Form--error' : !validation.body}"></textarea>
                </div>
                <div>
                    <button class="Button--secondary stick-to-bottom" @click="sendContactEmail()">Send</button>
                </div>
            </div>
        </div>

    </modal-template>
</template>

<script>
    var emailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    export default {
         data: function () {
            return {
                contact: {
                    subject: '',
                    body: '',
                    email: !! Matex.email ? Matex.email : ''
                },
                existingEmail: !! Matex.email ? true : false,
                errors: '',
            };
        },
        methods: {
            close: function () {
                this.$emit('close');
                this.contact.subject = '';
                this.contact.body = '';
                this.contact.email = '';
                this.errors = '';
            },
            sendContactEmail: function () {
                var data = this.contact;
                var vm = this;
                axios.post('/contact', data).then((response) => {
                    vm.close();
                    swal({
                            title: 'Thanks for contacting us!',
                            text: 'The email was successfully sent.',
                            type: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                    }).catch(swal.noop);
                }).catch(function(error) {
                    if (error.response.status != 422) {
                        vm.close();
                        swal({
                            title: 'An error occurred',
                            text: 'The email could not be sent. Try again later',
                            type: 'error',
                            timer: 1900,
                            showConfirmButton: false
                        }).catch(swal.noop);
                    }
                    vm.errors = error.response.data;
                });
            }
        },
        computed: {
            validation: function() {
                return {
                    email: this.errors.hasOwnProperty('email') ? !! emailRegex.test(this.contact.email) : true,
                    subject: this.errors.hasOwnProperty('subject') ? !! this.contact.subject.trim() : true,
                    body: this.errors.hasOwnProperty('body') ? !! this.contact.body.trim() : true,
                }
            },
            firstError: function() {
                var vm = this;
                for (var field in this.validation) {
                    if(! vm.validation[field]){
                        return field == 'email' ? 'Please enter a correct email ' : 'Please enter a ' + field;
                    }
                }
            }
        }
    }
</script>
