<template>
    <div class="mg-btm-20" :class="addClass">
        <div class="Card Card--thumbnail Flippable" :class="{ Flipped : showMore }">
            <a role="button" @click="openImage">
                <div class="Flippable__front Thumbnail--image background-image" :style="imageUrl"></div>
            </a>
            <div class="Flippable__back position-relative" @click.stop>
                <div class="Thumbnail--image position-absolute text-center" style="width: 100%; bottom: 0;display: flex; justify-content: center; flex-direction: column">
                    <a role="button" v-if="!!+design.category.is_active" @click="orderAgain" class="Icon__more--element Icon__more--element--no-border">Order Again</a>
                    <a role="button" @click="deleteDesign" class="Icon__more--element">Delete</a>
                    <a role="button" v-if="!!+design.category.is_active" @click="redesign" class="Icon__more--element">Redesign</a>
                </div>
            </div>
            <div class="Thumbnail__text text-center">{{ design.category.name }}</div>
        </div>
        <div class="position-relative" v-if="! admin">
            <button @click="showMore = !showMore" class="Icon__more">
                &#x22ee;
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['design', 'addClass', 'admin'],
        data: function() {
            return {
                imageUrl: {
                    backgroundImage : `url(/images/${this.design.image_name}/1)`,
                },
                showMore: false,
            }
        },
        methods: {
            openImage: function() {
                Event.$emit('open-image', this.design)
            },
            orderAgain: function() {
                window.location = `/order/${this.design.category.slug_name}/${this.design.id}`;
            },
            deleteDesign: function() {
                var vm = this;
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'rgb(0, 0, 170)',
                    cancelButtonColor: 'rgb(208,67,40)',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function () {
                    axios.delete(`/designs/${vm.design.id}`).then(response => {
                        location.reload();
                    }).catch(error => {
                        swal(
                            'An error occurred',
                            'Please try again later',
                            'error'
                        )
                    });
                })
            },
            redesign: function() {
                window.location = `/design/${this.design.category.slug_name}/${this.design.id}`;
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