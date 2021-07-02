<template>
  <div>
    <div
      class="modal fade background-popup-fade"
      :id="dataTarget"
      :aria-labelledby="title"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" :class="propClass">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              {{ title }}
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <slot />
          </div>
          <div class="modal-footer" v-if="showButtons">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              {{ cancelBtn }}
            </button>
            <button type="button" class="btn btn-primary">
              {{ acceptBtn }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: { type: String, required: true },
    cancelBtn: { type: String, default: "Cancelar" },
    acceptBtn: { type: String, default: "Aceptar" },
    dataTarget: { type: String, required: true },
    showButtons: { type: Boolean, default: true },
    propClass: { type: String, default: "" }
  }
};
</script>

<style>
.modal-backdrop {
  display: none;
}

.background-popup-fade {
  background-color: RGBA(0, 0, 0, 0.5);
}
</style>