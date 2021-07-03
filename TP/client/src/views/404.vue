<template>
  <div>
    <div class="alert alert-danger error-404 pb-5" role="alert"
    >
      <i class="fas fa-exclamation-triangle mt-5" style="font-size: 5rem"></i>
      <p class="mt-5 mb-5" style="font-size: 2rem">¡Error 404 - Esta página no existe!</p>
      <utn-button to="/">
        <i class="fas fa-home mr-2"></i>Ir a la página de inicio
      </utn-button>
      
    </div>
  </div>
</template>

<script>
export default {

}
</script>

<style>
  .error-404{
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    margin:3rem;
  }
</style>