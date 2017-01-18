<template>
    <div class="row">
        <div class="col-xs-6">
                <form v-on:submit.prevent="onSubmit">
                    {{ csrf_field() }}<!-- 
                    <div class="col-xs-4">
                        <textarea name="comments"></textarea>
                    </div> -->
                     <ul>
                        <div class="col-xs-4">
                            <div v-for="product in products">

                                <div class="col-xs-6">
                                    <li>{{ product.name }}</li>
                                    <input type="checkbox" name="category[]">
                                </div>
                                <div class="col-xs-6">
                                    <div class="row">
                                        <p>Cantidad</p>
                                        <input type="number" name="items[{{ product.id }}]">
                                    </div>
                                </div> 
                        </div>
                    </ul>
                    <button type="submit">Submit</button>
                </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['categoryId'],
        data: function() {
            return {
                'products' : '',
            };
        },
        mounted: function () {
           this.$http.get('/category/' + this.categoryId + '/products').then((response) => {
                this.products = response.body;
           });
        },
    }
</script>