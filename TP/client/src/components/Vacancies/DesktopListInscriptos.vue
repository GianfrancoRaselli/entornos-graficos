<template>
  <table class="inscriptos-desktop table table-responsive table-striped table-hover table-bordered">
    <thead>
      <tr>
        <th>DNI</th>
        <th>Nombre y apellido</th>
        <th v-if="editMode">Email</th>
        <th v-if="editMode">Teléfono</th>
        <th>Estado</th>
        <th>Calificación</th>
        <th>Comentarios</th>
        <th v-if="editMode">Acción</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(postulacion, index) in llamado.postulaciones" :key="index">
        <td>
          <div class="columna-md">{{ postulacion.dni }}</div>
        </td>
        <td>
          <div class="columna-md">{{ postulacion.nombre_apellido }}</div>
        </td>
        <td v-if="editMode">
          <div class="columna-md">{{ postulacion.email }}</div>
        </td>
        <td v-if="editMode">
          <div class="columna-md">{{ postulacion.telefono }}</div>
        </td>
        <td>
          <div class="columna-md">
            <div v-if="!isEditing">
              {{ postulacion.estado }}
            </div>
            <div v-else-if="editMode">
              <select
                class="form-control"
                :class="{ errorClass: postulacion.estadoError }"
                v-model="postulacion.estadoEditado"
                required
              >
                <option>Aceptar</option>
                <option>Rechazar</option>
              </select>
            </div>
          </div>
        </td>
        <td>
          <div class="columna-sm">
            <div v-if="!isEditing">
              <div v-if="postulacion.puntaje">
                {{ postulacion.puntaje }}
              </div>
              <div v-else>-</div>
            </div>
            <div v-else-if="editMode">
              <input
                type="number"
                class="form-control"
                :class="{ errorClass: postulacion.puntajeError }"
                v-model="postulacion.puntajeEditado"
                min="0"
                max="100"
                required
              />
            </div>
          </div>
        </td>
        <td>
          <div class="columna-lg">
            <div v-if="!isEditing">
              <div v-if="postulacion.comentarios">
                {{ postulacion.comentarios }}
              </div>
              <div v-else>-</div>
            </div>
            <div v-else-if="editMode">
              <textarea
                class="form-control"
                cols="60"
                v-model="postulacion.comentariosEditado"
                maxlength="300"
              ></textarea>
            </div>
          </div>
        </td>
        <td v-if="editMode">
          <div class="columna-md">
            <a
              id="btn-ver-cv"
              class="btn btn-secondary"
              :href="
                'https://utn-vacantes.herokuapp.com/public/CVs/' +
                  postulacion.curriculum_vitae
              "
              target="_blank"
            >
              <i class="fas fa-eye"></i> Ver CV
            </a>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  data() {
    return {

    }
  },
  props:{
    editMode: { type: Boolean },
    llamado: { type: Object },
    isEditing: { type: Boolean, default: false },
  }
}
</script>

<style>

</style>