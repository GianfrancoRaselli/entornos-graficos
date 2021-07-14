<template>
  <div class="mt-4">
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