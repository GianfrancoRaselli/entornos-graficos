<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2 - Práctica 7</title>
</head>

<body>
    <?php
    include 'cookies.php';
    if ($visitas >= 1) {
        echo "Esta es tu visita número " . $_COOKIE['visitas'];
    } else {
        echo "Bienvenido, esta es la primera vez que visitás esta página";
        echo $visitas;
    }
    ?>
</body>

</html>