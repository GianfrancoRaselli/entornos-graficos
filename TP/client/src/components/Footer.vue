<template>
  <footer>
    <div class="footer-container">
      <div class="col">
        <p class="title"><strong>FACULTAD REGIONAL ROSARIO</strong></p>
        <p><strong>Universidad Tecnológica Nacional</strong></p>
      </div>
      <div class="col">
        <p>
          <router-link class="link" to="/contacto">Contacto</router-link>:
          ZEBALLOS 1341 - S2000BQA - ROSARIO
        </p>
        <p>Télefono: (0341) 4481871</p>
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
@media (max-width: 1261px) {
  .support-container {
    height: 142px;
    flex-wrap: wrap;
    padding-bottom: 55px;
  }
}
</style>