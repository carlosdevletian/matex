<template>
    <div>
        <div class="Card Card--order">
            <div class="Card__body">
                <transition name="fade" mode="out-in">
                    <div :key="getOrder.id">
                        <p><a :href="'/orders/'+getOrder.reference_number" class="color-primary"># {{ getOrder.reference_number }}</a></p>
                        <p>{{ getOrder.status.name }}</p>
                        <p>Placed on {{ getOrder.created_at | ago }}</p>
                        <p>Total: $ {{ getOrder.total | inDollars }}</p>
                    </div>
                </transition>
            </div>
        </div>
        <div v-if="orders.length > 1" class="row Card__chevrons">
            <div class="col-xs-12 text-center">
                <a v-if="currentOrder != 0" role="button" @click="currentOrder--">
                    <i class="fa fa-chevron-circle-left Card__chevrons--left" aria-hidden="true"></i>
                </a>
                <!-- <a role="button" v-for="(order, index) in orders" 
                    @click="currentOrder = index"
                    style="display: inline-block">
                    <div class="Bullet"
                        :class="{ 'Bullet--filled' : isCurrentOrder(index) }">
                    </div>
                </a> -->
                <a v-if="currentOrder != orders.length -1" role="button" @click="currentOrder++">
                    <i class="fa fa-chevron-circle-right Card__chevrons--right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['orders'],
        data() {
            return {
                currentOrder: 0
            }
        },
        methods: {
            isCurrentOrder(index) {
                return index == this.currentOrder;
            }
        },
        computed: {
            getOrder() {
                return this.orders[this.currentOrder % this.orders.length];
            }
        }
    }
</script>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .3s ease;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>