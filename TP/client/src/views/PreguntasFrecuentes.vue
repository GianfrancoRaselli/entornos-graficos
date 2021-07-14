<template>
  <div id="accordion" class="help-container mt-4">
    <div class="card">
      <div class="card-header" id="headingOne">
        <h5 class="mb-0">
          <button
            class="btn btn-link"
            data-toggle="collapse"
            data-target="#collapseOne"
            aria-expanded="true"
            aria-controls="collapseOne"
          >¿Cómo creo mi cuenta?</button>
        </h5>
      </div>

      <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="card-body">
          <ol>
            <li class="list-step">
              En primer lugar, desde cualquier parte del sitio, hacer click en el botón ubicado en la esquina superior derecha.
              <utn-button
                btnClass="btn btn-light btn-block"
                icon="fas fa-user-plus"
                style="width:150px;"
              >Crear cuenta</utn-button>
              <img
                class="help-img"
                src="../assets/ayuda/registro1.jpg"
                alt="Imagen de la pagina principal"
              />
            </li>

            <li
              class="list-step"
            >A continuación se desplegará un formulario. Todos los campos son obligatorios</li>
            <img
              class="help-img"
              src="../assets/ayuda/registro2.jpg"
              alt="Imagen del formulario de registro"
            />

            <li
              class="list-step mt-3"
            >Una vez completados todos los campos, hacer click en el botón de crear cuenta</li>

            <li
              class="list-step mt-3"
            >Listo! Su cuenta será verificada por un administrador, este proceso puede demorar algunos días</li>
          </ol>
        </div>
      </div>
    </div>
    <div class="card mt-3">
      <div class="card-header" id="headingTwo">
        <h5 class="mb-0">
          <button
            class="btn btn-link collapsed"
            data-toggle="collapse"
            data-target="#collapseTwo"
            aria-expanded="false"
            aria-controls="collapseTwo"
          >¿Cómo actualizo mi CV?</button>
        </h5>
      </div>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
        <div class="card-body">
          <ol>
            <li class="list-step">
              En la pestaña ubicada en la esquina superior derecha, donde se encuentra nuestro nombre de usuario, ingresar a la sección del perfil
              <br />
              <img
                class="help-img"
                src="../assets/ayuda/perfil1.jpg"
                alt="Donde se encuentra el perfil: Esquina superior derecha"
              />
            </li>
            <li class="list-step">
              En dicha sección podremos editar nuestros datos, cargar un nuevo CV, o ver el actual
              <br />
              <img
                class="help-img"
                src="../assets/ayuda/perfil2.jpg"
                alt="Muestra de las opciones en el perfil"
              />
            </li>
          </ol>
        </div>
      </div>
    </div>
    <div class="card mt-3">
      <div class="card-header" id="headingThree">
        <h5 class="mb-0">
          <button
            class="btn btn-link collapsed"
            data-toggle="collapse"
            data-target="#collapseThree"
            aria-expanded="false"
            aria-controls="collapseThree"
          >¿Cómo me postulo a una vacante?</button>
        </h5>
      </div>
      <div
        id="collapseThree"
        class="collapse"
        aria-labelledby="headingThree"
        data-parent="#accordion"
      >
        <div class="card-body">
          <ol>
            <li class="list-step">
              Usted puede revisar en la sección de inicio cuáles cátedras tienen sus últimas vacantes disponibles. Allí puede hacer click en el botón de "Postularme"
              <br />
              <img class="help-img" src="../assets/ayuda/postularme1.jpg" alt="Donde postularme" />
            </li>
            <li class="list-step mt-3">
              En caso de que la cátedra deseada no se encuentre en la página de inicio, usted puede dirigirse a Vacantes -> Buscar Vacantes, y postularse a la cátedra que desee.
              <br />
              <img
                class="help-img"
                src="../assets/ayuda/postularme2.jpg"
                alt="Donde se encuentra el perfil: Esquina superior derecha"
              />
            </li>
          </ol>
        </div>
      </div>
    </div>
    <div class="card mt-3">
      <div class="card-header" id="headingFour">
        <h5 class="mb-0">
          <button
            class="btn btn-link collapsed"
            data-toggle="collapse"
            data-target="#collapseFour"
            aria-expanded="false"
            aria-controls="collapseFour"
          >¿Dónde veo a que cátedras me encuentro inscripto?</button>
        </h5>
      </div>
      <div
        id="collapseFour"
        class="collapse"
        aria-labelledby="headingFour"
        data-parent="#accordion"
      >
        <div class="card-body">
          <ul>
            <li class="list-step">
              Desde su perfil, usted puede revisar a que vacantes se encuentra postulado
              <br />
              <img
                class="help-img"
                src="../assets/ayuda/mispostulaciones1.jpg"
                alt="Donde postularme"
              />
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="card mt-3">
      <div class="card-header" id="headingFive">
        <h5 class="mb-0">
          <button
            class="btn btn-link collapsed"
            data-toggle="collapse"
            data-target="#collapseFive"
            aria-expanded="false"
            aria-controls="collapseFive"
          >¿Cómo me doy de baja de una postulación?</button>
        </h5>
      </div>
      <div
        id="collapseFive"
        class="collapse"
        aria-labelledby="headingFive"
        data-parent="#accordion"
      >
        <div class="card-body">
          <ul>
            <li class="list-step">
              Desde su perfil, usted puede revisar a que vacantes se encuentra postulado, desde allí puede realizar la acción "Darme de baja"
              <br />
              <img
                class="help-img"
                src="../assets/ayuda/mispostulaciones1.jpg"
                alt="Donde postularme"
              />
            </li>
            <li class="list-step">
              También puede buscar en la lista de vacantes la cátedra en la cual se encuentra postulado, y hacer click en "Darme de baja"
              <br />
              <img class="help-img" src="../assets/ayuda/darmedebaja1.jpg" alt="Donde postularme" />
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style>
.help-container {
  padding: 2.5rem;
}

.help-img {
  overflow: hidden;
  object-fit: cover;
  width: 100%;
  height: 100%;
  max-width: 400px;
  transition: all 0.3s ease-in-out;
}

.help-img:hover {
  transform: scale(1.2);
}
</style>