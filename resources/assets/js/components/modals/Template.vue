<template>
    <transition name="modal"> 
        <div class="Modal__background" @click="$emit('close')" :style="addOverflow">
            <div class="Modal" :class="childClassObject" @click.stop>
                <span class="Modal__close" @click="$emit('close')">&#10005;</span>
                <div class="Modal__header">
                    <slot name="header"></slot>
                </div>
                <div class="Modal__description">
                    <slot name="description"></slot>
                </div>
                <div class="Modal__body">
                    <slot name="body"></slot>
                </div>
                <div class="Modal__footer">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: {
            childClassObject: {
                type: Object,
                default: function () {
                    return {}
                }
            },
            overflowY: {
                type: Boolean,
                default: false
            },
        },
        computed: {
            addOverflow() {
                if(this.overflowY) {
                    return {
                        overflowY : 'scroll'
                    }
                }
            }
        },
        mounted: function () {
            document.addEventListener("keydown", (e) => {
              if (e.keyCode == 27) {
                    this.$emit('close');
                }
            });
        },
    }
</script>