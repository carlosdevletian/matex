export const carouselMixin = {
    data: function() {
        return {
            carousel: null,
            leftScroll: null,
            rightScroll: null,
        }
    },
    methods: {
        scrollRight: function() {
            this.rightScroll = setInterval(function() {
                this.carousel.scrollLeft += 5;
            }, 50);
        },
        scrollLeft: function() {
            this.leftScroll = setInterval(function() {
                this.carousel.scrollLeft -= 5;
            }, 50);
        },
        scrollToEnd: function() {
            this.carousel.scrollLeft = this.carousel.scrollWidth - this.carousel.clientWidth;
        },
        scrollToBeginning: function() {
            this.carousel.scrollLeft = 0;
        },
        stopScroll: function() {
            clearInterval(this.rightScroll);
            clearInterval(this.leftScroll);
        }
    },
    created: function() {
        this.carousel = document.getElementById('carousel');
    }
}
