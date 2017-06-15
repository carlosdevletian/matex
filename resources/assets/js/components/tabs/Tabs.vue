<template>
    <div>
        <div class="Tabs text-center" style="margin-bottom: 0" :style="headerStyles">
            <ul ref="header">
                <li v-for="tab in tabs" :class="{ 'Tab--active' : tab.isActive }">
                    <a role="button" @click="selectTab(tab)">
                        {{ tab.name | ucfirst }}
                    </a>
                </li>
            </ul>
        </div>
        <div class="tabs-details">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['headerStyles'],
        data() {
            return {
                tabs: []
            }
        },
        created() {
            this.tabs = this.$children
        },
        methods: {
            selectTab(selectedTab) {
                this.tabs.forEach(tab => {
                    tab.isActive = (tab.name == selectedTab.name)
                })
            }
        },
    }
</script>

<style>
    .Tabs > ul {
        padding: 0;
        padding-bottom: 7px;
        border-bottom: 1px solid #0000AA;
    }
    .Tabs > ul > li {
        border: 1px solid lightgrey;
        padding: 10px;
        border-radius: 5px 5px 0 0;
        border-bottom: none;
        display: inline;
    }
    .Tabs > ul > li> a{
        color: inherit;
    }
    .Tab--active {
        color: #0000AA;
        border: 1px solid #0000AA !important;
        border-bottom: 1px solid white !important;
    }
</style>
