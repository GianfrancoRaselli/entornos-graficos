<template>
  <div class="vacancies-list">
    <h2>
      <b> Últimas vacantes </b>
    </h2>
    <div class="vacancies">
      <div class="row">
        <div class="col">
          <div class="row" v-for="(vacancy, index) in vacanciesList" :key="index">
            <div class="col" style="background-color: red">
              1 of 2
            </div>
          </div>
        </div>
        <div class="col">
          <div class="row">
            <div class="col" style="background-color: blue">
              1 of 2
            </div>
          </div>
          <div class="row">
            <div class="col" style="background-color: green">
              1 of 2
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      vacanciesList: [
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
</style>