<template>
    <div class="">
        <transition name="fade" mode="out-in">
            <div :key="getOrder.id">
                <a :href="'orders/'+getOrder.reference_number" class="color-secondary"># {{ getOrder.reference_number }}</a>
                <p>{{ getOrder.status.name }}</p>
                <p>Placed on {{ getOrder.created_at | ago }}</p>
                <p>$ {{ getOrder.total | inDollars }}</p>
            </div>
        </transition>
        <div v-if="orders.length > 0" class="row">
            <div class="col-xs-12 text-center">
                <a v-if="currentOrder != 0" role="button" @click="currentOrder--">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </a>
                <a role="button" v-for="(order, index) in orders" 
                    @click="currentOrder = index" 
                    style="display: inline-block">
                    <div class="Bullet"
                        :class="{ 'Bullet--filled' : isCurrentOrder(index) }">
                    </div>
                </a>
                <a v-if="currentOrder != orders.length -1" role="button" @click="currentOrder++">
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
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