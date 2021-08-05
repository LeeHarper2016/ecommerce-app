<template>
  <nav ref="navbar">
    <span @click="toggleCollapse" class="nav-link toggle_menu_button">Menu</span>
    <RouterLink class="nav-link" to="/">Home</RouterLink>
    <RouterLink class="nav-link" to="/products">Products</RouterLink>
    <a class="nav-link" href="/about">About Us</a>
    <a class="nav-link" href="/contact">Contact Us</a>
    <RouterLink v-if="this.$store.state.user === null" class="nav-link" to="/login">Login</RouterLink>
    <RouterLink v-if="this.$store.state.user" class="nav-link">Hello {{ this.$store.state.user.username }}</RouterLink>
    <RouterLink v-if="this.$store.state.user" class="nav-link" to="/admin">Admin</RouterLink>
  </nav>
</template>

<style>
nav {
  display: flex;
  flex-direction: column;
  align-items: start;
  background: white;
  width: 100vw;
  border-bottom: 2px solid black;
  overflow: hidden;
  height: 5rem;
  transition: height 0.35s;
}

.nav-link {
  padding: 1rem;
  color: black;
  text-decoration: none;
  font-size: 24px;
  font-weight: bold;
  transition: all 0.35s;
}
.nav-link:hover {
  color: darkgray;
}

.sticky-nav {
  position: fixed;
  top: 0;
}

@media (min-width: 576px) {
  .toggle_menu_button {
    display: block;
    cursor: pointer;
  }
}

@media (min-width: 768px) {

}

@media (min-width: 992px) {
  .toggle_menu_button {
    display: none;
  }
  nav {
    flex-direction: row;
  }
}

@media (min-width: 1200px) {

}
</style>

<script>
  export default {
    name: 'NavbarMenu',
    data() {
      return {
        isCollapsed: false,
        isSticky: false
      }
    },
    methods: {
      toggleCollapse() {
        this.isCollapsed = !this.isCollapsed;
      }
    },
    watch: {
      isCollapsed() {
        if (this.isCollapsed) {
          this.$refs['navbar'].style.height = "5rem";
        } else {
          this.$refs['navbar'].style.height = "27.5rem";
        }
      },
      isSticky() {
        if (this.isSticky) {
          this.$refs['navbar'].classList.add('sticky-nav');
        } else {
          this.$refs['navbar'].classList.remove('sticky-nav');
        }
      }
    },
    mounted() {
      window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
          this.isSticky = true;
        } else {
          this.isSticky = false;
        }
      })
    }
  }
</script>