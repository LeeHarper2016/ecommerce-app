<template>
  <div id="product-menu">
    <label for="search">
      Search Products:
      <input type="text"
             name="search"
             id="search"
             v-model="searchString">
    </label>
    <transition-group v-if="isLoading === false"
                      name="fade"
                      tag="div"
                      id="product-list">
      <div class="product-card"
           v-for="product of products"
           v-show="product.name.toLowerCase().indexOf(searchString.toLowerCase()) !== -1"
           :key="product.id">
        <img :src="product.img">
        <h2> {{ product.name }} </h2>
        <span>Price: {{ product.price }}</span>
        <hr>
        <p v-if="product.description.length > 255">{{ product.description.substring(0, 255) }}...</p>
        <p v-else>{{ product.description }}</p>

        <div class="btn_menu">
          <button>Add to Cart</button>
          <button @click="goToProduct(product.id)">View</button>
        </div>

      </div>
    </transition-group>
  </div>

</template>
<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity .35s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

input {
  display: block;
  font-size: 1.25rem;
}
#product-menu {
  padding: 2.5rem;
}
#product-list {
  display: flex;
  justify-content: space-around;
  flex-direction: row;
  flex-wrap: wrap;
}
.product-card {
  display: block;
  width: 250px;
  margin: 1rem;
  padding: 1rem;
  text-align: center;
  border: 5px solid black;
  border-radius: 1rem;
  overflow: hidden;
}

.product-card img {
  width: 200px;
  height: 200px;
  border-radius: 1.5rem;
}

.product-card h2 {
  margin: 10px 0 0 0;
}

.btn_menu {
  display: flex;
  justify-content: space-around;
  width: 100%;
}
</style>
<script>
import axios from 'axios';

  export default {
    name: 'ProductList',
    data() {
      return {
        searchString: '',
        products: [{
          name: '',
          description: ''
        }],
        isLoading: true
      }
    },
    methods: {
      goToProduct(id) {
        this.$router.push(`/products/${id}`)
      }
    },
    async mounted() {
      let res = await axios.get('/api/products');

      this.products = res.data;

      this.isLoading = false;
    }
  }
</script>