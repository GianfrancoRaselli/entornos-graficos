<template>
  <div id="app">
    <header>
      <Nav />
    </header>
    <div class="main-content">
      <router-view class="router-content"/>
    </div>
    <Footer />
  </div>
</template>

<script>
  export default {
    components: {
      Nav: () => import('./components/Nav.vue'),
      Footer: () => import('./components/Footer.vue'),
    },
    name: 'App',
  }
</script>

<style>
  #app{
    padding-top: 65px;
    display: flex;
    flex-direction: column;
    justify-content:space-between;
    min-height: 100vh;
    height: 100vh;
  }

  .main-content{
    display: flex;
    justify-content: center;
    width: 100%;
  }

  .router-content{
    width: 100%;
  }

  header{
    height: 70px;
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
  }

  footer{
    justify-self: flex-end;
    bottom: 0;
  }
</style>