<template>
  <footer>
    <div class="footer-container">
      <div class="col">
        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni
      </div>
      <div class="col">
        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni
      </div>
      <div class="col">
        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni
      </div>
    </div>
  </footer>
</template>

<script>
  export default {
    name: 'footer',
  }
</script>

<style>
  .footer-container{
    display: flex;
    background-color: RGBA(0, 0, 0, .8);
    color: RGBA(255, 255, 255, .5);
    padding: 3rem 1rem;
    flex-wrap: wrap;
  }
</style>