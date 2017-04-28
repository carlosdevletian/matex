<template>
    <modal-template @close="close()">
        <div slot="header">
        Contact User
        </div>

        <div slot="description">
            Send an email to {{ user.name }}
        </div>

        <div slot="body">
            <div v-if="errors" class="error">{{ firstError }}</div>
            <form class="pd-btm-25" v-on:submit.prevent="submitForm()">
                <input type="email" 
                    class="Form mg-btm-20"
                    disabled 
                    :placeholder="emailPlaceholder">
                <input type="text" 
                    class="Form mg-btm-20"
                    :class="{ 'Form--error' : !validation.subject }" 
                    placeholder="Subject" 
                    v-focus 
                    v-model="form.subject">
                <textarea name="body" 
                    placeholder="Your message to the user" 
                    class="Form"
                    :class="{ 'Form--error' : !validation.body }" 
                    v-model="form.body" 
                    rows=5></textarea>
                <button class="Button--secondary stick-to-bottom">Send</button>
            </form>
        </div>
    </modal-template>
</template>

<script>
    export default {
        props: ['user'],
         data: function () {
            return {
                form: {
                    email: this.user.email,
                    subject: '',
                    body: ''
                },
                errors: ''
            }
        },
        methods: {
            close: function () {
                this.$emit('close');
            },
            submitForm: function() {
                var vm = this;
                axios.post('/contact-user',this.form)
                    .then((response) => {
                        vm.close();
                        swal({
                            title: 'Success!',
                            text: 'The email was sent.',
                            type: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        }).catch(swal.noop);
                    }).catch(function(error) {
                        switch(error.response.status) {
                            case 422:
                                vm.errors = error.response.data;
                                break;
                            default:
                                vm.close();
                                    swal({
                                    title: 'An error occurred',
                                    text: 'The email could not be sent. Try again later',
                                    type: 'error',
                                    timer: 1900,
                                    showConfirmButton: false
                                }).catch(swal.noop);
                        }
                    });
            }
        },
        computed: {
            emailPlaceholder: function() {
                return `To: ${this.user.email}`;
            },
            firstError: function() {
                var vm = this;
                for (var field in this.validation) {
                    if(! vm.validation[field]){
                        return `Please enter a ${field}`;
                    }
                }
            },
            validation: function() {
                return {
                    subject: this.errors.hasOwnProperty('subject') ? !! this.form.subject.trim() : true,
                    body: this.errors.hasOwnProperty('body') ? !! this.form.body.trim() : true,
                }
            }
        }
    }
</script>
