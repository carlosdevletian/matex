<template>
    <div class="row">
        <div>
            Product Name : {{ item.name }},
            Product Id: {{ item.id }}
        </div>
        <input type="number" v-model="quantity">
    </div>
</template>

<script>
    export default {
        props: ['item'],
        data: function() {
            return {
                'quantity' : '',            };
        },    
    }
</script>