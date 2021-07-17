<template>
  <div>
    <NavbarMenu></NavbarMenu>
    <RouterView></RouterView>
  </div>
</template>
<style>

</style>
<script>
import NavbarMenu from "./components/NavbarMenu.vue";
import axios from "axios";

export default {
  name: 'App',
  components: {
    NavbarMenu
  },
  data() {
    return [

    ];
  },
  async mounted() {
    let res = await axios.get('/api/user');

    this.$store.commit('setUser', res.data);
  }
}
</script>