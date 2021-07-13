<template>
  <div id="product-menu">
    <label for="search">
      Search Products:
      <input type="text"
             name="search"
             id="search"
             v-model="searchString">
    </label>
    <transition-group name="fade"
                      tag="div"
                      id="product-list">
      <div class="product-card"
           v-for="product of products"
           v-show="product.name.toLowerCase().indexOf(searchString.toLowerCase()) !== -1"
           :key="product.id">
        <h2> {{ product.name }} </h2>
        <p v-if="product.description.length > 255">{{ product.description.substring(0, 255) }}...</p>
        <p v-else>{{ product.description }}</p>
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
  height: 400px;
  margin: 1rem;
  padding: 1rem;
  text-align: center;
  border: 5px solid black;
  border-radius: 1rem;
  overflow: hidden;
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
        }]
      }
    },
    async mounted() {
      let res = await axios.get('/api/products');

      this.products = res.data;

      console.log(this.products);
    }
  }
</script>