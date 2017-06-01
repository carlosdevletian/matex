<template>
    <modal-template @close="close()" v-cloak>
        <div slot="header">
            Choose an accessory!
        </div>

        <div slot="body" class="pd-btm-50">
            <div class="Card Card--thumbnail" v-for="accessory in accessories">
                <a href="#" role="button" @click="selectAccessory(accessory)">
                    <div class="position-relative color-primary">
                        <div class="Thumbnail--image background-image" 
                            :style="imageUrl(accessory)" >
                        </div>
                        <div class="selectedAccessory" 
                            v-show="selected == accessory.id">
                                &#10004;
                        </div>
                    </div>
                    <div class="text-center color-primary">{{ accessory.name.toUpperCase() }}</div>
                </a>
            </div>
            <button class="Button--secondary stick-to-bottom" @click="select">Select</button>
        </div>

    </modal-template>
</template>

<script>
    export default {
        props: {
            product: {
                required: true
            }
        },
        data() {
            return {
                accessories: null,
                selected: null,
            }
        },
        created() {
            axios.get(`/accessories/category/${this.product.category_id}`).then((response) => {
                this.accessories = response.data.accessories
            });
        },
        methods: {
            close: function () {
                this.$emit('close');
            },
            select() {
                this.$emit('accessory-selected', this.selected);
                this.close();
            },
            selectAccessory(accessory) {
                this.selected = accessory.id
            },
            imageUrl: function(accessory) {
                return {
                    backgroundImage : `url(${accessory.image_path})`,
                }
            }
        },
    }
</script>

<style>
    .selectedAccessory {
        background-image: radial-gradient(circle, rgba(0,0,0,0), rgba(0,0,0,0.4) 60%); 
        position: absolute; 
        width: 100%; 
        height: 100%; 
        top: 0; 
        left: 0; 
        display: flex; 
        justify-content: center; 
        align-items: center; 
        font-size: 50px;
    }
</style>
