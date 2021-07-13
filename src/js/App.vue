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

export default {
  name: 'App',
  components: {
    NavbarMenu
  },
  data() {
    return [

    ];
  },
}
</script>