<template>
  <div class="goods_datail">
    <div class="content_title">
      <div class="title">
        <h3>구매 상세 내역</h3>
      </div>
    </div>
    <div class="detail_id">
      <h4>주문번호<span class="id">{{ userStore.transactionDetail.detailId }}</span></h4>
      <span class="purchase_date">{{ `주문 일자 ${purchaseDate}` }}</span>
    </div>
    <div class="item_list">
      <div class="item_img">
        <img
          :src="userStore.transactionDetail.product.thumbnail"
          alt="제품 사진" />
      </div>
      <div class="item_info">
        <div class="title">
          <p class="brand">
            {{ userStore.transactionDetail.product.tags[1] }}
          </p>
          <p class="name">
            {{ userStore.transactionDetail.product.title }}
          </p>
          <p class="desc">
            {{ userStore.transactionDetail.product.description }}
          </p>
        </div>
      </div>
      <div class="item_link">
        <RouterLink :to="`/search/${userStore.transactionDetail.product.productId}`">
          <button
            class="btn">
            상품 상세보기
          </button>
        </RouterLink>
      </div>
    </div>
    <div class="purchase_info">
      <div class="info_title">
        <h4>결제 내역</h4>
      </div>
      <div class="price_box">
        <div class="title">
          총 결제금액
        </div>
        <div class="price">
          {{ `${userStore.transactionDetail.product.price.toLocaleString()}원` }}
        </div>
      </div>
      <div class="payment">
        <div class="price_detail">
          <div class="purchase_price">
            <div>구매가</div>
            <div>{{ userStore.transactionDetail.product.price.toLocaleString() }}</div>
          </div>
          <div class="inspection_price">
            <div>검수비</div>
            <div>무료</div>
          </div>
          <div class="shipping_price">
            <div>배송비</div>
            <div>무료 이벤트</div>
          </div>
        </div>
        <div class="way">
          <div class="way_title">
            <h5>결제 상세</h5>
          </div>
          <div class="way_info">
            <div class="title">
              간편 결제 (계좌이체)
            </div>
            <div class="bank-name">
              {{ userStore.transactionDetail.account.bankName }}
            </div>
            <div class="bank-account-number">
              {{ `(${accountNumber})` }}
            </div>
            <div class="price">
              {{ `${userStore.transactionDetail.product.price.toLocaleString()}원` }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="btn">
      <button
        v-show="!userStore.transactionDetail.isCanceled"
        class="done"
        :disabled="userStore.transactionDetail.done"
        :class="{ disabled: userStore.transactionDetail.done}"
        @click="done(userStore.transactionDetail.detailId)">
        구매확정
      </button>
      <button
        v-show="!userStore.transactionDetail.done"
        class="cancel"
        :disabled="userStore.transactionDetail.isCanceled"
        :class="{ disabled: userStore.transactionDetail.isCanceled}"
        @click="cancel(userStore.transactionDetail.detailId)">
        구매취소
      </button>
      <button
        class="list_back"
        @click="$router.back">
        목록
      </button>
    </div>
  </div>
</template>

<script>
import { mapStores } from 'pinia'
import { useUserStore } from '~/store/user'

export default {
  data () {
    return {
      accountNumber: '',
      purchaseDate: ''
    }
  },
  computed: {
    ...mapStores(useUserStore)    
  },
  async created() {
    await this.userStore.getTransactionDetail(this.$route.params.id)
    
    this.accountNumber = this.userStore.transactionDetail.account.accountNumber.replace(/X/g, '●')
    this.purchaseDate = new Date(this.userStore.transactionDetail.timePaid).toLocaleString()
  },
  methods: {
    async done(value) {
      await this.userStore.transactionDone(value)
    },
    cancel(value) {
      this.userStore.transactionCancel(value)
    }
  }
}
</script>

<style lang="scss" scoped>
.goods_datail {
  .content_title {
    padding: 5px 0 6px;
    .title {
      font-size: 24px;
      font-weight: 700;
    }
  }
  .detail_id {
    display: flex;
    justify-content: space-between;
    align-content: center;
    margin-top: 30px;
    border-bottom: 2px solid #222;
    h4 {
      padding-bottom: 15px;
      font-size: 18px;
      .id {
        margin-left: 5px;
        font-weight: 700;
      }
    }
    .purchase_date {
      font-size: 13px;
    }
  }
  .item_list {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 25px 0px;
    .item_img {
      max-width: 120px;
      border-radius: 10px;
      overflow: hidden;
      background-color: #f5f5f5;
      img {
        width: 100%;
      }
    }
    .item_info {
      flex-grow: 1;
      margin-left: 16px;
      .title {
        > p {
          margin-bottom: 10px;
          &:last-child {
            margin-bottom: 0;
          }
        }
        .brand {
          margin-bottom: 15px;
          font-weight: 700;
          color: #333;
        }
        .name {
          color: #222;
        }
        .desc {
          font-size: 14px;
          color: #555;
        }
      }
    }
    .item_link {
      flex-shrink: 0;
      .btn {
        padding: 3px 15px;
        font-size: 12px;
        background-color: #FFF;
        border: 1px solid #D3D3D3;
        border-radius: 10px;  
        height: 34px;
        color: rgba(#222, .8);
        cursor: pointer;
      }
    }
  }
  .purchase_info {
    margin-top: 80px;
    .info_title {
      padding: 5px 0;
      border-bottom: 3px solid #222;
      h4 {
        font-size: 18px;
        font-weight: 700;
      }
    }
    .price_box {
      display: flex;
      padding: 40px 20px;
      background-color: #FAFAFA;
      border-bottom: 1px solid #ebebeb;
      .title {
        flex-grow: 1;
        font-size: 15px;
        font-weight: 700;
        line-height: 18px
      }
      .price {
        // flex-grow: 1;
        font-size: 18px;
        font-weight: 700;
        color: #f15746;
      }
    }
    .payment {
      margin-top: 20px;
      .price_detail {
        display: flex;
        flex-grow: 1;
        flex-direction: column;
        padding: 30px 20px;
        border-bottom: 1px solid #ebebeb;
        > div {
          display: flex;
          justify-content: space-between;
          padding: 10px 0;
          font-size: 14px;
          font-weight: 700;
          div:nth-child(1) {
            flex-grow: 1;
            max-width: 280px;
            color: rgba(#222, .6);
          }
        }
        .purchase_price {
          div:nth-child(1) {
            color: #222;
          }
        }
        .inspection_price {
          div:nth-child(2) {
            color: rgba(#222, .8);
          }
        }
      }
      .way {
        display: flex;
        flex-direction: column;
        padding: 30px 20px;
        .way_title {
          padding: 10px 0 5px 0;
          h5 {
            font-size: 14px;
            font-weight: 700;
          }
        }
        .way_info {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 10px 0;
          font-size: 14px;
          line-height: 18px;
          .title {
            width: 150px;
          }
          .bank-name {
            padding: 0 5px;
          }
          .bank-account-number {
            padding: 0 5px;
          }
          .price {
            text-align: right;
            flex-grow: 1;
            padding: 10px 0;
          }
        }
      }
    }
  }
  > .btn {
    margin-top: 20px;
    text-align: center;
    button {
      margin-left: 30px;
      padding: 3px 35px;
      font-size: 12px;
      background-color: #fff;
      border: 1px solid #d3d3d3;
      border-radius: 5px;  
      height: 34px;
      color: rgba(#222, .8);
      cursor: pointer;
      &:first-child {
        margin-left: 0;
      }
      &.disabled {
          border: 0;
          background-color: #ebebeb;
          color: rgba(#222, 0.5);
          cursor: default;
        }
    }
    .list_back {
      background-color: #222;
      color: #fff
    }
  }
}
</style>
