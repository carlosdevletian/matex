<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-6" style="text-align: right">
                {{ item.name }} [{{ item.product_id }}] :
            </div>
            <button @click="onDelete" class="btn btn-danger pull-right">x</button>
            <div class="col-xs-4">
                <input type="number" v-model="item.quantity" @change="onQuantityUpdated" class="form-control" autofocus>
            </div>
            ${{ item.price }}
        </div>
    </div>
</template>

<script>
    export default {
        props: ['item'],
        methods: {
            onQuantityUpdated: function() {
                this.$http.post('/calculatePrice', this.item).then((response) => {
                    this.item.price = response.body.price;
               });
                this.$emit('quantity-updated', {
                    product_id : this.item.product_id,
                    quantity : this.item.quantity,
                });
            },
            onDelete: function() {
                this.$emit('delete-item', this.item.product_id);
            }
        }    
    }
</script>