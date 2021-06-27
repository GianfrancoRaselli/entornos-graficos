<template>
  <div class="w-100 home-container">
    <CallToAction />
    <VacancyShower :ultimasVacantes="true" />
    <VisitUs/>
  </div>
</template>

<script>
  export default {
    name: 'Inicio',
    components: {
      CallToAction: () => import('../components/Home/CallToAction.vue'),
      VisitUs: () => import('../components/Home/VisitUs.vue'),
      VacancyShower: () => import('../components/Vacancies/VacancyShower.vue'),
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