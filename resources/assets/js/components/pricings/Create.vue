<template>
    <modal-template @close="close()">
        <div slot="header">
            Create a pricing
        </div>

        <div slot="description">
            Add a pricing for the {{ category.name }} category
        </div>

        <div slot="body" class="pd-btm-25">
            <input class="Form text-center" 
                type="number"
                placeholder="From" 
                v-model="pricing.min_quantity">
            <input class="Form text-center" 
                type="text"
                placeholder="Unit Price"
                @change="updateUnitPrice" 
                v-model="unit_price">
            <input class="Form text-center" 
                type="hidden" 
                v-model="pricing.unit_price">
            <button class="Button--secondary stick-to-bottom" @click="createPricing">Confirm</button>
        </div>

    </modal-template>
</template>

<script>
    export default {
        props: ['category'],
        data: function () {
            return {
                pricing: {
                    min_quantity: null,
                    unit_price: null,
                },
                unit_price: null
            }
        },
        methods: {
            close: function () {
                this.$emit('close');
            },
            createPricing() {
                axios.post(`/pricings/${this.category.id}`, this.pricing)
                .then((response) => {
                    location.reload();
                });
            },
            updateUnitPrice() {
                this.pricing.unit_price = parseInt(this.unit_price * 100);
            }
        },
    }
</script>
