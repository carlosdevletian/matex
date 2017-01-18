<template>
    <div class="row">
        <div class="col-xs-6">
            <button @click="hidden=true">+</button>
            <select multiple v-if="hidden" v-model="currentSelected" @change="updateSelectedProducts()">
                <option :value="[product.name, product.id]" v-for="product in products">
                    {{ product.name }}
                </option>
            </select>

            <div v-for="item in selected">
                <item :item="item"></item>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['categoryId'],
        data: function() {
            return {
                'products' : '',
                'currentSelected': [],
                'selected' : [],
                'hidden' : false
            };
        },
        mounted: function () {
           this.$http.get('/category/' + this.categoryId + '/products').then((response) => {
                this.products = response.body;
           });
        },
        methods: {
            updateSelectedProducts: function() {
                if(! this.alreadySelected()) {
                    this.hidden = false;
                    var item = {
                        name : this.currentSelected[0][0],
                        id : this.currentSelected[0][1]
                    };
                    this.selected.push(item);
                }
            },
            alreadySelected: function() {
                var vm = this;
                var selected = false;

                this.selected.forEach(function(item) {
                    if (item.id == vm.currentSelected[1]) {
                        selected = true;
                    }
                });
                return selected;
            }
        }
    }
</script>