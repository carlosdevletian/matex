<template>
    <div class="row">
        <div class="col-xs-12">
                <div class="background-image Order__design" :style="imageUrl">
                    <a class="Order__design__link" @click="openImage"></a>
                </div>
            <p class="Order__design__title">Your Design</p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['image'],
        data: function () {
            return {
                imageUrl: {
                    backgroundImage : "url('/images/"+this.image+"')",
                }
            }
        },
        methods: {
            openImage: function() {
                var design = {
                    image_name : this.image
                }
                Event.$emit('open-image', design);
            },
        }
    }
</script>