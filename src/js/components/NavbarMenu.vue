<template>
  <nav>
    <a class="nav-link" href="/">Home</a>
    <RouterLink class="nav-link" to="/products">Products</RouterLink>
    <a class="nav-link" href="/about">About Us</a>
    <a class="nav-link" href="/contact">Contact Us</a>
    <a class="nav-link" href="/login">Login</a>
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