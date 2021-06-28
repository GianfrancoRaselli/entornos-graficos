<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1> Noticia politicas </h1>
    <h1> Noticia economica </h1>
    <h1> Noticia deportiva </h1>
    <form action="cookie.php" method="Post">
            <p><input type="radio" name="titular" id="titular" value="Noticia deportiva" required>Noticia Deportiva</p>
            <p><input type="radio" name="titular" id="titular" value="Noticia Económica" required>Noticia Económica</p>
            <p><input type="radio" name="titular" id="titular" value="Noticia Política" required>Noticia Política</p>
    <input type="submit" value="enviar" name="enviar">
        </select>
    </form>
    <a href="deletecookie.php">borrar cookie creada</a>
</body>
</html>