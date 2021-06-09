<template>
  <div class="cta">
    <div class="cta-title">
      ¡Postulate!
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
    <button class="btn btn-primary" @click="abrirModal">
      Registrarse
    </button>
  </div>
</template>

<script>
export default {
  methods: {
    abrirModal() {
      window.$("#signUpPopup").modal('show');
    }
  }
}
</script>

<style>
  .cta{
    padding: 2rem 5rem;
    background-image: url("../../assets/homebg.png");
    background-color: #fff;
    background-position: right bottom;
    background-repeat: no-repeat;
    background-size: 80%;
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