<template>
    <div class="row" style="margin-top: 10px">
        <div class="col-xs-10 col-xs-offset-1">
            <img height="43px" width="1077px" class="img-responsive" 
                :src="'/images/' + getDesign.image_name" 
                @click="select(getDesign)"
                role="button">
            <div class="text-center">
                <a role="button" @click="currentDesign--">Previous</a>
                <a role="button" @click="currentDesign++">Next</a>
            </div>
        </div>
        <a role="button" @click="close()">X</a>
    </div>
</template>

<script>
    export default {
        props: ['designs'],
        data: function() {
            return {
                currentDesign: 0
            }
        },
        methods: {
            select: function(design) {
                Event.$emit('design-selected', design);
            },
            close: function() {
                Event.$emit('close-design-picker');
            }
        },
        computed: {
            getDesign: function() {
                return this.designs[this.currentDesign % this.designs.length];
            }
        }
    }
</script>