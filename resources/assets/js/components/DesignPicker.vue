<template>
    <div class="position-relative">
        <a @mouseover="scrollLeft()" 
            @mouseout="stopScroll()" 
            @click="scrollToBeginning()" 
            class="Scroller Scroller--left" 
            role="button">
                <i class="fa fa-chevron-left Scroller__icon" aria-hidden="true"></i>
            </a>
        <a @mouseover="scrollRight()" 
            @mouseout="stopScroll()" 
            @click="scrollToEnd()" 
            class="Scroller Scroller--right" 
            role="button">
                <i class="fa fa-chevron-right Scroller__icon" aria-hidden="true"></i>
            </a>
        <div ref="carousel" class="Card Scroll__container">
            <div v-for="design in designs" class="Scroll__element col-xs-5 col-sm-4 col-md-2 mg-0">
                <design-show :design="design" add-class="width-150-px"></design-show>
            </div>
        </div>
    </div>
</template>

<script>
    import { carouselMixin } from '../mixins/carouselMixin';
    export default {
        mixins: [carouselMixin],
        props: ['designs'],
    }
</script>