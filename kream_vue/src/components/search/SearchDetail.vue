<template>
  <div class="content">
    <div class="inner">
      <div class="column-left">
        <div class="column__box">
          <div class="img_box">
            <img
              ref="product_img_01"
              :src="searchStore.productInfo.thumbnail"
              alt=""
              class="product_img_01 slider showing" />
            <img
              ref="product_img_02"
              :src="searchStore.productInfo.photo"
              alt=""
              class="product_img_02 slider" />
          </div>
          <div class="slider_interaction">
            <div class="btn">
              <div
                class="left"
                @click="handle">
                <i class="bi bi-chevron-left"></i>
              </div>
              <div
                class="right"
                @click="handle">
                <i class="bi bi-chevron-right"></i>
              </div>
            </div>
            <div class="showing_bar">
              <div
                ref="bar_01"
                class="bar_01 bar_on"></div>
              <div
                ref="bar_02"
                class="bar_02"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="column-right">
        <div class="info_box">
          <div class="product_title">
            <router-link
              to=""
              class="product_title__brand">
              {{ searchStore.productInfo.tags[1] }}
            </router-link>
            <p class="product_title__name">
              {{ searchStore.productInfo.title }}
            </p>
            <p class="product_title__des">
              {{ searchStore.productInfo.description }}
            </p>
          </div>
          <div class="product_price">
            <div class="size_box">
              <p class="guide_name">
                사이즈
              </p>
              <div class="size_btn">
                <p class="size_list">
                  모든사이즈
                </p>
                <i class="bi bi-caret-down-fill"></i>
              </div>
            </div>
            <div class="price_box">
              <p class="guide_name">
                최근 거래가
              </p>
              <div class="recent_price">
                <div class="price">
                  {{ searchStore.productInfo.price.toLocaleString('ko-KR') + '원' }}
                </div>
                <div class="price_percent">
                  <i class="bi bi-caret-up-fill"></i>
                  <p>2000원 상향 (+1.1%)</p>
                </div>
              </div>
            </div>
          </div>
          <div class="product_purchase">
            <div class="purchase">
              <!-- 구매 모달창 -->
              <button
                type="button"
                class="purchase_btn btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                <strong class="purchase__text">
                  구매
                </strong>
                <div class="purchase__price">
                  <div class="purchase__price_num">
                    {{ searchStore.productInfo.price.toLocaleString('ko-KR') + '원' }}
                  </div>
                  <p class="purchase__recent">
                    즉시 구매가
                  </p>
                </div>
              </button>
              <div clasee="banks">
                <PurchaseModal />
              </div>
            </div>
            <div class="interseting">
              <i class="bi bi-bookmark"></i>
              <p class="interest_product">
                관심상품 10.4만
              </p>
            </div>
          </div>
        </div>
        <PurchaseGuide />
        <div class="banner">
          <img
            src="/assets/search/banners/banner_02.png"
            alt="상품페이지 베너"
            class="banner_img" />
        </div>
      </div>
    </div>
    <BrandList />
    <BannerBottom class="BannerBottom" />
  </div>
</template>

<script>
import { mapStores } from 'pinia'
import { useSearchStore } from '~/store/search'
import PurchaseModal from '~/views/search/PurchaseModal.vue'
import PurchaseGuide from '~/views/search/PurchaseGuide.vue'
import BrandList from '~/views/layout/BrandList.vue'
import BannerBottom from '~/views/layout/BannerBottom.vue'

export default {
  components: {
    PurchaseModal,
    PurchaseGuide,
    BrandList,
    BannerBottom
  },
  data() {
    return {
      productInfo: [],
      img_num: 1,
      inner_guide: false
    }
  },
  computed: {
    ...mapStores(useSearchStore)
  },
  async created() {
    await this.searchStore.searchDetail(this.$route.params.productId)
  },
  methods: {
    handle() {
      if(this.img_num === 1) {
        this.$refs.product_img_01.classList.remove('showing')
        this.$refs.product_img_02.classList.add('showing')
        this.img_num = this.img_num + 1
        this.$refs.bar_01.classList.remove('bar_on')
        this.$refs.bar_02.classList.add('bar_on')
      } else {
        this.$refs.product_img_02.classList.remove('showing')
        this.$refs.product_img_01.classList.add('showing')
        this.img_num = this.img_num - 1
        this.$refs.bar_02.classList.remove('bar_on')
        this.$refs.bar_01.classList.add('bar_on')
      }
    },
    guide_style() {
      if(this.inner_guide) {
        this.$refs.guide.classList.add('guide_on')
      } else {
        this.$refs.guide.classList.remove('guide_on')
      }
    }
  }
}
</script>

<style scoped lang="scss">
@import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css");
@import '../../../node_modules/bootstrap/scss/bootstrap.scss'; // 부트스트랩 기본스타일

.content {
  p {
    margin-bottom: 0;
  }
  .inner {
    width: 1280px;
    display: flex;
    position: relative;
    margin: 0 auto;
    padding: 30px 40px 120px;
    .column-left {
      position: relative;
      padding-right: 3%;
      .column__box {
      position: sticky;
      top: 131px;
      .img_box {
        background-color: rgb(235, 240, 245);
        width: 560px;
        height: 560px;
        display: flex;
        justify-content: center;
        align-items: center;
        .slider {
          width: 560px;
          height: 560px;
          position: absolute;
          opacity: 0;
          transition: .6s;
        }
        .showing {
          opacity: 1;
          transition: .6s;
          z-index: 9;
        }
      }
      .slider_interaction {
        .btn {
          width: 540px;
          display: flex;
          justify-content: space-between;
          position: absolute;
          bottom: 50%;
          padding: 0 10px;
          font-size: 30px;
          color: rgba(34,34,34,.4);
          z-index: 99;
        }
        .showing_bar {
          width: 528px;
          display: flex;
          justify-content: center;
          position: absolute;
          bottom: 48px;
          text-align: center;
          padding: 0 16px;
          z-index: 99;
          .bar_01 {
            background-color: rgba(34,34,34,.1);
            width: 48%;
            height: 2px;
          }
          .bar_02 {
            background-color: rgba(34,34,34,.1);
            width: 48%;
            height: 2px;
          }
          .bar_on {
            background-color: #222;
            transition: .6s;
          }
        }
      }
    }
    }
    .column-right {
      width: 48%;
      position: relative;
      margin-left: auto;
      padding-left: 3%;
      &::before {
        content: "";
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        border-left: 1px solid #ebebeb;
      }
      .info_box {
        .product_title {
          .product_title__brand {
            display: inline-block;
            padding-top: 1px;
            margin-bottom: 14px;
            font-size: 18px;
            line-height: 19px;
            letter-spacing: -.27px;
            font-weight: 800;
            border-bottom: 2px solid #222;
            &:hover {
              color: #222;  
            }
          }
          .product_title__name {
            margin-bottom: 8px;
            font-size: 18px;
            font-weight: 400;
          }
          .product_title__des {
            font-size: 14px;
            color: rgba(34,34,34,.5);
          }
        }
        .product_price {
          .size_box {
            display: flex;
            justify-content: space-between;
            padding-top: 19px;
            padding-bottom: 12px;
            border-bottom: 1px solid #ebebeb;
            .size_btn {
              display: flex;
              align-items: center;
              .size_list {
                font-size: 16px;
                font-weight: 600;
                margin-right: 5px;
                text-decoration: line-through;
              }
              .bi-caret-down-fill {
                font-size: 14px;
              }
            }
          }
          .price_box {
            min-height: 44px;
            display: flex;
            justify-content: space-between;
            margin-top: 11px;
            .recent_price {
              .price{
                display: block;
                margin-left: auto;
                line-height: 26px;
                font-size: 20px;
                letter-spacing: -.1px;
                font-weight: 600;
                text-align: right;
              }
              .price_percent {
                display: flex;
                justify-content: end;
                align-items: center;
                margin-top: 4px;
                font-size: 13px;
                color: #f15746;
                .bi-caret-up-fill {
                  margin: 1px 6px 0 0;
                  
                }
              }
            }
          }
          .guide_name {
            padding-top: 4px;
            display: inline-block;
            font-size: 13px;
            color: rgba(34,34,34,.8);
          }
        }
        .product_purchase {
          height: 60px;
          display: flex;
          margin-top: 17px;
          .purchase {
            flex-grow: 1;
            background-color: #ef6253;
            margin-right: 10px;
            border-radius: 10px;
            .purchase_btn {
              background-color: rgb(0, 0, 0, 0);
              width: 100%;
              height: 100%;
              display: flex;
              align-items: center;
              position: relative;
              padding: 6px 0;
              color: #fff;
              border: none;
              border-radius: none;
              box-shadow: none;
              &::before {
                content: "";
                position: absolute;
                top: 0;
                bottom: 0;
                left: 55px;
                width: 1px;
                background-color: rgba(34,34,34,.1);
              }
              .purchase__text {
                width: 55px;
                text-align: center;
                font-size: 18px;
                font-weight: 600;
              }
              .purchase__price {
                margin-left: 10px;
                text-align: left;
                .purchase__price_num {
                  font-size: 15px;
                  font-weight: 700;
                }
                .purchase__recent {
                  margin-bottom: 0;
                  font-size: 11px;
                  font-weight: 600;
                  color: rgba(255, 255, 255, 0.8);
                }
              }
            }
          }
          .interseting {
            flex-grow: 1;
            display: flex;
            align-items: center;
            position: relative;
            border: 1px solid #ebebeb;
            border-radius: 10px;
            color: #333;
            &::before {
                content: "";
                position: absolute;
                top: 0;
                bottom: 0;
                left: 55px;
                width: 1px;
                background-color: rgba(34,34,34,.1);
              }
            .bi-bookmark {
              width: 55px;
              text-align: center;
              font-size: 18px;
            }
            .interest_product {
              margin-left: 10px !important;
              font-size: 16px;
              font-weight: 400;
              color: rgba(34, 34, 34, 0.9);
            }
          }
        }
      }
      .banner {
        background-color: #DBE1BF;
        width: 100%;
        text-align: center;
        .banner_img {
          height: 80px;
        }
      }
    }
    
  }
}
a {
  color: #222;
  text-decoration: none;
}
.modal {
  z-index: 99999999;
}
.BannerBottom {
  height: 360px;
}
</style>
