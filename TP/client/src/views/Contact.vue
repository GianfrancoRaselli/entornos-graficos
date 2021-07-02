<template>
  <div class="mt-5 mb-5 px-5 row">
    <div class="col-md-8 col-sm-12">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1673.9289926023812!2d-60.64444439939346!3d-32.954758660072976!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95b7ab11d0eb49c3%3A0x11f1d3d54f950dd0!2sUniversidad%20Tecnol%C3%B3gica%20Nacional%20%7C%20Facultad%20Regional%20Rosario!5e0!3m2!1ses!2sar!4v1598106189927!5m2!1ses!2sar" width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>
    <div class="static-data col-md-4 col-sm-12">
      <div class="static-container">
        FACULTAD REGIONAL ROSARIO
        <br />
        Universidad Tecnológica Nacional
      </div>
      <div class="static-container mt-3">
        Dirección: ZEBALLOS 1341 - S2000BQA - ROSARIO
        <br />
        Teléfono: (0341) 4481871
      </div>
    </div>
  </div>
</template>

<script>
export default {

}
</script>

<style>
  .static-data{
    display: flex;
    flex-direction: column;
  }
  .static-container{
    border: 1px solid RGB(12, 110, 252);
    padding: 1rem;
    border-radius: .5rem;
    height: 100%;
    display: flex;
    line-height: 1.75rem;
    align-items: center;
  }
</style>