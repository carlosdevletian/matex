<template>
    <modal @close="close()">
        <div slot="header">
        Contact Us
        </div>

        <div slot="description">
            Send us an email and we'll get back to you right away.
        </div>

        <div slot="body">
            <div>
                <div class="Input__icon">
                    <input v-model="contact.email"
                        class="Form"
                        placeholder="Email address"
                        v-bind:class="{ 'Form--error' : !validation.email}"
                        autofocus>
                    <div v-show="! validation.email" class="error">{{ errors.email ? errors.email[0] : '' }}</div>
                </div>
                <div class="Input__icon">
                    <input v-model="contact.subject"
                        class="Form"
                        placeholder="Subject"
                        v-bind:class="{ 'Form--error' : !validation.subject}">
                    <div v-show="! validation.subject" class="error">{{ errors.subject ? errors.subject[0] : '' }}</div>
                </div>
                <div class="Input__icon" style="padding-bottom: 10px; margin-bottom: 20px">
                    <textarea v-model="contact.body"
                        class="Form"
                        placeholder="Your message here..."
                        rows=5
                        v-bind:class="{ 'Form--error' : !validation.body}"></textarea>
                    <div v-show="! validation.body" class="error">{{ errors.body ? errors.body[0] : '' }}</div>
                </div>
                <div>
                    <button class="Button--modal" @click="sendContactEmail()">Send</button>
                </div>
            </div>
        </div>

    </modal>
</template>

<script>
    var emailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    export default {
         data: function () {
            return {
                contact: {
                    subject: '',
                    body: '',
                    email: ''
                },
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
                    this.close();
                    swal({
                            title: 'Thanks for contacting us!',
                            text: 'The email was successfully sent.',
                            type: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                    }).catch(swal.noop);
                }).catch(function(error) {
                    if (error.response.status != 422) {
                        this.close();
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
                    subject: this.errors.hasOwnProperty('subject') ? !! this.contact.subject.trim() : true,
                    email: this.errors.hasOwnProperty('email') ? !! emailRegex.test(this.contact.email) : true,
                    body: this.errors.hasOwnProperty('body') ? !! this.contact.body.trim() : true,
                }
            }
        }
    }
</script>
