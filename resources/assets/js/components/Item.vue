<template>
    <div class="col-xs-12">
        <table class="table">
            <tbody>
                <tr>
                    <td>{{ item.name }} [{{ item.product_id }}] :</td>
                    <td><input onfocus="if(this.value == '0') { this.value = ''; }" type="number" v-model="item.quantity" @change="validateQuantity" class="form-control" autofocus></td>
                    <td>${{ item.unit_price }}</td>
                    <td>${{ item.total_price }}</td>
                    <td><button @click="onDelete" class="btn btn-danger pull-right">x</button></td>
                </tr>
                <tr v-if="error" class="text-center" style="color: red">
                    {{ error }}
                </tr>
            </tbody>
        </table>
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