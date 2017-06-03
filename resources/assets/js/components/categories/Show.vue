<template>
    <div class="mg-btm-20" :class="addClass">
        <a role="button" @click="onClick">
            <div class="Card Card--thumbnail" :class="{ Flipped : showMore, Flippable : isAdmin}">
                <div class="Flippable__front Thumbnail--image background-image" :style="imageUrl"></div>
                <div class="Flippable__back position-relative" @click.stop>
                    <div class="Thumbnail--image position-absolute text-center" style="width: 100%; bottom: 0">
                        <a role="button" @click="accessories" class="Icon__more--element">Accessories</a>
                        <a role="button" @click="designs" class="Icon__more--element">Designs</a>
                        <a v-if="!! +category.is_active" role="button" @click="disableCategory" class="Icon__more--element">Disable</a>
                        <a v-else role="button" @click="enableCategory" class="Icon__more--element">Enable</a>
                    </div>
                </div>
                <div class="text-center">{{ categoryName() }}</div>
            </div>
        </a>
        <div v-if="isAdmin" class="position-relative">
            <button @click="showMore = !showMore" class="Icon__more">
                &#x22ee;
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['category', 'addClass', 'imagePath', 'isAdmin'],
        data: function() {
            return {
                imageUrl: {
                    backgroundImage : `url(${this.imagePath})`,
                },
                showMore: false,
            }
        },
        methods: {
            onClick: function() {
                if(this.isAdmin) {
                    return this.editCategory();
                }
                return this.categoryIndex();
            },
            categoryIndex: function() {
                window.location = `/design/${this.category.slug_name}`
            },
            editCategory: function() {
                window.location = `/categories/edit/${this.category.id}`
            },
            designs: function() {
                window.location = `/categories/designs/${this.category.id}`
            },
            accessories: function() {
                window.location = `/categories/accessories/${this.category.id}`
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
            },
            categoryName: function() {
                return `${this.category.name.charAt(0).toUpperCase()}${this.category.name.slice(1)}`;
            },
        }
    }
</script>