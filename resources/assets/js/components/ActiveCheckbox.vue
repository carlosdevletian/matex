<template>
    <div class="position-relative">
        <input type="hidden" 
            :value="+active" 
            name="products[active][]" 
            :disabled="active">
        <input type="checkbox"
            :value="+active"
            @change="toggleActive"
            :checked="active"
            name="products[active][]"
            @mouseover="showInformation = true"
            @mouseleave="showInformation = false">
        <div class="Card" v-show="showInformation" style="position: absolute; top: -15px; left: 25px; z-index: 3">
            <i class="fa fa-2x fa-caret-left" aria-hidden="true" style="
                position: absolute;
                top: 3px;
                left: -20px;
                color: white;
                text-shadow: 0px 0px 1px #000;
            "></i>
            Click to make this product {{ active ? 'unavailable' : 'available' }} to customers
        </div>
    </div>
</template>

<script>
    export default {
        props: ['initial'],
        data: function() {
            return {
                active : !!+this.initial,
                showInformation : false
            }
        },
        methods: {
            toggleActive: function() {
                this.active = ! this.active;
            }
        }
    }
</script>