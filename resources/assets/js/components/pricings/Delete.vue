<template>
    <a role="button" @click="deletePricing" class="color-secondary">&#10005;</a>
</template>

<script>
    export default {
        props: ['pricing'],
        data() {
            return {
            }
        },
        methods: {
            deletePricing() {
                var vm = this;
                swal({
                    title: "Are you sure? <span class='Modal__close pd-0 top-0' onclick='swal.closeModal(); return false;'>&#10005;</span>",
                    text: "You won't be able to revert this!",
                    type: null,
                    customClass: 'Modal',
                    buttonsStyling: false,
                    showConfirmButton: true,
                    confirmButtonClass: 'Button--secondary stick-to-bottom',
                    showCancelButton: false,
                    confirmButtonText: 'Yes, delete it!'
                }).then(function () {
                    axios.delete(`/pricings/${vm.pricing.id}`);
                    location.reload();
                }).catch(swal.noop);
            }
        }
    }
</script>