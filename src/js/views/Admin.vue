<template>
  <div>
    <h1>Admin Panel</h1>
    <div>
      <RouterLink class="admin_btn"
                  to="/products/create">Create Product</RouterLink>
    </div>
  </div>
</template>
<style>
.admin_btn {

}
</style>
<script>
  export default {
    name: 'Admin'
  }
</script>