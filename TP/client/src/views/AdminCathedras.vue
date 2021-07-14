<template>
  <div class="mt-4">
    <CathedraAdmin />
  </div>
</template>

<script>
export default {
  components: {
    CathedraAdmin: () => import('../components/Cathedras/CathedraAdmin.vue'),
  },
}
</script>

<style>

</style>