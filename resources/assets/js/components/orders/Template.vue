<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <div class="Card Card--double-pd col-sm-12">
                    <div class="row">
                        <div class="Order__title--orange text-center">
                            <slot name="items-title"></slot>
                        </div>
                    </div>
                    <div class="row"><hr></div>
                    <div class="row"><slot name="products"></slot></div>
                    <div class="row"><slot name="table-header"></slot></div>
                    <div class="row"><slot name="items"></slot></div>
                    <div class="row"><hr></div>
                    <div class="position-relative">
                        <div class="Spinner">
                            <slot name="spinner"></slot>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                Subtotal:
                            </div>
                            <div class="col-xs-2 col-xs-offset-6">
                                <p class="text-center"><slot name="subtotal"></slot></p>
                            </div>
                        </div>
                        <slot name="zip-error"></slot>
                        <div class="row">
                            <div class="col-xs-4">
                                Shipping:
                            </div>
                            <div class="col-xs-2 col-xs-offset-6">
                                <p class="text-center">
                                    <slot name="shipping"></slot>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                Tax:
                            </div>
                            <div class="col-xs-2 col-xs-offset-6">
                                <p class="text-center">
                                    <slot name="tax"></slot>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-4">
                                Total:
                            </div>
                            <div class="col-xs-2 col-xs-offset-6">
                                <p class="text-center">
                                    <slot name="total"></slot>
                                </p>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="col-md-6">
                <div class="Card Card--double-pd col-sm-12 text-center">
                    <div class="row">
                        <div class="Order__title--blue">
                            <slot name="address-title"></slot>
                        </div>
                    </div>
                    <div class="row"><hr></div>
                    <div class="row">
                        <slot name="address-picker"></slot>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <slot name="buttons"></slot>
        </div>
    </div>
</template>

<script>
    export default {
    }
</script>