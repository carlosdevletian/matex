<template>
    <modal-template @close="close()" :child-class-object="{ 'Modal--wide' : true }">
        <div slot="header">
            Design
        </div>
        
        <div slot="body">
            <img v-if="typeof design.initial !=='undefined'" class="img-responsive margin-auto box-shadow" :src="'/images/' + design.image_name">
            <img v-else class="img-responsive margin-auto box-shadow" :src="'/images/' + design.image_name + '/1' ">
            <div class="Modal__image-description" v-if="design.comment">{{ design.comment }}</div>
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
