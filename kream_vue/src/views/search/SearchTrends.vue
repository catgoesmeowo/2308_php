<template>
  <div class="trend">
    <div
      v-for="trend in trends"
      :key="trend.name"
      class="btn_trend"
      @click="trend__link(trend.name)">
      <img
        :src="trend.img"
        alt="트렌드"
        class="trend_img" />
      <p class="trend_name">
        {{ trend.name }}
      </p>
    </div>
  </div>
</template>

<script>
import { mapStores } from 'pinia'
import { useSearchStore } from '~/store/search'

export default {
  data() {
    return {
      trends: [
        {name: '애플', img: '/assets/search/trends/apple.png'},
        {name: '뉴발란스', img: '/assets/search/trends/newBalance.png'},
        {name: '레고', img: '/assets/search/trends/lego.png'},
        {name: '샤넬', img: '/assets/search/trends/chanel.png'},
        {name: '롤렉스', img: '/assets/search/trends/rolex.png'},
        {name: '헬리녹스', img: '/assets/search/trends/helinox.png'},
        {name: '우영미', img: '/assets/search/trends/wooyoungmi.png'},
        {name: '에어포스', img: '/assets/search/trends/airForce.png'},
        {name: '다이슨', img: '/assets/search/trends/dyson.png'},
        {name: 'IAB Studio', img: '/assets/search/trends/iab.png'}
      ]
    }
  },
  computed: {
    ...mapStores(useSearchStore)
  },
  methods: {
    async trend__link(payload) {
      if(this.searchStore.brands.find( item => item === payload)) {
        return // 이미 검색필터로 들어가있으니 아무동작하지마
      } else {
        this.searchStore.searchTags = []
        this.searchStore.brands = []
        this.searchStore.searchTags.push(payload)
        this.searchStore.brands.push(payload)
        await this.searchStore.searchProducts()
      }
    }
  }
}
</script>

<style scoped lang="scss">
@import '~/scss/SearchCommon.scss';

.trend {
    width: 1200px;
    margin: 0 auto;
    padding: 0 40px;
    display: flex;
    padding-bottom: 16px;
    .btn_trend {
      flex-grow: 1;
      width: 84px;
      height: 82px;
      margin-left: 40px;
      text-align: center;
      cursor: pointer;
      .trend_img {
        width: 70px;
        height: 70px;
        vertical-align: top;
        user-select: none;
      }
      .trend_name {
        margin-top: -2px;
        font-size: 13px;
        font-weight: 600;
      }
    }
    .btn_trend:first-child {
      margin-left: 0;
    }
  }

</style>
