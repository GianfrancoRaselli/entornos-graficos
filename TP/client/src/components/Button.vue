<template>
  <div class="m-1">
    <router-link :to="to" style="text-decoration: none;">
      <button :class="btnClass" @click="$emit('click', $event)">
        <i :class="icon" v-if="icon"></i>
        <slot />
      </button>
    </router-link>
  </div>
</template>

<script>
export default {
  props: {
    to: { type: String, default: '#' },
    btnClass: { type: String, default: 'btn btn-primary' },
    icon: { type: String }
  }
}
</script>

<style>
  .btn:focus {
    outline: none !important;
    box-shadow: none !important;
  }
  
  .btn:hover {
    transition: .15s;
  }
</style>