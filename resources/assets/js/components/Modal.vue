<template>
    <transition name="modal"> 
        <div class="Modal__background" @click="$emit('close')">
            <div class="Modal" @click.stop>
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
        mounted: function () {
            document.addEventListener("keydown", (e) => {
              if (e.keyCode == 27) {
                    this.$emit('close');
                }
            });
        }
    }
</script>