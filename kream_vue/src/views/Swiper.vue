<template>
  <swiper 
    :slides-per-view="1"
    :effect="'fade'"
    :space-between="30"
    :loop="true"
    :navigation="true"
    :pagination="{
      clickable: true,
    }"
    :autoplay=" {
      delay: 5000,
      disableOnInteraction: true
    }"
    :modules="modules"
    class="mySwiper">
    <swiper-slide class="slide slide-item-01">
      <img
        class="test slide-item_img"
        src="/assets/home/swiper/swiper_01.jpg"
        alt="럭키 드로우" />
    </swiper-slide>
    <swiper-slide class="slide slide-item-02">
      <img
        class="slide-item_img"
        src="/assets/home/swiper/swiper_02.jpg"
        alt="Dior 오블리크 컬렉션" />
    </swiper-slide>
    <swiper-slide class="slide slide-item-03">
      <img
        class="slide-item_img"
        src="/assets/home/swiper/swiper_03.jpg"
        alt="메종 미하라 야스히로" />
    </swiper-slide>
    <swiper-slide class="slide slide-item-04">
      <img
        class="slide-item_img"
        src="/assets/home/swiper/swiper_04.jpg"
        alt="조던 스타일링" />
    </swiper-slide>
  </swiper>
</template>
<script>
import { Swiper, SwiperSlide } from 'swiper/vue'

import 'swiper/css'
import 'swiper/css/effect-fade'
import 'swiper/css/navigation'
import 'swiper/css/pagination'

import { EffectFade, Autoplay, Navigation, Pagination } from 'swiper'
export default {
  components: {
    Swiper,
    SwiperSlide,
  },
  setup() {
    return {
      modules: [EffectFade, Autoplay, Navigation, Pagination],
    }
  },

}
</script>

<style lang="scss">
.swiper {
  width: 100%;
  height: 480px;
}
.slide {
  display: flex;
  justify-content: center;
  cursor: pointer;
}
.slide-item-01 {
  background-color: rgb(227, 244, 219);
}
.slide-item-02 {
  background-color: rgb(222, 227, 228); 
}
.slide-item-03 {
  background-color: rgb(255, 252, 217); 
}
.slide-item-04 {
  background-color: rgb(245, 245, 245);
}
.slide-item_img {
  height: 100%;
  object-fit: cover;
}
.swiper-button-prev, .swiper-button-next{
  width: 22px;
  height: 41px;
  background:no-repeat center center / 100%;
}
.swiper-button-prev {
  background-image: url(/assets/home/swiper/prev-button.png);
  left: 30px;
}
.swiper-button-next {
  background-image: url(/assets/home/swiper/next-button.png);
  right: 30px;
}
.swiper-button-next::after,
.swiper-button-prev::after {
  display: none;
}
.swiper-pagination {
  bottom: 18px !important;
}
.swiper-pagination-bullet {
  background-color: $color-black;
}

</style>
