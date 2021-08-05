<template>
  <div class="container">
    <h1>Log In</h1>
    <hr>
    <form @submit.prevent="submitForm"
          ref="login_form">
      <label for="email">
        Email:
        <input type="email"
               name="email"
               id="email">
      </label>
      <label for="password">
        Password:
        <input type="password"
               name="password"
               id="password">
      </label>
      <button type="submit">Log In</button>
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
      let form = this.$refs['login_form'];
      let data = new FormData(form);

      let res = await axios.post('/api/user/login', data);
    }
  }
}
</script>