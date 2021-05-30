<template>
  <div id="app">
    <header>
      <Nav />
    </header>
    <div class="main-content">
      <router-view class="router-content"/>
    </div>
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
    padding-top: 65px;
  }

  .main-content{
    display: flex;
    justify-content: center;
    width: 100%;
  }

  .router-content{
    width: 95%;   
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