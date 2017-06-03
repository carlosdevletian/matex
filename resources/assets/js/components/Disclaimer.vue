<template>
    <div>
        <div v-if="visibility" class="Card Card--disclaimer">
            <span class="Card--disclaimer__close" @click="toggleVisibility">&#10005;</span>
            <p class="Card__title text-center">Disclaimer</p>
            <p class="Card__body--disclaimer" v-html="this.disclaimer"></p>
            <a href="/faq" class="color-secondary color-hover-secondary">Go to FAQ</a>
        </div>
        <div v-else class="Card Card--disclaimer Card--disclaimer--hidden">
            <i class="fa fa-info-circle fa-2x" style="cursor: pointer; color: white; margin-left: -11px" aria-hidden="true" @click="toggleVisibility"></i>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['text'],
        data: function() {
            return {
                disclaimer: '',
                visibility : true,
            }
        },
        created: function() {
            this.disclaimer = this.text.replace(new RegExp('\r?\n','g'), '<br />');
        },
        methods: {
            toggleVisibility: function() {
                this.visibility = ! this.visibility;
            }
        }
    }
</script>