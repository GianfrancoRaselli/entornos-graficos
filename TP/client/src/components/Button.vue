<template>
  <div class="m-1">
    <router-link :to="to">
      <button :class="btnClass">
        <i :class="icon" v-if="icon"></i>
        {{ name }}
      </button>
    </router-link>
  </div>
</template>

<script>
export default {
  props: {
    name: { type: String, required: true },
    to: { type: String, required: true },
    btnClass: { type: String, default: 'btn btn-primary' },
    icon: { type: String },
  }
}
</script>

<style>
  .btn:focus {
    outline: none !important;
    box-shadow: none !important;
  }
</style>