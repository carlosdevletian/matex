<template>
    <div>
        <input type="text" :id="id" :name="name" v-model="number" :class="classes" :placeholder="placeholder" novalidate>
        <input type="hidden" :name="name" v-model="numberToInteger">
    </div>
</template>

<script>
    export default {
        props: ['id', 'name', 'classes', 'value', 'placeholder'],
        data() {
            return {
                number: this.value ? this.value/100 : 0,
            }
        },
        computed: {
            numberToInteger() {
                return this.number * 100;
            }
        }
    }
</script>