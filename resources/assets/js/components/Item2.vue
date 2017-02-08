<template>
    <div class="row">
        <div class="col-xs-1">
            <a @click="deleteItem" role="button">x</a>
        </div>
        <div class="col-xs-3">
            <h5>{{ item.product.name }}</h5>
        </div>
        <div class="col-xs-3">
            <input type="number"
                v-model="item.quantity"
                @change="updatePrice" 
                class="form-control" 
                onfocus="if(this.value == '0') { this.value = ''; }" 
                autofocus>
            <div v-show="error">{{ error }}</div>
        </div>
        <div class="col-xs-2">${{ item.unit_price }}</div>
        <div class="col-xs-3">${{ item.total_price }}</div>
    </div>
</template>

<script>
    export default {
        props: ['item'],
        data: function () {
            return {
                error: '',
            }
        },
        methods: {
            updatePrice: function () {
                this.validateQuantity();
                this.$http.post('/calculatePrice', this.item).then((response) => {
                    this.item.unit_price = response.body.unit_price;
                    this.item.total_price = response.body.total_price;
               });
            },
            validateQuantity: function() {
                if(this.item.quantity < 1) {
                    this.error = 'Input a valid quantity';
                    this.item.quantity = 0;
                    return;
                }
                this.error = '';
            },
            deleteItem: function() {
                this.$emit('delete-item', this.item.product.id);
            }
        }
    }
</script>