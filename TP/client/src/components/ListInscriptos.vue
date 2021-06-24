<template>
  <div>
    <div class="inscriptos" v-if="llamado && llamado.postulaciones.length > 0">
      <div class="mb-2 table-options">
        <button class="btn btn-primary mr-1" @click="calificar" v-if="!editando">Calificar</button>
        <button class="btn btn-success ml-1" v-if="editando">Guardar cambios</button>
        <button class="btn btn-danger ml-1" v-if="editando" @click="cancelarEdicion">Cancelar cambios</button>
      </div>
      <div class="inscriptos-table">
        <table class="table table-responsive table-striped">
          <thead>
            <tr>
              <th>DNI</th>
              <th>NyA</th>
              <th>Email</th>
              <th>Teléfono</th>
              <th>Estado</th>
              <th>Puntaje</th>
              <th>Comentarios</th>
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
                <div v-if="!editando">
                  {{ postulacion.estado }}
                </div>
                <div v-else>
                  <select name="estado" class="form-control">
                    <option>Aceptar</option>
                    <option>Rechazar</option>
                  </select>
                </div>
              </td>
              <td>
                <div v-if="!editando">
                  <div v-if="postulacion.puntaje">{{ postulacion.puntaje }}</div>
                  <div>-</div>
                </div>
                <div v-else>
                  <input type="number" class="form-control" min="0" max="10">
                </div>
              </td>
              <td>
              <div v-if="!editando">
                  <div v-if="postulacion.comentarios">{{ postulacion.comentarios }}</div>
                  <div>-</div>
                </div>
                <div v-else>
                  <textarea class="form-control" cols="60"></textarea>
                </div>
              </td>
              <td>
                <a id="btn-ver-cv" class="btn btn-secondary" v-if="postulacion.persona.curriculum_vitae" :href="'http://localhost/Entornos Graficos/entornos-graficos-2021/TP/server/public/CVs/' + postulacion.persona.curriculum_vitae" target="_blank">
                  <i class="fas fa-eye"></i> Ver CV
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div v-else>
      <p>No hay personas inscriptas</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      editando: false,
    }
  },
  props: {
    llamado: { required: true },
  },
  methods: {
    calificar() {
      this.editando = true;
    },
    cancelarEdicion() {
      this.editando = false;
    }
  }
}
</script>

<style>
.table-options{
  display: flex;
  justify-content: center;
}
@media(min-width:1200px){
  .table-responsive{
    width: 80%;
    margin-left: auto;
    margin-right: auto;
  }
}
</style>