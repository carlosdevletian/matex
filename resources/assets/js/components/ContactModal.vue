<template>
    <modal @close="close()">
        <div slot="header">Contact Us</div>

        <div slot="description">
            Send us an email and we'll get back to you right away.
        </div>

        <div slot="body">
            <input v-model="contact.email" class="form-control" placeholder="Email address" autofocus>
            <div v-show="! validation.email" class="error">{{ errors.email ? errors.email[0] : '' }}</div>
            <input v-model="contact.subject" class="form-control" placeholder="Subject">
            <div v-show="! validation.subject" class="error">{{ errors.subject ? errors.subject[0] : '' }}</div>
            <input v-model="contact.body" class="form-control" placeholder="Body">
            <div v-show="! validation.body" class="error">{{ errors.body ? errors.body[0] : '' }}</div>
            <button class="Modal__button" @click="sendContactEmail()">Send</button>
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
                this.$http.post('/contact', data).then((response) => {
                    this.close();
                    swal({
                            title: 'Thanks for contacting us!',
                            text: 'The email was successfully sent.',
                            type: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                    });
                }, (response) => {
                    if (response.status != 422) {
                        this.close();
                        swal({
                            title: 'An error occurred',
                            text: 'The email could not be sent. Try again later',
                            type: 'error',
                        });
                    }
                    console.log('The email could not be sent. Validation errors occurred');
                    this.errors = response.body;
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
