<template>
  <div class="sitemap-container">
    <p class="title mb-4">Mapa del sitio</p>
    <ul>
      <li>
        <router-link class="sitemap-link" to="/">Página de inicio</router-link>
      </li>
      <ul>
        <li>
          <router-link class="sitemap-link" to="/contacto">Contacto</router-link>
        </li>
        <li>Vacantes</li>
        <ul>
          <li v-if="!authenticated || isUsuario">
            <router-link class="sitemap-link" to="/requisitos">Requisitos para postularse</router-link>
          </li>
          <li v-if="!authenticated || isUsuario">
            <router-link class="sitemap-link" to="/vacantes">Buscar vacantes abiertas</router-link>
          </li>
          <li v-if="!authenticated || isUsuario">
            <router-link class="sitemap-link" to="/ordenesMerito">Vacantes calificadas</router-link>
          </li>
          <li v-if="isAdministrador || isJefeCatedra">
            <router-link class="sitemap-link" to="/administrarVacantes">Administrar vacantes</router-link>
          </li>
          <li v-if="isAdministrador">
            <router-link class="sitemap-link" to="/agregarVacante">Agregar vacante</router-link>
          </li>
        </ul>
        <li v-if="isAdministrador">Cátedras</li>
        <ul v-if="isAdministrador">
          <li>
            <router-link class="sitemap-link" to="/administrarCatedras">Administrar cátedras</router-link>
          </li>
          <li>
            <router-link class="sitemap-link" to="/agregarCatedra">Agregar cátedra</router-link>
          </li>
        </ul>
        <li v-if="isAdministrador">
          <router-link class="sitemap-link" to="/verificarIdentidades">Identidades</router-link>
        </li>
        <li>Ayuda</li>
        <ul>
          <li>
            <router-link class="sitemap-link" to="/preguntasFrecuentes">Preguntas frecuentes</router-link>
          </li>
          <li>
            <router-link class="sitemap-link" to="/glosario">Glosario</router-link>
          </li>
          <li>
            <router-link class="sitemap-link" to="/mapaSitio">Mapa del sitio</router-link>
          </li>
        </ul>
        <li>Iniciar Sesión</li>
        <ul>
          <li>
            <router-link class="sitemap-link" to="/perfil">Perfil</router-link>
          </li>
        </ul>
      </ul>
    </ul>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  computed: {
    ...mapGetters({
      authenticated: "authenticated",
      isAdministrador: "isAdministrador",
      isJefeCatedra: "isJefeCatedra",
      isUsuario: "isUsuario"
    })
  }
};
</script>

<style scoped>
.sitemap-container {
  margin: 1rem;
  display: flex;
  flex-direction: column;
}
.sitemap-link {
  color: RGBA(0, 122, 255, 1);
}
.title {
  font-size: 40px;
  font-weight: 800;
  text-decoration: underline;
  text-align: center;
}
</style>
