<template>
  <div class="mt-5">
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