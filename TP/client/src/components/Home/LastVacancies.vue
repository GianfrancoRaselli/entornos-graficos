<template>
  <div class="vacancies-list">
    <h2>
      <b> Últimas vacantes </b>
    </h2>
    <div class="vacancies">
      <div class="vacancy" v-for="(vacancy, index) in vacancies" :key="index">
        <div class="name">
          {{ vacancy.name }}
        </div>
        <div class="description">
          {{ vacancy.description }}
        </div>
        <utn-button to="Home" btnClass="btn btn-outline-primary">
          Ver más
        </utn-button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      vacancies: [
        { 
          id: 1,
          name: 'Matematica superior', 
          description: 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est.'
        },
        { 
          id: 2,
          name: 'Entornos gráficos', 
          description: 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est.'
        },
        { 
          id: 3,
          name: 'Administración de recursos', 
          description: 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est.'
        },
        { 
          id: 4,
          name: 'Comunicaciones', 
          description: 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est.'
        },
      ],
    }
  }
}
</script>

<style>
  .vacancies-list{
    width: 90%;
    margin: 25px auto;
  }

  .vacancies{
    display: flex;
    width: 100%;
    flex-wrap: wrap;
  }

  .vacancy{
    width: 50%;
    padding:1rem;
  }

  .name{
    font-size:1.25rem;
    font-weight: 600;
  }
</style>