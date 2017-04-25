<template>
    <div>
        <div class="Card col-xs-12 pd-0">
           <div ref="fpd" id="fpd" class="fpd-container fpd-topbar fpd-hidden-tablets">
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
        </div>
        <div v-if="signedIn">
            <button class="Button--primary mg-btm-20" @click="continueToCheckout()">Continue</button>
        </div>
        <div v-else>
            <div class="row mg-btm-20">
                <div class="col-xs-6">
                    <button class="Button--secondary" @click="continueToCheckout(true)">Continue as user</button>
                </div>
                <div class="col-xs-6">
                    <button class="Button--primary" @click="continueToCheckout()">Continue as guest</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            productTemplate: null, 
            templateDirectory: null, 
            langJson: null, 
            categoryId: null, 
            existingDesign: {
                type: Object,
                default: function () {
                    return {}
                }
            },
        },
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
                    axios.post('/designs', {
                        base64_image: base64,
                        category_id: vm.categoryId,
                        views: JSON.stringify(vm.designer.getProduct()),
                    }).then((response) => {
                        if(throughLogin) {
                            window.location = `/login`;
                        } else {
                            window.location = `/order/${response.data.category_slug_name}`;
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
            var fpd = this.$refs.fpd;
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
                
                $('#fpd').on('ready', function() {
                    if(Object.keys(vm.existingDesign).length !== 0) {
                        Event.$emit('design-selected', vm.existingDesign)
                    }
                })
            });
        }
    }
</script>
