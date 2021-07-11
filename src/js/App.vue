<template>
  <div>
    <NavbarMenu></NavbarMenu>
    <ProductList></ProductList>
  </div>
</template>
<style>

</style>
<script>
import NavbarMenu from "./components/NavbarMenu.vue";
import ProductList from "./components/ProductList.vue";

export default {
  name: 'App',
  components: {
    NavbarMenu,
    ProductList
  },
  data() {
    return [

    ];
  },
}
</script>