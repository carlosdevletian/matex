<template>
    <div>
        <hr v-if="signedIn && existingDesigns">
        <i v-if="signedIn && existingDesigns" class="fa fa-question-circle fa-2x color-primary" aria-hidden="true" @click="help" style="position: absolute; top: 75px; right: 20px; cursor: pointer; margin-right: 10px"></i>
        <i v-else class="fa fa-question-circle fa-2x color-primary" aria-hidden="true" @click="help" style="position: absolute; top: 30px; right: 20px; cursor: pointer"></i>
        <div class="Card col-xs-12 pd-0">
           <div ref="fpd" id="fpd" class="fpd-container fpd-topbar fpd-off-canvas-left fpd-top-actions-centered fpd-bottom-actions-centered">
                <slot name="category"></slot>
                <div class="fpd-design">
                    <img v-for="symbol in symbols" 
                        :src="symbol" 
                        title="" 
                        data-parameters='{
                            "autoCenter" : true,
                            "autoSelect" : true,
                            "colors": "#000000",
                            "resizeToH" : 100,
                            "removable": true, 
                            "draggable": true, 
                            "rotatable": true, 
                            "resizable": true
                    }'/>
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
            templateDirectory: null, 
            langJson: null, 
            categoryId: null, 
            symbols: {
                type: Array,
                default: function() {
                    return []
                }
            },
            existingDesign: {
                type: Object,
                default: function () {
                    return {}
                }
            },
            existingDesigns: false
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
                Event.$emit('page-is-loading');
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
                    title: "Add a comment (Optional) <span class='Modal__close pd-0 top-0' onclick='swal.closeModal(); return false;'>&#10005;</span>",
                    html: "<div class='Modal__description'>You can add a comment for your design so our team takes it into consideration</div>",
                    input: 'textarea',
                    type: null,
                    customClass: 'Modal',
                    buttonsStyling: false,
                    showConfirmButton: true,
                    confirmButtonClass: 'Button--secondary stick-to-bottom',
                    showCancelButton: false,
                    confirmButtonText: 'Continue',
                    inputClass: 'Form',
                }).then(function (comment) {
                    vm.comment = comment;
                    vm.continue(throughLogin);
                }).catch(swal.noop);
            },
            help: function() {
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
                    progressSteps: ['1', '2', '3', '4', '5']
                })

                var steps = [
                    {
                        title: "Welcome to the Matex Designer",
                        text: 'We have a short tutorial prepared for you. To exit, press the escape key or click outside this window',
                        animation: true
                    },
                    {
                        title: "Edit the product",
                        text: 'To edit the color of the product, click on it and choose a color on the top bar',
                        imageUrl: 'http://i.imgur.com/RdtFDso.png',
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
            },
            addEventListenersForModals: function() {
                this.onEscape();
                this.onOutsideClick();
            },
            onEscape: function() {
                document.addEventListener("keydown", (e) => {
                    if (e.keyCode == 27) {
                        $('.fpd-close-off-canvas').click();
                    }
                });
            },
            onOutsideClick: function() {
                var element = document.getElementsByClassName('fpd-content')[0];
                
                this.$refs.fpd.addEventListener("click", (e) => {
                    if(! element.contains(e.target)) {
                        $('.fpd-close-off-canvas').click();
                    }
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
                    'top': ['undo', 'reset-product', 'zoom', 'redo'],
                },
                selectedColor: "#dbdee3",
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
                fonts: [
                    {name: "Roboto", url: "google",},
                    {name: "Vibur", url: "google",},
                    {name: "Bubbler One", url: "google",},
                    {name: "Lato", url: "google",},
                ],
                outOfBoundaryColor: "#FF0000",
                toolbarPlacement: "inside-top",
                hideDialogOnAdd: true,
                mainBarModules: ['products', 'images', 'text', 'designs'],
            };
            $(document).ready(function(){
                vm.designer = new FancyProductDesigner(fpd, pluginOptions);
                
                $('#fpd').on('ready', function() {

                    if(Object.keys(vm.existingDesign).length !== 0) {
                        Event.$emit('design-selected', vm.existingDesign)
                    }
                    if(! vm.signedIn) {
                        vm.help();
                    }
                    vm.addEventListenersForModals();
                })
            });
        }
    }
</script>
