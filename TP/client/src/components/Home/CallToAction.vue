<template>
  <div class="cta">
    <div class="cta-title">
      ¡Postulate!
    </div>
    <div class="cta-subtitle" v-if="!authenticated">
      Para postularte, primero debes estar registrado
    </div>
    <p>
      <i class="far fa-clipboard mr-2 mt-2 hide-responsive"></i>
      <ol>
        <li v-if="!authenticated">Registrese o inicie sesión</li>
        <li>Selecciona en el menú la opción "Vacantes"</li>
        <li>Escoge la vacante que deseas ocupar</li>
        <li>Ingresa tus datos personales y curriculum vitae</li>
        <li>¡Listo! Ya estas participando</li>
        <li>Al finalizar la orden de mérito se le notificará vía Email</li>
      </ol>
    </p>
    <div v-if="!authenticated">
      <utn-button data-toggle="modal" data-target="#signUpPopupCallToAction" icon="fas fa-user-plus">
        Crear cuenta
      </utn-button>
      <SignUp identificator="signUpPopupCallToAction" />
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  components: {
    SignUp: () => import("../SignUp.vue")
  },
  computed: {
    ...mapGetters({
      authenticated: "authenticated"
    })
  }
};
</script>

<style>
.cta {
  padding: 2rem 5rem;
  background-image: url("../../assets/homebg.png");
  background-color: #fff;
  background-position: right bottom;
  background-repeat: no-repeat;
  background-size: 80%;
}

.cta-title {
  font-weight: 600;
  font-size: 2rem;
}

.cta-subtitle {
  font-size: 1.25rem;
}

.cta p {
  margin-top: 1rem;
  display: flex;
}

.cta p i {
  font-size: 6rem;
}

@media(max-width:560px){
  .hide-responsive{
    display:none;
  }
  .cta {
    padding: 2rem 1rem;
  }
}
</style>