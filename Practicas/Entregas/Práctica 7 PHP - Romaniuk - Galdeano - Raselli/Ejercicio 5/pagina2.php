<?php
if (isset($_POST['enviar'])) {
    session_start();
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['pass'] = $_POST['pass'];
}
include "pagina3.php";
