<template>
  <div>
    <div class="inscriptos" v-if="llamado && llamado.postulaciones.length > 0">
      <div class="inscripto" v-for="(postulacion, index) in llamado.postulaciones" :key="index">
        <div class="descripcion">
          <p>{{ postulacion.persona.dni }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    llamado: { required: true },
  },
}
</script>

<style>

</style>