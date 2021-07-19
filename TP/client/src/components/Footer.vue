<template>
  <footer>
    <div class="footer-container">
      <div class="col">
        <p class="title"><b>FACULTAD REGIONAL ROSARIO</b></p>
        <p><b>Universidad Tecnológica Nacional</b></p>
      </div>
      <div class="col">
        <p>
          <router-link class="link" to="/contacto">Contacto</router-link>:
          ZEBALLOS 1341 - S2000BQA - ROSARIO
        </p>
        <p>Télefono: (0341) 4481871</p>
        <router-link class="link" to="/mapaSitio"><i class="fas fa-sitemap mr-2"></i>Mapa del sitio</router-link>
      </div>
    </div>
    <div class="support-container px-5">
      Soporte:
      <a
        class="mx-2"
        href="mailto:galdeanocg2@gmail.com?Subject=Sugerencia%20-%20UTN%20vacantes"
      >
        Galdeano Gonzalo</a
      >
      -
      <a
        class="mx-2"
        href="mailto:gianrase4@gmail.com?Subject=Sugerencia%20-%20UTN%20vacantes"
      >
        Raselli Gianfranco
      </a>
      -
      <a
        class="ml-2"
        href="mailto:federico.roma98@gmail.com?Subject=Sugerencia%20-%20UTN%20vacantes"
      >
        Romaniuk Federico</a
      >
    </div>
  </footer>
</template>

<script>
export default {
  name: "footer"
};
</script>

<style>
.title {
  font-size: x-large;
}
.col {
  text-align: center;
}
.link {
  color: RGBA(255, 255, 255, 0.5);
}
.link:hover {
  color: RGBA(255, 255, 255, 0.5);
}
.footer-container {
  display: flex;
  margin-top: 2rem;
  background-color: RGBA(0, 0, 0, 0.8);
  color: RGBA(255, 255, 255, 0.5);
  padding: 3rem 1rem;
  flex-wrap: wrap;
}
.support-container {
  display: flex;
  justify-content: center;
  background-color: RGBA(0, 0, 0, 0.5);
  width: 100%;
  height: 50px;
  align-items: center;
  color: white;
}
.support-container a {
  color: #ccc;
}
@media (max-width: 991px) {
  .support-container {
    height: 160px;
    flex-wrap: wrap;
    padding-bottom: 65px;
  }
}
</style>