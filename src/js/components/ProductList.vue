<template>
  <div id="product-list">
    <div class="product-card"
         v-for="product of products">
      <h2> {{ product.name }} </h2>
      <p v-if="product.description.length > 255">{{ product.description.substring(0, 255) }}...</p>
      <p v-else>{{ product.description }}</p>
    </div>
  </div>

</template>
<style>
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
  margin: 2.5rem;
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
    name: 'ServiceList',
    data() {
      return {
        products: [{
          name: '',
          description: ''
        }]
      }
    },
    mounted() {
      axios.get('/api/products').then(res => this.products = res.data);
    }
  }
</script>