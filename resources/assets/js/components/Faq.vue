<script>
    export default {
        data() {
            return {
                elements: document.getElementsByClassName("Card__body")
            }
        },
        mounted() {
            this.deselectAll();
        },
        methods: {
            select(e) {
                this.deselectAll();

                e.target.getElementsByClassName("Card__body")[0].style.display = "";
            },
            deselectAll() {
                for (var i = 0; i < this.elements.length; i++) {
                    this.elements[i].style.display = "none";
                }
            }
        }
    }
</script>