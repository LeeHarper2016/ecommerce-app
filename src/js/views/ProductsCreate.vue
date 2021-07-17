<template>
  <div>
    <form @submit.prevent="submitForm"
          ref="product_form">
      <label for="name">
        <input type="text"
               name="name"
               id="name">
      </label>
      <label for="description">
        <textarea rows="40"
                  cols="40"
                  name="description"
                  id="description"></textarea>
      </label>
      <label for="price">
        <input type="number"
               name="price"
               id="price">
      </label>
      <label for="img">
        <input type="text"
               name="img"
               id="img">
      </label>
      <button type="submit">Create Product</button>
    </form>
  </div>
</template>
<style>

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