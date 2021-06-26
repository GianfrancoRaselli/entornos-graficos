<template>
  <div class="mt-5">
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