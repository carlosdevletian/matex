<template>
    <modal-template @close="close()">
        <div slot="header">
            Notes
        </div>

        <div slot="description">
            Add any relevant notes associated to this user.
        </div>

        <div slot="body">
            <form method="POST" :action="formAction" class="pd-btm-50">
                <input type="hidden" name="_token" v-model="csrf">
                <textarea v-model="comment" name="admin_comment" class="Form"></textarea>
                <button class="Button--primary stick-to-bottom">Add</button>
            </form>
        </div>

    </modal-template>
</template>

<script>
    export default {
        props: ['user'],
        data: function () {
            return {
                csrf: Matex.csrfToken,
                comment: this.user.admin_comment,
                formAction: `/user/${this.user.id}/adminComment`
            };
        },
        methods: {
            close: function () {
                this.$emit('close');
                this.comment = '';
            },
        },
    }
</script>
