<template>
  <div class="mt-5">
    <MeritOrders />
  </div>
</template>

<script>
export default {
  components: {
    MeritOrders: () => import('../components/Vacancies/MeritOrders.vue'),
  },
}
</script>

<style>

</style>