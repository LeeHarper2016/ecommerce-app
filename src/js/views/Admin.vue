<template>
  <div class="container">
    <h1>Admin Panel</h1>
    <hr>
    <div class="container">
      <RouterLink class="admin_btn"
                  to="/products/create">Create Product</RouterLink>
    </div>
  </div>
</template>
<style>
.admin_btn {
  background: lavender;
  padding: 1rem;
  border-radius: 25px;
  border: 1px solid black;
  text-decoration: none;
  color: black;
}
</style>
<script>
  export default {
    name: 'Admin'
  }
</script>