<template>
  <div class="mt-5">
    <VacancyShower />
  </div>
</template>

<script>
export default {
  components: {
    VacancyShower: () => import('../components/Vacancies/VacancyAdmin.vue'),
  },
}
</script>

<style>

</style>