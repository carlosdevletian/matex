<template>
    <div class="page-background">
        <div class="center">
          <span class="span outer">
              <span class="span middle">
                  <span class="span inner"></span>
              </span>
          </span>
        </div>
    </div>
</template>
  
<script>
    export default {
    }
</script>
  
<style>
  .page-background {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    padding: 10px;
    background-color: transparent;
    position: fixed;
    z-index: 9998;
    background-image: radial-gradient(circle, rgba(0,0,0,0), rgba(0,0,0,0.4) 60%);
    transition: opacity .3s ease;
  }
  .span {
    position: absolute;
    display: block;
    width: 60px;
    height: 60px;
    border: 3px solid #111;
    border-radius: 100%;
  }

  .outer, .middle, .inner {
    animation-name: rotate;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
  }

  .outer {
    border-color: #D04343;
    animation-duration: 1500ms;
  }

  .middle {
    border-color: #0000AA;
    animation-duration: 4500ms;
    transform-origin: 63% 63%;
    width: 40px;
    height: 40px;
  }

  .inner {
    border-color: #F16A26;
    animation-duration: 9000ms;
    transform-origin: 74% 74%;
    width: 20px;
    height: 20px;
  }

  .center {
    margin: auto;
    padding-right: 60px;
    z-index: 99999999;
  }

  @keyframes rotate {
    0% {
      transform: rotateZ(0deg);
    }
    100% {
      transform: rotateZ(360deg);
    }
  }
</style>