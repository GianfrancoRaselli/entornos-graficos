<template>
  <div class="w-100 home-container">
    <CallToAction />
    <LastVacancies />
    <VisitUs/>
  </div>
</template>

<script>
  export default {
    name: 'Inicio',
    components: {
      CallToAction: () => import('../components/Home/CallToAction.vue'),
      LastVacancies: () => import('../components/Home/LastVacancies.vue'),
      VisitUs: () => import('../components/Home/VisitUs.vue'),
    },
  }
</script>

<style>
  .home-container{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height:100vh;
  }
</style>