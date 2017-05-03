<template>
    <div>
        <div class="Card col-xs-12 pd-0">
           <div ref="fpd" id="fpd" class="fpd-container fpd-topbar fpd-hidden-tablets fpd-top-actions-centered fpd-bottom-actions-centered">
                <div class="fpd-product" title="Titulo" data-thumbnail="#">
                    <img :src="productTemplate"
                        title="Bracelet"
                        data-parameters=
                            '{
                            "draggable": false,
                            "removable": false,
                            "autoCenter": true,
                            "zChangeable": false,
                            "colors": [],
                            "z": 2
                            }'
                    />
                </div>
            </div>
        </div>
        <div v-if="signedIn">
            <button class="Button--primary mg-btm-20" @click="checkout()">Continue</button>
        </div>
        <div v-else>
            <div class="row mg-btm-20">
                <div class="col-xs-6">
                    <button class="Button--secondary" @click="checkout(true)">Continue as user</button>
                </div>
                <div class="col-xs-6">
                    <button class="Button--primary" @click="checkout()">Continue as guest</button>
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
                comment: null,
                signedIn: Matex.signedIn,
            }
        },
        methods: {
            continue: function(throughLogin = false) {
                var vm = this;
                this.designer.getProductDataURL( function(base64) {
                    axios.post('/designs', {
                        base64_image: base64,
                        category_id: vm.categoryId,
                        views: JSON.stringify(vm.designer.getProduct()),
                        comment: vm.comment
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
            checkout: function(throughLogin = false) {
                var vm = this;
                swal({
                    title: "Add a comment <span class='Modal__close pd-0 top-0' onclick='swal.closeModal(); return false;'>&#10005;</span>",
                    html: "<div class='Modal__description'>Tell us something relevant about your design</div>",
                    input: 'textarea',
                    type: null,
                    customClass: 'Modal',
                    buttonsStyling: false,
                    showConfirmButton: true,
                    confirmButtonClass: 'Button--secondary stick-to-bottom',
                    showCancelButton: false,
                    confirmButtonText: 'Continue',
                    inputPlaceholder: 'Your comment goes here. Or leave blank if not necessary',
                    inputClass: 'Form',
                }).then(function (comment) {
                    vm.comment = comment;
                    vm.continue(throughLogin);
                }).catch(swal.noop);
            },
            addEventListenersForModals: function() {
                var modal = document.getElementsByClassName('fpd-draggable-dialog');
                this.onEscape(modal);
                this.onOutsideClick(modal);
                // this.onElementAdded(modal);
            },
            onEscape: function(modal) {
                document.addEventListener("keydown", (e) => {
                    if (modal && e.keyCode == 27) {
                        $(modal).removeClass("fpd-active");
                    }
                });
            },
            onOutsideClick: function(modal) {
                this.$refs.fpd.addEventListener("click", (e) => {
                    if(modal && e.target != modal) {
                        $(modal).removeClass("fpd-active");
                    }
                });
            },
            onElementAdded: function(modal) {
                $('#fpd').bind("elementAdd", (e) => {
                    if(modal && e.target != modal) {
                        $(modal).removeClass("fpd-active");
                    }
                })
            }
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
                    'top': ['manage-layers','magnify-glass', 'zoom', 'reset-product'],
                    'bottom': ['undo','redo'],
                },
                selectedColor: "#f5f5f5",
                customTextParameters: {
                    removable: true,
                    resizable: true,
                    draggable: true,
                    rotatable: true,
                    autoCenter: true,
                    toolbarPlacement: "inside-top",
                    colors: []
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
                hideDialogOnAdd: true,
                mainBarModules: ['images', 'text', 'designs'],
            };
            $(document).ready(function(){
                vm.designer = new FancyProductDesigner(fpd, pluginOptions);
                
                $('#fpd').on('ready', function() {
                    if(Object.keys(vm.existingDesign).length !== 0) {
                        Event.$emit('design-selected', vm.existingDesign)
                    }
                    vm.addEventListenersForModals();
                })
            });

            swal.setDefaults({
                type: null,
                customClass: 'Modal',
                buttonsStyling: false,
                showConfirmButton: true,
                confirmButtonClass: 'Button--secondary stick-to-bottom',
                confirmButtonText: 'Finish Tutorial',
                showCancelButton: false,
                animation: false,
                imageWidth: 300,
                imageHeight: 150,
                confirmButtonText: 'Next',
                progressSteps: ['1', '2', '3', '4']
            })

            var steps = [
                {
                    title: "Welcome to the Matex Designer",
                    text: 'We have a short tutorial prepared for you!',
                    animation: true
                },
                {
                    title: "Edit an Object",
                    text: 'To edit an object click on it, a series of options will appear (change color, size, delete, rotate)',
                    imageUrl: 'http://i.imgur.com/66pIoZY.png',
                },
                {
                    title: "Add Text",
                    text: 'You can add text by clicking the "Add Text" button, then you can style it to your liking',
                    imageUrl: 'http://i.imgur.com/1IFmy8K.png',
                },
                {
                    title: "Add Images",
                    text: 'To add images you can click the "Add Image" button, you may drag and drop your image or select it from your files',
                    confirmButtonText: 'Finish Tutorial',
                    imageUrl: 'http://i.imgur.com/IX1jQWP.png',
                }
            ];

            swal.queue(steps).then(function (result) {
                swal.resetDefaults()
            }, function () {
                swal.resetDefaults()
            }).catch(swal.noop);
        }
    }
</script>
