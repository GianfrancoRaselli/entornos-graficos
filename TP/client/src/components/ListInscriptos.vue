<template>
  <div>
    <div class="inscriptos" v-if="llamado && llamado.postulaciones.length > 0">
      <table class="table table-responsive table-striped">
        <thead>
          <tr>
            <th>DNI</th>
            <th>Nombre y apellido</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(postulacion, index) in llamado.postulaciones" :key="index">
            <td>{{ postulacion.persona.dni }}</td>
            <td>{{ postulacion.persona.nombre_apellido }}</td>
            <td>{{ postulacion.persona.email }}</td>
            <td>{{ postulacion.persona.telefono }}</td>
            <td>
              <a id="btn-ver-cv" class="btn btn-primary ml-1" v-if="postulacion.persona.curriculum_vitae" :href="'http://localhost/Entornos Graficos/entornos-graficos-2021/TP/server/public/CVs/' + postulacion.persona.curriculum_vitae" target="_blank">
                <i class="fas fa-eye"></i> Ver CV
              </a>&nbsp;
              <button type="button" class="btn btn-secondary" v-if="llamado.finalizado" @click="calificar(postulacion.persona.id)"><i class="fas fa-pencil-alt"></i> Calificar</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <p>No hay personas inscriptas</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    llamado: { required: true },
  },
  methods: {
    async calificar() {
      return;
    }
  }
}
</script>

<style>

</style>