<template>
    <modal-template @close="close()" :child-class-object="{ 'Modal--wide' : true }">
        <div slot="header">
            Design
        </div>
        
        <div slot="body">
            <img class="img-responsive margin-auto box-shadow" :src="'/images/' + design.image_name ">
            <div v-if="design.comment">{{ design.comment }}</div>
        </div>

        <div slot="footer"><p>Created {{ design.created_at | ago }}</p></div>

    </modal-template>
</template>

<script>
    export default {
        props: ['design'],
        methods: {
            close: function () {
                this.$emit('close');
            },
        },
    }
</script>
