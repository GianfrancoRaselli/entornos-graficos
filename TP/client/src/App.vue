<template>
  <div id="app">
    <header>
      <Nav />
    </header>
    <router-view />
  </div>
</template>

<script>
  import Nav from './components/Nav.vue'
  export default {
    name: 'App',
    components: {
      Nav
    }
  }
</script>

<style>
  #app{
    padding-top: 80px;
  }

  header{
    height: 70px;
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
  }
</style>