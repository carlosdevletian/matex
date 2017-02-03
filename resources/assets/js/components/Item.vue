<template>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-1">
                <a @click="onDelete" class="pull-right" role="button" style="color: red">x</a>
            </div>
            <div class="col-xs-3">{{ item.name }}</div>
            <div class="col-xs-3">
                <input onfocus="if(this.value == '0') { this.value = ''; }" type="number" v-model="item.quantity" @change="validateQuantity" class="form-control" autofocus>
            </div>
            <div class="col-xs-2">${{ item.unit_price }}</div>
            <div class="col-xs-3">${{ item.total_price }}</div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['item'],
        data: function() {
            return {
                error: ''
            }
        },
        methods: {
            onQuantityUpdated: function() {
                this.$http.post('/calculatePrice', this.item).then((response) => {
                    this.item.unit_price = response.body.unit_price;
                    this.item.total_price = response.body.total_price;
               });
                this.$emit('quantity-updated', this.item);
            },
            validateQuantity: function() {
                if(this.item.quantity <= 0) {
                    this.error = 'Quantity must be greater than 0';
                    this.item.quantity = 0;
                    this.item.unit_price = 0;
                    this.item.total_price = 0;
                }else {
                    this.error = '';
                    this.onQuantityUpdated();
                }
            },
            onDelete: function() {
                this.$emit('delete-item', this.item.product_id);
            }
        }    
    }
</script>