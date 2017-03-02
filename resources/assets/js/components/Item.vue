<template>
    <div>
        <div class="row">
            <div class="col-xs-1 ">
                <h5>
                    <a @click="deleteItem" role="button" class="Item__delete">&#10005;</a>
                </h5>
            </div>
            <div class="col-xs-3">
                <h5>{{ item.product.name }}</h5>
            </div>
            <div class="col-xs-3">
                <h5>
                    <input type="number"
                        v-model="item.quantity"
                        @change="updatePrice"
                        class="Form pd-0"
                        onfocus="if(this.value == '0') { this.value = ''; }"
                        v-bind:class="{ 'Form--error' : this.error }"
                        autofocus>
                </h5>
            </div>
            <div class="col-xs-2">
                <h5>
                    $ {{ item.unit_price | inDollars }}
                </h5>
            </div>
            <div class="col-xs-3">
                <h5>
                    $ {{ item.total_price | inDollars }}
                </h5>
            </div>
        </div>
        <div class="row">
            <div v-show="error" class="col-xs-12 text-center">
                <h5>
                    {{ error }}
                </h5>
            </div>
        </div>
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
                axios.post('/calculatePrice', this.item).then((response) => {
                    this.item.unit_price = response.data.unit_price;
                    this.item.total_price = response.data.total_price;
               });
            },
            validateQuantity: function() {
                if(this.item.quantity < 1 || this.item.quantity % 1 != 0) {
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
<style>
    .pd-0{
        padding: 0px;
    }
</style>
