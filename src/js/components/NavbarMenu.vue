<template>
  <nav>
    <RouterLink class="nav-link" to="/">Home</RouterLink>
    <RouterLink class="nav-link" to="/products">Products</RouterLink>
    <a class="nav-link" href="/about">About Us</a>
    <a class="nav-link" href="/contact">Contact Us</a>
    <RouterLink v-if="this.$store.state.user === null" class="nav-link" to="/login">Login</RouterLink>
    <RouterLink v-if="this.$store.state.user" class="nav-link" to="/login">Hello {{ this.$store.state.user.username }}</RouterLink>
    <RouterLink v-if="this.$store.state.user" class="nav-link" to="/admin">Admin</RouterLink>
  </nav>
</template>
<style>
nav {
  display: flex;
  align-items: center;
  justify-content: space-around;
  width: 100vw;
  height: 5rem;
  border-bottom: 2px solid black;
}
.nav-link {
  color: black;
  text-decoration: none;
  font-size: 24px;
  font-weight: bold;
  transition: all 0.35s;
}
.nav-link:hover {
  color: darkgray;
}
</style>
<script>
  export default {
    name: 'NavbarMenu',
  }
</script>