<template>
  <div class="mt-4">
    <AddVacancy />
  </div>
</template>

<script>
export default {
  components: {
    AddVacancy: () => import('../components/Vacancies/AddVacancy.vue'),
  },
}
</script>

<style>

</style>