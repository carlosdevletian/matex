<template>
    <div class="mg-btm-20" :class="addClass">
        <a role="button" @click="openImage">
            <div class="Card Card--thumbnail Flippable" :class="{ Flipped : showMore }">
                <div class="Flippable__front Thumbnail--image background-image" :style="imageUrl"></div>
                <div class="Flippable__back position-relative" @click.stop>
                    <div class="Thumbnail--image position-absolute text-center" style="width: 100%; bottom: 0">
                        <a role="button" @click="orderAgain" class="Icon__more--element">Order Again</a>
                        <a role="button" @click="deleteDesign" class="Icon__more--element">Delete</a>
                        <a role="button" @click="useAsTemplate" class="Icon__more--element">Redesign</a>
                    </div>
                </div>
                <div class="text-center">Bracelet</div>
            </div>
        </a>
        <div class="position-relative">
            <button @click="showMore = !showMore" class="Icon__more">
                &#x22ee;
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['design', 'addClass'],
        data: function() {
            return {
                imageUrl: {
                    backgroundImage : "url('/images/"+this.design.image_name+"/1')",
                },
                showMore: false,
            }
        },
        methods: {
            openImage: function() {
                Event.$emit('open-image', this.design)
            },
            orderAgain: function() {
                alert('ordering again');
            },
            deleteDesign: function() {
                alert('deleting');
            },
            useAsTemplate: function() {
                alert('using as template');
            }
        }
    }
</script>

<style>
    .Flippable__front,
    .Flippable__back {
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transition: -webkit-transform 0.3s;
        transition: transform 0.3s;
    }

    .Flippable__back {
        -webkit-transform: rotateY(-180deg);
        transform: rotateY(-180deg);
    }
    .Card.Flippable.Flipped .Flippable__front {
        -webkit-transform: rotateY(-180deg);
        transform: rotateY(-180deg);
    }

    .Card.Flippable.Flipped .Flippable__back {
        -webkit-transform: rotateY(0);
        transform: rotateY(0);
    }
</style>