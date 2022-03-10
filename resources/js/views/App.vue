<template>
  <div>
    <Header></Header>
      <!-- component matched by the route will render here -->
    <router-view></router-view>
  </div>
</template>

<script>
import Header from '../components/Header.vue';

  export default {
    name: "App",
    components: {
      Header
    }
  }
</script>

<style lang="scss">
@import '~bootstrap/scss/bootstrap';
</style>