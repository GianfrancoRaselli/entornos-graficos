<template>
  <div class="mt-5">
    <VacancyAdmin />
  </div>
</template>

<script>
export default {
  components: {
    VacancyAdmin: () => import('../components/Vacancies/VacancyAdmin.vue'),
  },
}
</script>

<style>

</style>