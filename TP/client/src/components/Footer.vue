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
  background-color: RGBA(0, 0, 0, 0.8);
  color: RGBA(255, 255, 255, 0.5);
  padding: 3rem 1rem;
  flex-wrap: wrap;
}
</style>