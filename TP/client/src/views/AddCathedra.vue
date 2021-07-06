<template>
  <div class="mt-5">
    <AddCathedra />
  </div>
</template>

<script>
export default {
  components: {
    AddCathedra: () => import('../components/Cathedras/AddCathedra.vue'),
  },
}
</script>

<style>

</style>