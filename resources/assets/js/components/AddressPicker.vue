<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <input class="form-control mb-8" type="email" v-model="address.email" placeholder="Email">
                <input class="form-control mb-8" type="text" v-model="address.name" placeholder="Name">
                <input class="form-control mb-8" type="text" v-model="address.street" placeholder="Street">
                <div class="row">
                    <div class="col-sm-6">
                        <input class="form-control mb-8" type="text" v-model="address.city" placeholder="City">
                    </div>
                    <div class="col-sm-6">
                        <input class="form-control mb-8" type="text" v-model="address.state" placeholder="State">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <input class="form-control mb-8" type="text" v-model="address.zip" placeholder="Zip Code">
                    </div>
                    <div class="col-sm-6">
                        <input class="form-control mb-8" type="text" v-model="address.country" placeholder="Country">
                    </div>
                </div>
                <input class="form-control mb-8" type="text" v-model="address.phone_number" placeholder="Phone Number">
                <textarea class="form-control mb-8" v-model="address.comment" placeholder="Comment"></textarea>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['address'],
    }
</script>

<style>
    .mb-8 {
        margin-bottom: 8px
    }
</style>
