<template>
    <div>
        <div v-if="visibility" class="Card Card--disclaimer">
            <span class="Card--disclaimer__close" @click="toggleVisibility">&#10005;</span>
            <p class="Card__title text-center">Disclaimer</p>
            <p class="Card__body--disclaimer">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua.<br><br>Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat.<br><br>Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
            <a href="/faq" class="color-secondary color-hover-secondary">Go to FAQ</a>
        </div>
        <div v-else class="Card Card--disclaimer Card--disclaimer--hidden">
            <i class="fa fa-info-circle fa-2x" style="cursor: pointer; color: white; margin-left: -11px" aria-hidden="true" @click="toggleVisibility"></i>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                visibility : true,
            }
        },
        methods: {
            toggleVisibility: function() {
                this.visibility = ! this.visibility;
            }
        }
    }
</script>