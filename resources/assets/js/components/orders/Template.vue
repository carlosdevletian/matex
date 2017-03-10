<template>
    <div>
        <div class="row">
            <div class="col-sm-6">
                <div class="Card col-sm-12">
                    <h3 class="Order__title--orange text-center">
                        <slot name="items-title"></slot>
                    </h3>
                    <hr>
                    <slot name="products"></slot>
                    <slot name="items"></slot>
                    <hr>
                    <div class="position-relative">
                        <div class="Spinner">
                            <slot name="spinner"></slot>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                Subtotal:
                            </div>
                            <div class="col-xs-3 col-xs-offset-6">
                                <slot name="subtotal"></slot>
                            </div>
                        </div>
                        <slot name="zip-error"></slot>
                        <div class="row">
                            <div class="col-xs-3">
                                Shipping:
                            </div>
                            <div class="col-xs-3 col-xs-offset-6">
                                <slot name="shipping"></slot>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                Tax:
                            </div>
                            <div class="col-xs-3 col-xs-offset-6">
                                <slot name="tax"></slot>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-3">
                                Total:
                            </div>
                            <div class="col-xs-3 col-xs-offset-6">
                                <slot name="total"></slot>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="col-sm-6">
                <div class="Card col-sm-12 text-center">
                    <div class="row">
                        <h3 class="Order__title--blue">
                            <slot name="address-title"></slot>
                        </h3>
                    </div>
                    <hr>
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