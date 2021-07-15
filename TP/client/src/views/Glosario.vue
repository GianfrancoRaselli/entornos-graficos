<template>
  <div class="m-4">
    <p class="title mb-4">Glosario</p>
    <p v-for="(palabra, index) in palabrasOrdenadas" :key="index">
      <i class="fas fa-angle-right"></i>&nbsp;<strong>{{ palabra.termino }}</strong>:&nbsp;{{ palabra.descripcion }}
    </p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      palabras: [
        {
          termino: "Cátedra",
          descripcion:
            "Conjunto de profesores y actividades dependientes de la autoridad de un jefe de cátedra."
        },
        {
          termino: "Jefe de Catédra",
          descripcion:
            "Supervisa la gestión académica de los docentes adscritos a su cátedra."
        },
        {
          termino: "Vacante",
          descripcion:
            "Llamado a cubrir un puesto de trabajo de una cátedra en particular. Una cátedra puede tener varias vacantes abiertas para cubrir diferentes puestos de trabajos."
        },
        {
          termino: "Curriculum Vitae",
          descripcion:
            "Un currículum vitae (CV) es un compendio resumido y esquemático de datos y antecedentes formativos y profesionales de una persona."
        },
        {
          termino: "Postulación",
          descripcion:
            "Postularse a una vacante para cubrir un puesto de trabajo en una cátedra determinada."
        },
        {
          termino: "Orden de Mérito",
          descripcion:
            "Al finalizar el plazo para postularse a una vacante, el jefe de cátedra correspondiente calificará y elegirá a las personas que se hayan inscriptos."
        }
      ]
    };
  },
  computed: {
    palabrasOrdenadas() {
      let palabrasOrdenadas = this.palabras;
      return palabrasOrdenadas.sort(function(a, b) {
        return a.termino.localeCompare(b.termino);
      });
    }
  }
};
</script>

<style scoped>
.title {
  font-size: 40px;
  font-weight: 800;
  text-decoration: underline;
  text-align: center;
}
</style>