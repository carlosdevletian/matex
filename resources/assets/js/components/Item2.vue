<template>
    <div class="row">
        <div class="col-xs-12">
            <h5>{{ item.product.name }}</h5>
            <a @click="deleteItem" role="button">x</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['item'],
        methods: {
            deleteItem: function(product) {
                this.$emit('delete-item', this.item.product.id);
            }
        }
    }
</script>