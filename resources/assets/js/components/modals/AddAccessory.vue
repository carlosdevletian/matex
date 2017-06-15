<template>
    <modal-template @close="close()" v-cloak>
        <div slot="header" style="font-size: 13pt">
            Choose an accessory!
        </div>

        <div slot="body" class="pd-btm-50">
            <div class="row">
                <div class="Thumbnail col-xs-6 mg-btm-5" v-for="accessory in accessories">
                    <div :class = "{'Card--thumbnail--selected' : selected != null && selected.id == accessory.id }"
                    class="Card Card--thumbnail">
                        <a role="button" @click="selectAccessory(accessory)">
                            <div class="position-relative color-primary">
                                <div :style="imageUrl(accessory)" 
                                    class="Thumbnail--image background-image cursor-pointer" >
                                </div>
                            </div>
                            <div class="text-center color-primary"
                            :class = "{'color-white' : selected != null && selected.id == accessory.id }">
                                {{ accessory.name.toUpperCase() }}
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <button class="Button--secondary stick-to-bottom" @click="select" style="font-size: 13pt">Select</button>
        </div>

    </modal-template>
</template>

<script>
    export default {
        props: {
            product: {
                required: true
            },
            selectedAccessory: {
                required: false,
                default: null
            }
        },
        data() {
            return {
                accessories: null,
                selected: null,
            }
        },
        created() {
            var vm = this;
            axios.get(`/accessories/category/${this.product.category_id}`).then((response) => {
                vm.accessories = response.data.accessories
                vm.setSelected();
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
            setSelected(){
                var vm = this;
                if(vm.selectedAccessory != null) {
                    vm.accessories.forEach( function(accessory) {
                        if(accessory.id == vm.selectedAccessory.id) {
                            vm.selected = vm.selectedAccessory;
                        }
                    });
                }
            },
            selectAccessory(accessory) {
                if(this.selected != null && this.selected.id == accessory.id) {
                    this.selected = null;
                } else {
                    this.selected = accessory
                }
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
