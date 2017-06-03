<template>
    <div class="mg-btm-20" :class="addClass">
        <a role="button" @click="onClick">
            <div class="Card Card--thumbnail Flippable" :class="{ Flipped : showMore }">
                <div class="Flippable__front Thumbnail--image background-image" :style="imageUrl"></div>
                <div class="Flippable__back position-relative" @click.stop>
                    <div class="Thumbnail--image position-absolute text-center" style="width: 100%; bottom: 0;display: flex; justify-content: center; flex-direction: column">
                        <a role="button" @click="editAccessory" class="Icon__more--element Icon__more--element--no-border">Edit</a>
                        <a v-if="!! +accessory.is_active" role="button" @click="disableAccessory" class="Icon__more--element">Disable</a>
                        <a v-else role="button" @click="enableAccessory" class="Icon__more--element">Enable</a>
                    </div>
                </div>
                <div class="text-center">{{ accessoryName() }}</div>
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
        props: ['accessory', 'addClass', 'imagePath'],
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
                return this.editAccessory();
            },
            editAccessory: function() {
                window.location = `/accessories/${this.accessory.id}`
            },
            disableAccessory: function() {
                axios.get(`/accessory/disable/${this.accessory.id}`)
                .then(response => {
                    location.reload()
                }).catch(error => {
                    alert('error');
                })
            },
            enableAccessory: function() {
                axios.get(`/accessory/enable/${this.accessory.id}`)
                .then(response => {
                    location.reload()
                }).catch(error => {
                    alert('error');
                })
            },
            accessoryName: function() {
                return `${this.accessory.name.charAt(0).toUpperCase()}${this.accessory.name.slice(1)}`;
            },
        }
    }
</script>