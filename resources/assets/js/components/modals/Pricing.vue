<template>
    <modal-template @close="close()" v-cloak :overflow-y="true">
        <div slot="header">
            {{  categoryName | ucfirst}} Pricing
        </div>

        <div slot="body" class="text-center pd-btm-25">
            <div v-if="Object.keys(categoryPricings).length == 1">
                <div class="row">
                    <div class="col-xs-6 color-secondary">
                        More than X units
                    </div>
                    <div class="col-xs-6 color-secondary">
                        Price per unit
                    </div>
                </div>
                <div v-for="pricing in categoryPricings[Object.keys(categoryPricings)[0]]" class="row Pricing__row">
                    <div class="col-xs-6">
                        {{ pricing.min_quantity }}
                    </div>
                    <div class="col-xs-6">
                        ${{ pricing.unit_price | inDollars }}
                    </div>
                </div>
            </div>
            <tabs v-else :header-styles="noMargin"> 
                <tab v-for="(pricings, category, index) in categoryPricings"
                    :selected="index == 0" 
                    :key="category"
                    :name="category">
                        <div class="row mg-btm-10">
                            <div class="col-xs-6 color-secondary">
                                More than X units
                            </div>
                            <div class="col-xs-6 color-secondary">
                                Price per unit
                            </div>
                        </div>
                        <div v-for="pricing in pricings" class="row Pricing__row">
                            <div class="col-xs-6">
                                {{ pricing.min_quantity }}
                            </div>
                            <div class="col-xs-6">
                                ${{ pricing.unit_price | inDollars }}
                            </div>
                        </div>
                </tab>
            </tabs>
            <!-- <div v-for="(pricings, category) in categoryPricings">
                {{ category }}
                <div v-for="pricing in pricings">
                    {{ pricing.min_quantity }} ${{ pricing.unit_price | inDollars }}
                </div>
            </div> -->
            <button class="Button--secondary stick-to-bottom" @click="close()">Got it!</button>
        </div>

    </modal-template>
</template>

<script>
    export default {
        props: ['categoryPricings'],
        data() {
            return {
                noMargin : {
                    marginRight : '-30px',
                    marginLeft : '-30px',
                }
            }
        },
        methods: {
            close: function () {
                this.$emit('close');
            },
        },
        computed: {
            categoryName() {
                return Object.keys(this.categoryPricings).length == 1  ? Object.keys(this.categoryPricings)[0] : '';
            }
        }
    }
</script>

<style>
    .Pricing__row {
        line-height: 2;
    }
    /*.Pricing__row:nth-child(odd) {
        background-color: #fff0e6;
    }*/
</style>