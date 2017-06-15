<template>
    <modal-template @close="close()" v-cloak :overflow-y="true">
        <div slot="header">
            Pricing for {{ category }}
        </div>

        <div slot="body" class="text-center pd-btm-25">
            <div v-for="(pricings, category) in categoryPricings">
                {{ category }}
                <div v-for="pricing in pricings">
                    {{ pricing.min_quantity }} ${{ pricing.unit_price | inDollars }}
                </div>
            </div>
            <button class="Button--secondary stick-to-bottom" @click="close()">Got it!</button>
        </div>

    </modal-template>
</template>

<script>
    export default {
        props: ['categoryPricings'],
        methods: {
            close: function () {
                this.$emit('close');
            },
        },
    }
</script>