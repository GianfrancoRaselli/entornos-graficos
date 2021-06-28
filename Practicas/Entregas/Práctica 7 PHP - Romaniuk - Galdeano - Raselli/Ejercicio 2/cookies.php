<?php
if (!isset($_COOKIE['visitas'])) {
  $visitas = 1;
  setcookie("visitas", $visitas, time() + 3600 * 24 * 365);
} else {
  $visitas = $_COOKIE['visitas'] + 1;
  setcookie("visitas", $visitas, time() + 3600 * 24 * 365);
}
