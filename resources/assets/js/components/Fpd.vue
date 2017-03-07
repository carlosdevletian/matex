<template>
    <div>
       <div id="fpd" class="fpd-container fpd-topbar fpd-hidden-tablets">
            <div class="fpd-product" title="Titulo" data-thumbnail="#">
                <img :src="productTemplate"
                    title="Bracelet"
                    data-parameters=
                        '{"left": 340,
                        "top": 329,
                        "draggable": false,
                        "removable": false,
                        "autoCenter": true,
                        "zChangeable": false,
                        "colors": "#ffffff,#e3e3e3,#000000,#ffff80,#ff6666,#00ff80",
                        "z": 2
                        }'
                />
            </div>
        </div>
        <div v-if="signedIn">
            <button class="btn btn-default" @click="continueToCheckout()">Continue</button>
        </div>
        <div v-else>
            <button class="btn btn-default" @click="continueToCheckout(true)">Continue as user</button>
            <button class="btn btn-default" @click="continueToCheckout()">Continue as guest</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['productTemplate', 'templateDirectory', 'langJson', 'categoryId'],
        data: function() {
            return {
                designer: '',
                signedIn: Matex.signedIn
            }
        },
        methods: {
            continueToCheckout: function(throughLogin = false) {
                var vm = this;
                this.designer.getProductDataURL( function(base64) {
                    var request = {
                        base64_image: base64,
                        category_id: vm.categoryId,
                        views: JSON.stringify(vm.designer.getProduct()),
                    }
                    axios.post('/designs', request).then((response) => {
                        if(throughLogin) {
                            window.location = "/login";
                        } else {
                            window.location = "/design/" + response.data.category_slug_name + "/order";
                        }
                    }, (response) => {
                        swal({
                            title: "Ooops",
                            text: "There seems to have been an error",
                            type: "error",
                            timer: 1900,
                            showConfirmButton: false
                        }).catch(swal.noop);
                    });
                });
            },
        },
        created: function() {
            var vm = this;
            Event.$on('design-selected', function(design) {
                vm.designer.loadProduct(JSON.parse(design.views));
            })
        },
        mounted: function() {
            var vm = this;
            var fpd = document.getElementById('fpd');
            var pluginOptions = {
                stageWidth: 1200,
                stageHeight: 600,
                langJSON: this.langJson,
                templatesDirectory: this.templateDirectory,
                actions:  {
                    'top': ['download', 'snap', 'preview-lightbox'],
                    'right': ['magnify-glass', 'zoom', 'reset-product'],
                    'bottom': ['undo','redo'],
                    'left': ['manage-layers','save']
                },
                selectedColor: "#f5f5f5",
                customTextParameters: {
                    colors: "#000000,#ffffff",
                    removable: true,
                    resizable: true,
                    draggable: true,
                    rotatable: true,
                    autoCenter: true,
                    toolbarPlacement: "inside-top",
                    colors: "#e3e3e3,#000000,#ffff80,#ff6666,#00ff80",
                },
                customImageParameters: {
                    draggable: true,
                    removable: true,
                    resizable: true,
                    rotatable: true,
                    autoCenter: true,
                    z: -1,
                },
                outOfBoundaryColor: "#FF0000",
                toolbarPlacement: "inside-top",
            };
            $(document).ready(function(){
                vm.designer = new FancyProductDesigner(fpd, pluginOptions);
            });
        }
    }
</script>
