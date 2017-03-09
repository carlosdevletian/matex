export const carouselMixin = {
    data: function() {
        return {
            timer: null
        }
    },
    methods: {
        scrollRight: function() {
            this.timer = setInterval(function() {
                document.getElementById('carousel').scrollLeft += 5;
            }, 50);
        },
        scrollLeft: function() {
            this.timer = setInterval(function() {
                document.getElementById('carousel').scrollLeft -= 5;
            }, 50);
        },
        scrollToEnd: function() {
            var carousel = document.getElementById('carousel');
            var end = carousel.scrollWidth - carousel.clientWidth;
            document.getElementById('carousel').scrollLeft = end;
        },
        scrollToBeginning: function() {
            document.getElementById('carousel').scrollLeft = 0;
        },
        stopScroll: function() {
            clearInterval(this.timer);
        }
    },
}
