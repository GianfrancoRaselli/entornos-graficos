<template>
  <div class="inscriptos-mobile">
    <div
      class="inscripto-data"
      v-for="(postulacion, index) in llamado.postulaciones"
      :key="index"
      :class="{ elegido: postulacion.estado === 'Elegido', noElegido: postulacion.estado === 'No elegido' }"
    >
      <b>DNI:</b>
      {{ postulacion.dni }}
      <br />
      <b>Nombre y Apellido:</b>
      {{ postulacion.nombre_apellido }}
      <br />
      <template v-if="editMode">
        <b>Email:</b>
        {{ postulacion.email }}
        <br />
      </template>
      <template v-if="editMode">
        <b>Teléfono:</b>
        {{ postulacion.telefono }}
        <br />
      </template>
      <template v-if="!isEditing">
        <b>Estado:</b>
        {{ postulacion.estado }}
      </template>
      <div v-else-if="editMode" class="editing-container">
        <b>Acción:</b>
        <select
          class="form-control mt-1 mb-2"
          :class="{ errorClass: postulacion.estadoError }"
          v-model="postulacion.estadoEditado"
          required
        >
          <option>Aceptar</option>
          <option>Rechazar</option>
        </select>
      </div>
      <div v-if="!isEditing">
        <b>Calificación:</b>
        <div v-if="postulacion.puntaje">{{ postulacion.puntaje }}</div>
        <div v-else class="my-1">-</div>
      </div>
      <div v-else-if="editMode">
        <b>Calificación:</b>
        <input
          type="number"
          class="form-control my-1"
          :class="{ errorClass: postulacion.puntajeError }"
          v-model="postulacion.puntajeEditado"
          min="0"
          max="100"
          required
        />
      </div>
      <div v-if="!isEditing">
        <b>Comentarios:</b>
        <div v-if="postulacion.comentarios">{{ postulacion.comentarios }}</div>
        <div v-else>-</div>
      </div>
      <div v-else-if="editMode">
        <b>Comentarios:</b>
        <textarea
          class="form-control mt-1 mb-2"
          cols="60"
          v-model="postulacion.comentariosEditado"
          maxlength="300"
        ></textarea>
      </div>
      <div class="columna-md">
        <a
          id="btn-ver-cv"
          class="btn btn-secondary"
          :href="CVsPath + postulacion.curriculum_vitae"
          target="_blank"
        >
          <i class="fas fa-eye"></i> Ver CV
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import { CVsPath } from "../../paths";
export default {
  data() {
    return {
      CVsPath
    };
  },
  props: {
    editMode: { type: Boolean },
    llamado: { type: Object },
    isEditing: { type: Boolean, default: false }
  }
};
</script>

<style>
.elegido {
  background-color: rgb(149, 248, 170);
}

.noElegido {
  background-color: rgb(253, 193, 193);
}
</style>