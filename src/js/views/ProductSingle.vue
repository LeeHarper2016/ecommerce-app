<template>
  <div class="container">
    <div id="product-view">
      <img :src="product.img" alt="testing">
      <div id="product-information">
        <h1 v-text="product.name"></h1>
        <span>Price: ${{ product.price }}</span>
        <hr>
        <p v-text="product.description"></p>
        <div class="btn-group">
          <button>Add To Cart</button>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
#product-view {
  display: flex;
  justify-content: space-around;
}
#product-view img {
  width: 300px;
  height: 400px;
  border-radius: 10px;
}
#product-information {
  width: 75%;
}
#product-information span {
  font-style: italic;
  font-size: 125%;
}
#product-information p {
  line-height: 24px;
}
</style>
<script>

import axios from "axios";

export default {
  name: 'ProductSingle',
  data() {
    return {
      product: {},
      isLoading: true
    }
  },
  methods: {

  },
  async mounted() {
    let res = await axios.get('/api/products/' + this.$route.params.id);

    this.product = res.data[0];

    this.isLoading = false;
  }
}
</script>