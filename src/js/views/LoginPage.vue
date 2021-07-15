<template>
  <div>
    <form @submit.prevent="submitForm"
          ref="login_form">
      <label for="email">
        <input type="email"
               name="email"
               id="email">
      </label>
      <label for="password">
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

      console.log(res.data);
    }
  }
}
</script>