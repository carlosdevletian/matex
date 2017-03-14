export const carouselMixin = {
    data() {
        return {
            timer: null,
            carousel: null,
        }
    },
    methods: {
        scrollRight() {
            this.timer = setInterval(() => {
                this.carousel.scrollLeft += 5;
            }, 50);
        },
        scrollLeft() {
            this.timer = setInterval(() => {
                this.carousel.scrollLeft -= 5;
            }, 50);
        },
        scrollToEnd() {
            this.carousel.scrollLeft = this.carousel.scrollWidth - this.carousel.clientWidth;
        },
        scrollToBeginning() {
            this.carousel.scrollLeft = 0;
        },
        stopScroll() {
            clearInterval(this.timer);
        }
    },
    mounted() {
        this.carousel = this.$refs.carousel;
    }
}
