<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <div class="Card Card--double-pd col-sm-12">
                    <div class="row">
                        <div class="Order__title">
                            <slot name="items-title"></slot>
                        </div>
                    </div>
                    <div class="row"><hr></div>
                    <div class="row scroll-x"><slot name="products"></slot></div>
                    <div class="row Order__table-header"><slot name="table-header"></slot></div>
                    <div class="row Order__items"><slot name="items"></slot></div>
                    <div class="position-relative Order__prices">
                        <div class="Order__prices--subtotal">
                            <hr>
                            <div class="Spinner">
                                <slot name="spinner"></slot>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    Subtotal:
                                </div>
                                <div class="col-xs-3 col-xs-offset-5">
                                    <p class="text-center no-wrap"><slot name="subtotal"></slot></p>
                                </div>
                            </div>
                            <slot name="zip-error"></slot>
                            <div class="row">
                                <div class="col-xs-4">
                                    Shipping:
                                </div>
                                <div class="col-xs-3 col-xs-offset-5">
                                    <p class="text-center no-wrap">
                                        <slot name="shipping"></slot>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    Tax:
                                </div>
                                <div class="col-xs-3 col-xs-offset-5">
                                    <p class="text-center no-wrap">
                                        <slot name="tax"></slot>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row Order__prices--total">
                            <hr>   
                            <div class="col-xs-4">
                                Total:
                            </div>
                            <div class="col-xs-3 col-xs-offset-5">
                                <p class="text-center no-wrap">
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
                        <div class="Order__title Order__title--blue">
                            <slot name="address-title"></slot>
                        </div>
                    </div>
                    <div class="row"><hr></div>
                    <div class="row Order__address">
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