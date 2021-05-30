<template>
  <div class="vacancies">
    <div class="vacancy" v-for="(vacancy, index) in vacancies" :key="index">
      <div class="name">
        {{ vacancy.name }}
      </div>
      <div class="time">
        Periodo vacante: {{ vacancy.time }}
      </div>
      <div class="description">
        {{ vacancy.description }}
      </div>
      <div class="d-flex">
        <utn-button to="Home" btnClass="btn btn-outline-primary">
          Requisitos
        </utn-button>
        <utn-button to="Home">
          Postularme
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
          time: '05/05/21 - 05/06/21',
          description: 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est.'
        },
        { 
          id: 2,
          name: 'Entornos gráficos',
          time: '05/05/21 - 05/06/21',
          description: 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est.'
        },
        { 
          id: 3,
          name: 'Administración de recursos',
          time: '05/05/21 - 05/06/21',
          description: 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est.'
        },
        { 
          id: 4,
          name: 'Comunicaciones',
          time: '05/05/21 - 05/06/21',
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
    font-size: 1.25rem;
    font-weight: 600;
  }

  .time{
    margin: .5rem 1rem;
  }

</style>