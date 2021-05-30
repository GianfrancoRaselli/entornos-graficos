<template>
  <div class="mt-5">
    <VacancyShower />
  </div>
</template>

<script>
export default {
  components: {
    VacancyShower: () => import('../components/Vacancies/VacancyShower.vue'),
  },
}
</script>

<style>

</style>