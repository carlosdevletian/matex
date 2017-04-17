<template>
    <div class="mg-btm-20" :class="addClass">
        <a role="button" @click="editCategory">
            <div class="Card Card--thumbnail Flippable" :class="{ Flipped : showMore }">
                <div class="Flippable__front Thumbnail--image background-image" :style="imageUrl"></div>
                <div class="Flippable__back position-relative" @click.stop>
                    <div class="Thumbnail--image position-absolute text-center" style="width: 100%; bottom: 0">
                        <a role="button" @click="editCategory" class="Icon__more--element">Edit</a>
                        <a v-if="!! +category.is_active" role="button" @click="disableCategory" class="Icon__more--element">Disable</a>
                        <a v-else role="button" @click="enableCategory" class="Icon__more--element">Enable</a>
                    </div>
                </div>
                <div class="text-center">{{ category.name }}</div>
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
        props: ['category', 'addClass', 'imagePath'],
        data: function() {
            return {
                imageUrl: {
                    backgroundImage : `url(${this.imagePath})`,
                },
                showMore: false,
            }
        },
        methods: {
            editCategory: function() {
                window.location = `/categories/edit/${this.category.id}`
            },
            disableCategory: function() {
                axios.get(`/category/disable/${this.category.id}`)
                .then(response => {
                    location.reload()
                }).catch(error => {
                    alert('error');
                })
            },
            enableCategory: function() {
                axios.get(`/category/enable/${this.category.id}`)
                .then(response => {
                    location.reload()
                }).catch(error => {
                    alert('error');
                })
            }
        }
    }
</script>