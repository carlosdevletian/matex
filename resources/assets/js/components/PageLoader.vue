<template>
    <div class="page-background">
        <div class="center" :style="top">
          <span class="span a">
              <span class="span b">
                  <span class="span c"></span>
              </span>
          </span>
        </div>
    </div>
</template>

<script>
    export default {
      props: {
        topPosition: {
          default: '50%'
        },
      },
      computed: { 
        top() {
          return {
            top: this.topPosition
          }
        }
      }
    }
</script>

<style>
.page-background {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: radial-gradient(circle, rgba(0,0,0,0), rgba(0,0,0,0.4) 60%);
    transition: opacity .3s ease;
    overflow-y: hidden;
}
    .span {
  position: absolute;
  display: block;
  width: 60px;
  height: 60px;
  border: 3px solid #111;
  border-radius: 100%;
}

.a, .b, .c {
  animation-name: rotate;
  animation-iteration-count: infinite;
  animation-timing-function: linear;
}

.a {
  border-color: #D04343;
  animation-duration: 1500ms;
}

.b {
  border-color: #0000AA;
  animation-duration: 4500ms;
  transform-origin: 63% 63%;
  width: 40px;
  height: 40px;
}

.c {
  border-color: #F16A26;
  animation-duration: 9000ms;
  transform-origin: 74% 74%;
  width: 20px;
  height: 20px;
}


@keyframes rotate {
  0% {
    transform: rotateZ(0deg);
  }
  100% {
    transform: rotateZ(360deg);
  }
}

.center {
  z-index: 99999999;
  position: fixed;
  top: 50%;
  left: 44.6%;
}
</style>