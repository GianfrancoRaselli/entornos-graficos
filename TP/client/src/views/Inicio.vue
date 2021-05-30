<template>
  <div class="w-100">
    <div class="cta">
      <div class="cta-title">
        Postulate!
      </div>
      <div class="cta-subtitle">
        Para postularte, primero debes registrarte
      </div>
      <p>
        <i class="far fa-clipboard mr-2"></i>
        <ol>
          <li>asdasd</li>
          <li>asdasdasd</li>
          <li>asdasdasdasdasd</li>
        </ol>
      </p>
      <utn-button name="Registrarse" to="SignUp" />
    </div>
    <div class="last-vacancy">
    </div>
    <LastVacancies />
  </div>
</template>

<script>
  export default {
    name: 'Inicio',
    components: {
      LastVacancies: () => import('../components/LastVacancies.vue'),
    },
  }
</script>

<style>
  .cta{
    width: 100vw;
    padding: 2rem 5rem;
    background-image: url("https://image.freepik.com/free-vector/modern-flowing-blue-wave-banner-white-background_1035-18538.jpg");
    background-color: #cccccc;
    background-repeat: no-repeat;
    background-size: cover;
  }
  .cta-title{
    font-weight: 600;
    font-size: 2rem;
  }

  .cta-subtitle{
    font-size: 1.25rem;
  }

  .cta p{
    margin-top: 1rem;
    display: flex;
  }

  .cta p i{
    font-size: 4rem;
  }
</style>