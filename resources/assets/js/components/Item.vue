<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-6" style="text-align: right">
                {{ item.name }} [{{ item.product_id }}] :
            </div>
            <button @click="onDelete" class="btn btn-danger pull-right">x</button>
            <div class="col-xs-4">
                <input type="number" v-model="item.quantity" @change="validateQuantity" class="form-control" autofocus>
                <div style="color: red">{{ error }}</div>
            </div>
            ${{ item.unit_price }}
            ${{ item.total_price }}
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