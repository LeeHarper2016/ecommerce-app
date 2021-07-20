<template>
  <div class="container">
    <h1>Create Product</h1>
    <hr>
    <form @submit.prevent="submitForm"
          ref="product_form">
      <label for="name">
        Product Name:
        <input type="text"
               name="name"
               id="name">
      </label>
      <label for="description">
        Product Description:
        <textarea rows="10"
                  cols="40"
                  name="description"
                  id="description"></textarea>
      </label>
      <label for="price">
        Product Price:
        <input type="number"
               step="0.01"
               name="price"
               id="price">
      </label>
      <label for="img">
        Product Image:
        <input type="text"
               name="img"
               id="img">
      </label>
      <button type="submit">Create Product</button>
    </form>
  </div>
</template>
<style>
label, textarea {
  display: block;
  margin-bottom: 1rem;
}
</style>
<script>

import axios from "axios";

export default {
  name: 'LoginPage',
  data() {
    return {
      user: {}
    }
  },
  methods: {
    async submitForm() {
      let form = this.$refs['product_form'];
      let data = new FormData(form);

      let res = await axios.post('/api/products', data);
    }
  }
}
</script>